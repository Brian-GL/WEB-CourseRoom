<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
{
    #region View

    public function perfil(){

        $localidades = array();
        $tipos_usuario = array();
        return view('usuarios.perfil', compact('localidades','tipos_usuario'));
    }

    #endregion


    #region Ajax

    public function usuario_actualizar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuario' => ['required'],
                'Nombre' => ['required'],
                'Paterno' => ['required'],
                'IdLocalidad' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = $request->input('IdUsuario');
                $nombre = $request->input('Nombre');
                $paterno = $request->input('Paterno');
                $materno = $request->input('Materno');
                $fechaNacimiento = $request->input('FechaNacimiento');
                $genero = $request->input('Genero');
                $descripcion = $request->input('Descripcion');
                $idLocalidad = $request->input('IdLocalidad');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/usuarios/actualizar', [
                        'IdUsuario' => $idUsuario,
                        'Nombre' => $nombre,
                        'Paterno' => $paterno,
                        'Materno' => $materno,
                        'FechaNacimiento' => $fechaNacimiento,
                        'Genero' => $genero,
                        'Descripcion' => $descripcion,
                        'IdLocalidad' => $idLocalidad
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

    public function usuario_remover(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuario' => ['required'],
                'IdTipoUsuario' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = $request->input('IdUsuario');
                $idTipoUsuario = $request->input('IdTipoUsuario');

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

    public function usuariocuenta_obtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuario' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = $request->input('IdUsuario');

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

    public function usuariodesempeno_obtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuario' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = $request->input('IdUsuario');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/usuarios/desempeno', [
                        'IdUsuario' => $idUsuario
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

    public function usuariodesempeno_registrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuario' => ['required'],
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

                $idUsuario = $request->input('IdUsuario');
                $idTarea = $request->input('IdTarea');
                $calificacion = $request->input('Calificacion');
                $promedioCurso = $request->input('PromedioCurso');
                $prediccionPromedioCurso = $request->input('PrediccionPromedioCurso');
                $rumboPromedioCurso = $request->input('RumboPromedioCurso');
                $promedioGeneral = $request->input('PromedioGeneral');
                $prediccionPromedioGeneral = $request->input('PrediccionPromedioGeneral');
                $rumboPromedioGeneral = $request->input('RumboPromedioGeneral');
                $puntualidadCurso = $request->input('PuntualidadCurso');
                $prediccionPuntualidadCurso = $request->input('PrediccionPuntualidadCurso');
                $rumboPuntualidadCurso = $request->input('RumboPuntualidadCurso');
                $puntualidadGeneral = $request->input('PuntualidadGeneral');
                $prediccionPuntualidadGeneral = $request->input('PrediccionPuntualidadGeneral');
                $rumboPuntualidadGeneral = $request->input('RumboPuntualidadGeneral');

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

    public function usuariodetalle_obtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuario' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = $request->input('IdUsuario');

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

    public function usuarionuevapuntualidadcurso_obtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],
                'IdUsuario' => ['required'],
                'Puntualidad' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request->input('IdCurso');
                $idUsuario = $request->input('IdUsuario');
                $puntualidad = $request->input('Puntualidad');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/usuarios/nuevapuntualidad', [
                        'IdCurso' => $idCurso,
                        'IdUsuario' => $idUsuario,
                        'Puntualidad' => $puntualidad
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

    public function usuarionuevapuntualidadgeneral_obtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuario' => ['required'],
                'Puntualidad' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = $request->input('IdUsuario');
                $puntualidad = $request->input('Puntualidad');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/usuarios/nuevapuntualidadgeneral', [
                        'IdUsuario' => $idUsuario,
                        'Puntualidad' => $puntualidad
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

    public function usuarionuevopromediocurso_obtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],
                'IdUsuario' => ['required'],
                'Calificacion' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request->input('IdCurso');
                $idUsuario = $request->input('IdUsuario');
                $calificacion = $request->input('Calificacion');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/usuarios/nuevopromedio', [
                        'IdCurso' => $idCurso,
                        'IdUsuario' => $idUsuario,
                        'Calificacion' => $calificacion
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

    public function usuarionuevopromediogeneral_obtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuario' => ['required'],
                'Calificacion' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = $request->input('IdUsuario');
                $calificacion = $request->input('Calificacion');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/usuarios/nuevopromediogeneral', [
                        'IdUsuario' => $idUsuario,
                        'Calificacion' => $calificacion
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

    public function usuarios_buscar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $nombre = $request->input('Nombre');
                $paterno = $request->input('Paterno');
                $materno = $request->input('Materno');

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

    public function usuariosesion_actualizar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuario' => ['required'],
                'IdSesion' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = $request->input('IdUsuario');
                $idSesion = $request->input('IdSesion');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/usuarios/sesion', [
                        'IdUsuario' => $idUsuario,
                        'IdSesion' => $idSesion
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

    public function usuariosesion_registrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuario' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = $request->input('IdUsuario');
                $dispositivo = $request->input('Dispositivo');
                $fabricante = $request->input('Fabricante');
                $direccionIP = $request->input('DireccionIP');
                $direccionMAC = $request->input('DireccionMAC');
                $userAgent = $request->input('UserAgent');
                $navegador = $request->input('Navegador');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/usuarios/sesionregistrar', [
                        'IdUsuario' => $idUsuario,
                        'Dispositivo' => $dispositivo,
                        'Fabricante' => $fabricante,
                        'DireccionIP' => $direccionIP,
                        'DireccionMAC' => $direccionMAC,
                        'UserAgent' => $userAgent,
                        'Navegador' => $navegador
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

    public function usuariosesion_validar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuario' => ['required'],
                'IdSesion' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = $request->input('IdUsuario');
                $idSesion = $request->input('IdSesion');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/usuarios/sesionvalidar', [
                        'IdUsuario' => $idUsuario,
                        'IdSesion' => $idSesion
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

    public function usuariosesiones_obtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuario' => ['required'],
                'Activa' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = $request->input('IdUsuario');
                $activa = $request->input('Activa');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/usuarios/sesiones', [
                        'IdUsuario' => $idUsuario,
                        'Activa' => $activa
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

    public function usuariotematica_registrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuario' => ['required'],
                'IdTematica' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = $request->input('IdUsuario');
                $idTematica = $request->input('IdTematica');

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

    public function usuariotematica_remover(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuario' => ['required'],
                'IdTematica' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = $request->input('IdUsuario');
                $idTematica = $request->input('IdTematica');

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

    public function usuariotematicas_obtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuario' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = $request->input('IdUsuario');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/usuarios/tematicasobtener', [
                        'IdUsuario' => $idUsuario
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

    #endregion

}
