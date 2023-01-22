<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class AvisosController extends Controller
{
    #region Views

    public function avisos(){
        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');
        return view('avisos.avisos', compact('DatosUsuario', 'DatosCuenta'));
    }

    #endregion

    #region AJAX

    public function aviso_actualizar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdAviso' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idAviso = $request->integer('IdAviso');
                $IdUsuario = (int)$request->session()->get('IdUsuario', 0);

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/avisos/actualizar', [
                        'IdAviso' => $idAviso,
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
            }

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        }

    }

    public function aviso_registrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'Aviso' => ['required'],
                'Descripcion' => ['required'],
                'IdTipoAviso' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $IdUsuario = (int)$request->session()->get('IdUsuario', 0);
                $aviso = $request->string('Aviso')->trim();
                $descripcion = $request->string('Descripcion')->trim();
                $idTipoAviso = $request->integer('IdTipoAviso');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/avisos/registrar', [
                        'IdUsuario' => $IdUsuario,
                        'Aviso' => $aviso,
                        'Descripcion' => $descripcion,
                        'IdTipoAviso' => $idTipoAviso
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

    public function aviso_remover(Request $request)
    {
        try {

            $validator = Validator::make($request->all(),$rules = [
                'IdAviso' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $IdUsuario = (int)$request->session()->get('IdUsuario', 0);
                $idAviso = $request->integer('IdAviso');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/avisos/remover', [
                        'IdUsuario' => $idUsuario,
                        'IdAviso' => $idAviso
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

    public function avisodetalle_obtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdAviso' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idAviso = $request->integer('IdAviso');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/avisos/detalle', [
                        'IdAviso' => $idAviso
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

    public function avisoplagioprofesor_registrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdProfesor' => ['required'],
                'IdTarea' => ['required'],
                'NombreArchivo' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idProfesor = $request->integer('IdProfesor');
                $IdUsuario = (int)$request->session()->get('IdUsuario', 0);
                $idTarea = $request->integer('IdTarea');
                $nombreArchivo = $request->string('NombreArchivo')->trim();

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/avisos/plagioprofesor', [
                        'IdProfesor' => $idProfesor,
                        'IdUsuario' => $idUsuario,
                        'IdTarea' => $idTarea,
                        'NombreArchivo' => $nombreArchivo
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

    public function avisos_obtener(Request $request)
    {
        try {

            $url = env('COURSEROOM_API');

            $IdUsuario = (int)$request->session()->get('IdUsuario', 0);

            if($url != ''){

                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/avisos/obtener', [
                    'IdUsuario' => $IdUsuario,
                    'Leido' => null
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

    public function avisos_validar(Request $request)
    {
        try {
           
            $url = env('COURSEROOM_API');

            if($url != ''){

                $IdUsuario = (int)$request->session()->get('IdUsuario', 0);
                $fechaVisualizacion = Carbon::now();
                
                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/avisos/validar', [
                    'IdUsuario' => $IdUsuario,
                    'FechaVisualizacion' => $fechaVisualizacion
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

    #endregion
}
