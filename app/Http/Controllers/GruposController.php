<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

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

                $idGrupo = $request->integer('IdGrupo');
                $idCurso = $request->integer('IdCurso');
                $nombre = $request->string('Nombre')->trim();
                $descripcion = $request->string('Descripcion')->trim();
                $imagen = $request->string('Imagen')->trim();

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

                $idGrupo = $request->integer('IdGrupo');
                $ultimoMensaje = $request->integer('UltimoMensaje');

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

            $url = env('COURSEROOM_API');

            $IdUsuario = (int)$request->session()->get('IdUsuario', 0);

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

                $idGrupo = $request->integer('IdGrupo');
                $IdUsuario = (int)$request->session()->get('IdUsuario', 0);

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

                $idGrupo = $request->integer('IdGrupo');

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

                $idTareaPendiente = $request->integer('IdTareaPendiente');

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

                $idGrupo = $request->integer('IdGrupo');
                $idTareaPendiente = $request->integer('IdTareaPendiente');
                $idUsuarioReceptor = $request->integer('IdUsuarioReceptor');
                $idEstatusTareaPendiente = $request->integer('IdEstatusTareaPendiente');

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
                'IdProfesor' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->integer('IdGrupo');
                $idProfesor = $request->integer('IdProfesor');
                $IdUsuario = (int)$request->session()->get('IdUsuario', 0);

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
                'IdCurso' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->integer('IdGrupo');
                $idProfesor = $request->integer('IdProfesor');
                $idCurso = $request->integer('IdCurso');
                $IdUsuario = (int)$request->session()->get('IdUsuario', 0);

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
                'IdTareaPendiente' => ['required'],
                'Nombre' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->integer('IdGrupo');
                $IdUsuario = (int)$request->session()->get('IdUsuario', 0);
                $idTareaPendiente = $request->integer('IdTareaPendiente');
                $nombre = $request->string('Nombre')->trim();
                $descripcion = $request->string('Descripcion')->trim();

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

                $idGrupo = $request->integer('IdGrupo');
                $idUsuarioEmisor = $request->integer('IdUsuarioEmisor');
                $idUsuarioReceptor = $request->integer('IdUsuarioReceptor');
                $nombre = $request->string('Nombre')->trim();
                $descripcion = $request->string('Descripcion')->trim();
                $fechaFinalizacion = $request->date('FechaFinalizacion');

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
