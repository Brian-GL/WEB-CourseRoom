<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\UsuariosImagenes;
use Carbon\Carbon;

class DefaultController extends Controller
{
     #region Views

     public function acceso() { return view('default.acceso');}

     public function recuperacion() { return view('default.recuperacion');}

     public function registro(Request $request) {
        //Localidades:

        $localidades = array();

        $url = env('COURSEROOM_API');

        $idEstado = $request->input('IdEstado');
        $idLocalidad = $request->input('IdLocalidad');

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
                'Contrasena' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $correoElectronico = $request->input('CorreoElectronico');
                $contrasena = $request->input('Contrasena');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/usuarios/acceso', [
                        'CorreoElectronico' => $correoElectronico,
                        'Contrasena' => $contrasena
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        //Session middleware:
                        $session = $request->session()->get('AUTH_TOKEN', '');
                        if(empty($session))
                            $request->session()->push('AUTH_TOKEN', env("APP_KEY"));

                        return response()->json(['code' => 200 , 'data' => $result], 200);

                    } else{
                        return response()->json(['code' => 500 , 'data' => $response->body()], 200);
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

                $correoElectronico = $request->input('CorreoElectronico');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/usuarios/credenciales', [
                        'CorreoElectronico' => $correoElectronico
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());
                        return response()->json(['code' => 200 , 'data' => $result], 200);

                    } else{
                        return response()->json(['code' => 500 , 'data' => $response->body()], 200);
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
        return response()->json(['code' => 200 , 'data' => $request->all()], 200);

        // try {

        //     $validator = Validator::make($request->all(), $rules = [
        //         'Nombre' => ['required'],
        //         'Paterno' => ['required'],
        //         'IdLocalidad' => ['required'],
        //         'IdTipoUsuario' => ['required'],
        //         'CorreoElectronico' => ['required'],
        //         'Contrasena' => ['required']
        //     ], $messages = [
        //         'required' => 'El campo :attribute es requerido'
        //     ]);

        //     if ($validator->fails()) {
        //         return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
        //     } else {

        //         $url = env('COURSEROOM_API');

        //         $Nombre = $request->input('Nombre');
        //         $Paterno = $request->input('Paterno');
        //         $Materno = $request->input('Materno');
        //         $FechaNacimiento = $request->input('FechaNacimiento');
        //         $Genero = $request->input('Genero');
        //         $Descripcion = $request->input('Descripcion');
        //         $IdLocalidad = $request->input('IdLocalidad');
        //         $IdTipoUsuario = $request->input('IdTipoUsuario');
        //         $CorreoElectronico = $request->input('CorreoElectronico');
        //         $Contrasena = $request->input('Contrasena');
               
        //         if($url != ''){

        //             $response = Http::withHeaders([
        //                 'Authorization' => env('COURSEROOM_API_KEY'),
        //             ])->post($url.'/api/usuarios/registrar', [
        //                 'Nombre' => $Nombre,
        //                 'Paterno' => $Paterno,
        //                 'Materno' => $Materno,
        //                 'FechaNacimiento' => $FechaNacimiento,
        //                 'Genero' => $Genero,
        //                 'Descripcion' => $Descripcion,
        //                 'IdLocalidad' => $IdLocalidad,
        //                 'IdTipoUsuario' => $IdTipoUsuario,
        //                 'CorreoElectronico' => $CorreoElectronico,
        //                 'Contrasena' => $Contrasena,
        //                 'ChatsConmigo' => true,
        //                 'MostrarAvisos' => true,
        //                 'Imagen' => null,
        //             ]);

        //             if ($response->ok()){

        //                 $result = json_decode($response->body());

        //                 //Guardar imagen en mongo si no esta vácia:

        //                 if($Imagen != null ){

        //                     $mongoUsuariosImagenes = new UsuariosImagenes;

        //                     $mongoUsuariosImagenes->idUsuario = $result->codigo;
        //                     $mongoUsuariosImagenes->imagen = $Imagen;
        //                     $mongoUsuariosImagenes->fecha = Carbon::now();

        //                     $mongoUsuariosImagenes->save();
        //                 }

        //                 if($request->hasFile('Imagen')){
        //                     $image = $request->file('Imagen');
        //                     $fileName = $result->codigo.'.'. $image->getClientOriginalExtension();

        //                     $img = Image::make($image->getRealPath());
        //                     $img->resize(450, 450, function ($constraint) {
        //                         $constraint->aspectRatio();                 
        //                     });

        //                     $img->stream(); 
        //                     Storage::disk('local')->put('images/users/'.$fileName, $img, 'public');
        //                 }

        //                 //Session middleware:
        //                 $session = $request->session()->get('AUTH_TOKEN', '');
        //                 if(empty($session))
        //                     $request->session()->push('AUTH_TOKEN', env("APP_KEY"));

        //                 return response()->json(['code' => 200 , 'data' => $result], 200);

        //             } else{
        //                 return response()->json(['code' => 500 , 'data' => $response->body()], 200);
        //             }

        //         } else{
        //             return response()->json(['code' => 404 , 'data' => 'Empty url'], 200);
        //         }
        //     }

        // } catch (\Throwable $th) {
        //     return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        // }
     }

     #endregion
}
