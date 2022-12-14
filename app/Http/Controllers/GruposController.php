<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GruposController extends Controller
{
    #region Views

    #endregion

    #region AJAX

    public function grupo_actualizar(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required'],
                'IdCurso' => ['required'],
                'Nombre' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->input('IdGrupo');
                $idCurso = $request->input('IdCurso');
                $nombre = $request->input('Nombre');
                $descripcion = $request->input('Descripcion');
                $imagen = $request->input('Imagen');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/grupos/actualizar', [
                        'IdGrupo' => $idGrupo,
                        'IdCurso' => $idCurso,
                        'Nombre' => $nombre,
                        'Descripcion' => $descripcion,
                        'Imagen' => $imagen
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

    public function gruposmensajes_obtener(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required'],
                'UltimoMensaje' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->input('IdGrupo');
                $ultimoMensaje = $request->input('UltimoMensaje');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/grupos/mensajes', [
                        'IdGrupo' => $idGrupo,
                        'UltimoMensaje' => $ultimoMensaje
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

    public function grupos_obtener(Request $request){
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
                    ])->post($url.'/api/grupos/obtener', [
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

    public function grupomiembros_obtener(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->input('IdGrupo');
                $idUsuario = $request->input('IdUsuario');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/grupos/miembros', [
                        'IdGrupo' => $idGrupo,
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

    public function grupotareaspendientes_obtener(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->input('IdGrupo');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/grupos/tareaspendientes', [
                        'IdGrupo' => $idGrupo
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

    public function grupotareapendientedetalle_obtener(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdTareaPendiente' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idTareaPendiente = $request->input('IdTareaPendiente');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/grupos/tareapendientedetalle', [
                        'IdTareaPendiente' => $idTareaPendiente
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

    public function grupotareapendienteestatus_actualizar(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required'],
                'IdTareaPendiente' => ['required'],
                'IdUsuarioReceptor' => ['required'],
                'IdEstatusTareaPendiente' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->input('IdGrupo');
                $idTareaPendiente = $request->input('IdTareaPendiente');
                $idUsuarioReceptor = $request->input('IdUsuarioReceptor');
                $idEstatusTareaPendiente = $request->input('IdEstatusTareaPendiente');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/grupos/tareapendienteestatus', [
                        'IdGrupo' => $idGrupo,
                        'IdTareaPendiente' => $idTareaPendiente,
                        'IdUsuarioReceptor' => $idUsuarioReceptor,
                        'IdEstatusTareaPendiente' => $idEstatusTareaPendiente
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

    public function grupomiembro_remover(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required'],
                'IdProfesor' => ['required'],
                'IdUsuario' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->input('IdGrupo');
                $idProfesor = $request->input('IdProfesor');
                $idUsuario = $request->input('IdUsuario');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/grupos/miembroremover', [
                        'IdGrupo' => $idGrupo,
                        'IdProfesor' => $idProfesor,
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

    public function grupomiembro_registrar(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required'],
                'IdProfesor' => ['required'],
                'IdCurso' => ['required'],
                'IdUsuario' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->input('IdGrupo');
                $idProfesor = $request->input('IdProfesor');
                $idCurso = $request->input('IdCurso');
                $idUsuario = $request->input('IdUsuario');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/grupos/miembroregistrar', [
                        'IdGrupo' => $idGrupo,
                        'IdProfesor' => $idProfesor,
                        'IdCurso' => $idCurso,
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

    public function grupotareapendiente_actualizar(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required'],
                'IdUsuario' => ['required'],
                'IdTareaPendiente' => ['required'],
                'Nombre' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->input('IdGrupo');
                $idUsuario = $request->input('IdUsuario');
                $idTareaPendiente = $request->input('IdTareaPendiente');
                $nombre = $request->input('Nombre');
                $descripcion = $request->input('Descripcion');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/grupos/tareapendienteactualizar', [
                        'IdGrupo' => $idGrupo,
                        'IdUsuario' => $idUsuario,
                        'IdTareaPendiente' => $idTareaPendiente,
                        'Nombre' => $nombre,
                        'Descripcion' => $descripcion
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

    public function grupotareapendiente_registrar(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required'],
                'IdUsuarioEmisor' => ['required'],
                'IdUsuarioReceptor' => ['required'],
                'Nombre' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->input('IdGrupo');
                $idUsuarioEmisor = $request->input('IdUsuarioEmisor');
                $idUsuarioReceptor = $request->input('IdUsuarioReceptor');
                $nombre = $request->input('Nombre');
                $descripcion = $request->input('Descripcion');
                $fechaFinalizacion = $request->input('FechaFinalizacion');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/grupos/tareapendienteregistrar', [
                        'IdGrupo' => $idGrupo,
                        'IdUsuarioEmisor' => $idUsuario,
                        'idUsuarioReceptor' => $idUsuarioReceptor,
                        'Nombre' => $nombre,
                        'Descripcion' => $descripcion,
                        'FechaFinalizacion' => $fechaFinalizacion
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
