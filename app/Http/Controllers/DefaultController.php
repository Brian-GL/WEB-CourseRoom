<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\UsuariosImagenes;

class DefaultController extends Controller
{
     #region Views

     public function acceso() { return view('default.acceso');}

     public function recuperacion() { return view('default.recuperacion');}

     public function registro() {

        //Localidades:
        $localidades = array();

        $url = env('COURSEROOM_API');

        if($url != ''){

            $response = Http::withHeaders([
                'Authorization' => env('COURSEROOM_API_KEY'),
            ])->post($url.'/api/catalogos/localidades', [
                'IdEstado' => null,
                'Idlocalidad' => null
            ]);

            if ($response->ok()){
                $localidades = json_decode($response->body());
            }
        }

        //Tipo de usuario:
        $tipos_usuario = array();

        $response = Http::withHeaders([
            'Authorization' => env('COURSEROOM_API_KEY'),
        ])->post($url.'/api/catalogos/tiposusuario', [
            'IdTipoUsuario' => null
        ]);

        if ($response->ok()){
            $tipos_usuario = json_decode($response->body());
        }

         return view('default.registro', compact('localidades','tipos_usuario'));
     }

     #endregion

     #region Ajax

     public function acceder(Request $request){

        try {

            $validator = Validator::make($request->all(), $rules = [
                'CorreoElectronico' => ['required'],
                'Contrasena' => ['required'],
                'Dispositivo' => ['required'],
                'Navegador' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $correoElectronico = $request->string('CorreoElectronico')->trim();
                $contrasena = $request->string('Contrasena');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/usuarios/acceso', [
                        'CorreoElectronico' => $correoElectronico,
                        'Contrasena' => $contrasena
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        if($result->idUsuario > 0){

                            $IdUsuario = $result->idUsuario;
                            $IdTipoUsuario = $result->idTipoUsuario;

                            //Registrar sesion:

                            $Dispositivo = $request->string('Dispositivo')->trim();
                            $Fabricante = $request->string('Fabricante')->trim();
                            $Navegador = $request->string('Navegador')->trim();

                            $response = Http::withHeaders([
                                'Authorization' => env('COURSEROOM_API_KEY'),
                            ])->post($url.'/api/usuarios/sesionregistrar', [
                                'IdUsuario' => $IdUsuario,
                                'Dispositivo' => $Dispositivo,
                                'Fabricante' => $Fabricante,
                                'DireccionIP' => $request->ip(),
                                'DireccionMAC' => substr(exec('getmac'), 0, 17),
                                'UserAgent' => $request->server('HTTP_USER_AGENT'),
                                'Navegador' => $Navegador
                            ]);

                            $IdSesion = null;

                            if ($response->ok()){
                                $result = json_decode($response->body());
                                
                                if($result->codigo > 0){
                                    $IdSesion = $result->codigo;
                                }
                            }

                            //Obtener información imagen desde mongo:
                            $element = UsuariosImagenes::where('idUsuario', '=', $IdUsuario)->first();

                            $Imagen = '';
                            if(!is_null($element)){
                                $Imagen = $element->imagen;
                            }

                            //Session middleware:
                            $session = session('AUTH_TOKEN');
                            if(is_null($session)){
                                session(['AUTH_TOKEN' => env("APP_KEY")]);
                                session(['IdUsuario' => $IdUsuario]);
                                session(['IdSesion' => $IdSesion]);
                                session(['IdTipoUsuario' => $IdTipoUsuario]);
                                session(['Imagen' => $Imagen]);
                            }

                            return response()->json(['code' => 200 , 'data' => $result], 200);

                        } else{
                            return response()->json(['code' => 400 , 'data' => $result->data], 200);
                        }

                    } else{
                        return response()->json(['code' => 400 , 'data' => $response->body()], 200);
                    }

                } else{
                    return response()->json(['code' => 404 , 'data' => 'Empty url'], 200);
                }
            }

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        }
     }

     public function recuperacion_credenciales(Request $request)
     {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'CorreoElectronico' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $correoElectronico = $request->string('CorreoElectronico')->trim();

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/usuarios/credencial', [
                        'CorreoElectronico' => $correoElectronico
                    ]);

                    if ($response->ok()){
                        $result = json_decode($response->body());
                        return response()->json(['code' => 200 , 'data' => $result], 200);

                    } else{
                        return response()->json(['code' => 400 , 'data' => $response->body()], 200);
                    }

                } else{
                    return response()->json(['code' => 404 , 'data' => 'Empty url'], 200);
                }
            }

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        }
     }

     public function registrar_usuario(Request  $request)
     {

        try {

            $validator = Validator::make($request->all(), $rules = [
                'Nombre' => ['required'],
                'Paterno' => ['required'],
                'IdLocalidad' => ['required', 'min:1', 'integer'],
                'IdTipoUsuario' => ['required', 'min:1', 'integer'],
                'CorreoElectronico' => ['required'],
                'Contrasena' => ['required'],
                'FechaNacimiento' => ['required', 'date'],
                'Dispositivo' => ['required'],
                'Navegador' => ['required'],
            ], $messages = [
                'required' => 'El campo :attribute es requerido',
                'min' => 'El campo :attribute presenta un valor mínimo no permitido',
                'integer' => 'El campo :attribute debe ser un número entero',
                'date' => 'El campo :attribute debe ser una fecha'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $Nombre = $request->string('Nombre')->trim();
                $Paterno = $request->string('Paterno')->trim();
                $Materno = $request->string('Materno')->trim();
                $FechaNacimiento = $request->date('FechaNacimiento');
                $Genero = $request->string('Genero')->trim();
                $Descripcion = $request->string('Descripcion')->trim();
                $IdLocalidad = $request->integer('IdLocalidad');
                $IdTipoUsuario = $request->integer('IdTipoUsuario');
                $CorreoElectronico = $request->string('CorreoElectronico')->trim();
                $Contrasena = $request->string('Contrasena');
                $Base64Imagen= $request->input('Base64Imagen');
                $filename = null;

                if($request->hasFile('Imagen')) {
                    $filename = time().'_'.$request->file('Imagen')->getClientOriginalName();
                }
               
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/usuarios/registrar', [
                        'Nombre' => $Nombre,
                        'Paterno' => $Paterno,
                        'Materno' => $Materno,
                        'FechaNacimiento' => $FechaNacimiento,
                        'Genero' => $Genero,
                        'Descripcion' => $Descripcion,
                        'IdLocalidad' => $IdLocalidad,
                        'IdTipoUsuario' => $IdTipoUsuario,
                        'CorreoElectronico' => $CorreoElectronico,
                        'Contrasena' => $Contrasena,
                        'ChatsConmigo' => true,
                        'MostrarAvisos' => true,
                        'Imagen' => $filename
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        if($result->codigo > 0){

                            $IdUsuario = $result->codigo;
                            $Imagen = '';

                            if($filename != null){

                                $file = $request->file('Imagen');

                                // File extension
                                $extension = $file->getClientOriginalExtension();

                                //Guardar imagen en mongo si no esta vácia:
                                $mongoUsuariosImagenes = new UsuariosImagenes;

                                $mongoUsuariosImagenes->idUsuario = $IdUsuario;
                                $mongoUsuariosImagenes->imagen = $Base64Imagen;
                                $mongoUsuariosImagenes->extension = $extension;

                                $mongoUsuariosImagenes->save();

                                //Guardar imagen en storage:
                                Storage::putFileAs('usuarios', $file, $filename);
                            }

                            //Registrar sesion:

                            $Dispositivo = $request->string('Dispositivo')->trim();
                            $Fabricante = $request->string('Fabricante')->trim();
                            $Navegador = $request->string('Navegador')->trim();

                            $response = Http::withHeaders([
                                'Authorization' => env('COURSEROOM_API_KEY'),
                            ])->post($url.'/api/usuarios/sesionregistrar', [
                                'IdUsuario' => $IdUsuario,
                                'Dispositivo' => $Dispositivo,
                                'Fabricante' => $Fabricante,
                                'DireccionIP' => $request->ip(),
                                'DireccionMAC' => substr(exec('getmac'), 0, 17),
                                'UserAgent' => $request->server('HTTP_USER_AGENT'),
                                'Navegador' => $Navegador
                            ]);

                            $IdSesion = null;
                            if ($response->ok()){

                                $result = json_decode($response->body());
                                
                                if($result->codigo > 0){
                                    $IdSesion = $result->codigo;
                                }
                            }

                            //Session middleware:
                            $session = session('AUTH_TOKEN');
                            if(is_null($session)){
                                session(['AUTH_TOKEN' => env("APP_KEY")]);
                                session(['IdUsuario' => $IdUsuario]);
                                session(['IdSesion' => $IdSesion]);
                                session(['IdTipoUsuario' => $IdTipoUsuario]);
                                session(['Imagen' => $Base64Imagen]);
                            }

                            return response()->json(['code' => 200 , 'data' => '¡El usuario ha sido registrado correctamente!'], 200);

                        } else{
                            return response()->json(['code' => 400 , 'data' => $result->data], 200);                            
                        }
                    } else{
                        return response()->json(['code' => 400 , 'data' => $response->body()], 200);
                    }

                } else{
                    return response()->json(['code' => 404 , 'data' => 'Empty url'], 200);
                }
            }

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        }
     }

     #endregion
}
