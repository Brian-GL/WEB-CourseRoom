<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\UsuariosImagenes;
use Illuminate\Support\Facades\Storage;

class UsuariosController extends Controller
{
    #region View

    public function perfil(){

        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');
        $IdTipoUsuario = session('IdTipoUsuario');

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

        return view('usuarios.perfil', compact('localidades','tipos_usuario', 'DatosUsuario', 'DatosCuenta', 'IdTipoUsuario'));
    }

    public function sesiones(){
        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');
        $IdTipoUsuario = session('IdTipoUsuario');
        
        return view('usuarios.sesiones', compact('DatosUsuario', 'DatosCuenta', 'IdTipoUsuario'));
    }

    public function mi_desempeno(){
        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');
        $IdTipoUsuario = session('IdTipoUsuario');
        
        return view('usuarios.desempenousuario', compact('DatosUsuario', 'DatosCuenta', 'IdTipoUsuario'));
    }

    #endregion


    #region Ajax

    public function usuario_actualizar(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $rules = [
                'Nombre' => ['required'],
                'Paterno' => ['required'],
                'IdLocalidad' => ['required', 'min:1', 'integer'],
                'CorreoElectronico' => ['required'],
                'Contrasena' => ['required'],
                'FechaNacimiento' => ['required', 'date'],
                'ChatsConmigo' => ['required'],
                'MostrarAvisos' => ['required']
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

                $IdUsuario = session('IdUsuario');
                $nombre = $request->string('Nombre')->trim();
                $paterno = $request->string('Paterno')->trim();
                $materno = $request->string('Materno')->trim();
                $fechaNacimiento = $request->date('FechaNacimiento');
                $genero = $request->string('Genero')->trim();
                $descripcion = $request->string('Descripcion')->trim();
                $idLocalidad = $request->integer('IdLocalidad');
                $correoElectronico = $request->string('CorreoElectronico')->trim();
                $contrasena = $request->string('Contrasena');
                $chatsConmigo = $request->boolean('ChatsConmigo');
                $mostrarAvisos = $request->boolean('MostrarAvisos');
                $Base64Image = $request->input('Base64Image');
                $ImagenAnterior = $request->string('ImagenAnterior');

                $filename = $ImagenAnterior;
                if($request->hasFile('Imagen')) {
                    $filename = time().'_'.$request->file('Imagen')->getClientOriginalName();
                }

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/usuarios/actualizar', [
                        'IdUsuario' => $IdUsuario,
                        'Nombre' => $nombre,
                        'Paterno' => $paterno,
                        'Materno' => $materno,
                        'FechaNacimiento' => $fechaNacimiento,
                        'Genero' => $genero,
                        'Descripcion' => $descripcion,
                        'IdLocalidad' => $idLocalidad
                    ]);

                    if ($response->ok()){

                        $response = Http::withHeaders([
                            'Authorization' => env('COURSEROOM_API_KEY'),
                        ])->put($url.'/api/usuarios/cuenta', [
                            'IdUsuario' => $IdUsuario,
                            'CorreoElectronico' => $correoElectronico,
                            'Contrasena' => $contrasena,
                            'ChatsConmigo' => $chatsConmigo,
                            'MostrarAvisos' => $mostrarAvisos,
                            'Imagen' => $filename
                        ]);
    
                        if ($response->ok()){

                            //Actualizar imagen
                            if($filename != $ImagenAnterior){

                                $file = $request->file('Imagen');

                                // File extension
                                $extension = $file->getClientOriginalExtension();

                                //Actualizar imagen en mongo si no esta vácia:
                                $mongoUsuariosImagenes = UsuariosImagenes::where('idUsuario', $IdUsuario)->first();

                                if(!is_null($mongoUsuariosImagenes)){
                                    $mongoUsuariosImagenes->update(
                                        ['imagen' => $Base64Image,
                                        'extension' => $extension]);
                                }

                                Storage::delete('usuarios/'.$ImagenAnterior);
                                //Guardar imagen en storage:
                                Storage::putFileAs('usuarios', $file, $filename);
                            }
    
                            $request->session()->forget(['DatosUsuario', 'DatosCuenta']);
                            
                            $result = json_decode($response->body());

                            return response()->json(['code' => 200 , 'data' => $result], 200);
                            
                        } else{
                            return response()->json(['code' => 400 , 'data' => $response->body()], 200);
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

    public function usuario_remover(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdTipoUsuario' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $IdUsuario = session('IdUsuario');
                $idTipoUsuario = $request->integer('IdTipoUsuario');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/usuarios/remover', [
                        'IdUsuario' => $idUsuario,
                        'IdTipoUsuario' => $idTipoUsuario
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

    public function usuarioacceso_obtener(Request $request)
    {
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

                $correoElectronico = $request->string('CorreoElectronico')->trim();
                $contrasena = $request->string('Contrasena')->trim();

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/usuarios/acceso', [
                        'CorreoElectronico' => $correoElectronico,
                        'Contrasena' => $contrasena
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
    
    public function usuariocuenta_actualizar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'CorreoElectronico' => ['required'],
                'Contrasena' => ['required'],
              
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $IdUsuario = session('IdUsuario');
                $correoElectronico = $request->string('CorreoElectronico')->trim();
                $contrasena = $request->string('Contrasena')->trim();
                $chatsConmigo = $request->boolean('ChatsConmigo');
                $mostrarAvisos = $request->boolean('MostrarAvisos');
                $imagen = $request->string('Imagen')->trim();

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/usuarios/cuenta', [
                        'IdUsuario' => $idUsuario,
                        'CorreoElectronico' => $correoElectronico,
                        'Contrasena' => $contrasena,
                        'ChatsConmigo' => $chatsConmigo,
                        'MostrarAvisos' => $mostrarAvisos,
                        'Imagen' => $imagen
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

    public function usuariocuenta_obtener(Request $request)
    {
        try {

            $url = env('COURSEROOM_API');

            $IdUsuario = session('IdUsuario');

            if($url != ''){

                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/usuarios/cuentaobtener', [
                    'IdUsuario' => $idUsuario
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

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        }
    }

    public function usuariodesempeno_obtener(Request $request)
    {
        try {

            $url = env('COURSEROOM_API');

            if($url != ''){

                $IdUsuario = session('IdUsuario');

                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/usuarios/desempeno', [
                    'IdUsuario' => $IdUsuario
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

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        }
    }

    public function usuariodesempeno_registrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdTarea' => ['required'],
                'Calificacion' => ['required'],
                'PromedioCurso' => ['required'],
                'PromedioGeneral' => ['required'],
                'PuntualidadCurso' => ['required'],
                'PuntualidadGeneral' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $IdUsuario = session('IdUsuario');
                $idTarea = $request->integer('IdTarea');
                $calificacion = $request->float('Calificacion');
                $promedioCurso = $request->float('PromedioCurso');
                $prediccionPromedioCurso = $request->float('PrediccionPromedioCurso');
                $rumboPromedioCurso = $request->string('RumboPromedioCurso')->trim();
                $promedioGeneral = $request->float('PromedioGeneral');
                $prediccionPromedioGeneral = $request->float('PrediccionPromedioGeneral');
                $rumboPromedioGeneral = $request->string('RumboPromedioGeneral')->trim();
                $puntualidadCurso = $request->float('PuntualidadCurso');
                $prediccionPuntualidadCurso = $request->float('PrediccionPuntualidadCurso');
                $rumboPuntualidadCurso = $request->string('RumboPuntualidadCurso')->trim();
                $puntualidadGeneral = $request->float('PuntualidadGeneral');
                $prediccionPuntualidadGeneral = $request->float('PrediccionPuntualidadGeneral');
                $rumboPuntualidadGeneral = $request->string('RumboPuntualidadGeneral')->trim();

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/usuarios/desempenoregistrar', [
                        'IdUsuario' => $idUsuario,
                        'IdTarea' => $idTarea,
                        'Calificacion' => $calificacion,
                        'PromedioCurso' => $promedioCurso,
                        'PrediccionPromedioCurso' => $prediccionPromedioCurso,
                        'RumboPromedioCurso' => $rumboPromedioCurso,
                        'PromedioGeneral' => $promedioGeneral,
                        'PrediccionPromedioGeneral' => $prediccionPromedioGeneral,
                        'RumboPromedioGeneral' => $rumboPromedioGeneral,
                        'PuntualidadCurso' => $puntualidadCurso,
                        'PrediccionPuntualidadCurso' => $prediccionPuntualidadCurso,
                        'RumboPuntualidadCurso' => $rumboPuntualidadCurso,
                        'PuntualidadGeneral' => $puntualidadGeneral,
                        'PrediccionPuntualidadGeneral' => $prediccionPuntualidadGeneral,
                        'RumboPuntualidadGeneral' => $rumboPuntualidadGeneral
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

    public function usuariodetalle_obtener(Request $request)
    {
        try {

            $url = env('COURSEROOM_API');

            $IdUsuario = session('IdUsuario');

            if($url != ''){

                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/usuarios/detalle', [
                    'IdUsuario' => $idUsuario
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

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        }
    }

    public function usuarios_buscar(Request $request)
    {
        try {

            $url = env('COURSEROOM_API');

            $nombre = null;
            $paterno = null;
            $materno = null;

            if($request->has('Nombre')){
                $nombre = $request->string('Nombre')->trim();
            }

            if($request->has('Paterno')){
                $paterno = $request->string('Paterno')->trim();
            }

            if($request->has('Materno')){
                $materno = $request->string('Materno')->trim();
            }
            
            if($url != ''){

                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/usuarios/buscar', [
                    'Nombre' => $nombre,
                    'Paterno' => $paterno,
                    'Materno' => $materno
                ]);

                if ($response->ok()){

                    $result = json_decode($response->body());

                    foreach($result as &$user){
                        //Obtener información imagen desde mongo:
                        $element = UsuariosImagenes::where('idUsuario', '=', $user->idUsuario)->first();

                        if(!is_null($element)){
                            $user->imagen = $element->imagen;
                        }
                    }

                    return response()->json(['code' => 200 , 'data' => $result], 200);

                } else{
                    return response()->json(['code' => 400 , 'data' => $response->body()], 200);
                }

            } else{
                return response()->json(['code' => 404 , 'data' => 'Empty url'], 200);
            }

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        }
    }

    public function usuariosesion_actualizar(Request $request)
    {
        try {

            $url = env('COURSEROOM_API');

            $IdUsuario = session('IdUsuario');
            $IdSesion = session('IdSesion');

            if($url != ''){

                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->put($url.'/api/usuarios/sesion', [
                    'IdUsuario' => $IdUsuario,
                    'IdSesion' => $IdSesion
                ]);

                if ($response->ok()){

                    $result = json_decode($response->body());

                    //Limpiar session:
                    $request->session()->invalidate();

                    return response()->json(['code' => 200 , 'data' => $result], 200);

                } else{
                    return response()->json(['code' => 400 , 'data' => $response->body()], 200);
                }

            } else{
                return response()->json(['code' => 404 , 'data' => 'Empty url'], 200);
            }

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        }
    }

    public function usuariosesiones_obtener(Request $request)
    {
        try {

            $url = env('COURSEROOM_API');

            $IdUsuario = session('IdUsuario');

            if($url != ''){

                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/usuarios/sesiones', [
                    'IdUsuario' => $IdUsuario,
                    'Activa' => null
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

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        }
    }

    public function usuariotematica_registrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdTematica' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $IdUsuario = session('IdUsuario');
                $idTematica = $request->integer('IdTematica');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/usuarios/tematica', [
                        'IdUsuario' => $idUsuario,
                        'IdTematica' => $idTematica
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

    public function usuariotematica_remover(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdTematica' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $IdUsuario = session('IdUsuario');
                $idTematica = $request->integer('IdTematica');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/usuarios/tematicaremover', [
                        'IdUsuario' => $idUsuario,
                        'IdTematica' => $idTematica
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

    public function usuariotematicas_obtener(Request $request)
    {
        try {

            $url = env('COURSEROOM_API');

            $IdUsuario = session('IdUsuario');

            if($url != ''){

                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/usuarios/tematicasobtener', [
                    'IdUsuario' => $IdUsuario
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
            

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        }
    }

    public function usuariocalculatorinformacion_obtener(Request $request)
    {
        try {

            $url = env('COURSEROOM_CALCULATOR');

            $IdUsuario = session('IdUsuario');

            if($url != ''){

                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url, [
                   'method' => 'RpcServer.InformacionDesempeno',
                   'params' => [
                    [
                        'IdUsuario' => $IdUsuario
                    ]
                   ],
                   'id' => 0
                ]);

                $result = json_decode($response->body());

                if ($response->ok() && $result->error == null){
                    return response()->json(['code' => $result->result->status , 'data' => $result->result->data], 200);
                } else{
                    return response()->json(['code' => 400 , 'data' => $result->error], 200);
                }

            } else{
                return response()->json(['code' => 404 , 'data' => 'Empty url'], 200);
            }
            

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        }
    }

    #endregion

}
