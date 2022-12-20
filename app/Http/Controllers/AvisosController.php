<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvisosController extends Controller
{
    #region Views

    #endregion

    #region AJAX

    public function aviso_actualizar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'IdAviso' => ['required'],
                'IdUsuario' => ['required']
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idAviso = $request->input('IdAviso');
                $idUsuario = $request->input('IdUsuario');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/avisos/actualizar', [
                        'IdAviso' => $idAviso,
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

    public function aviso_registrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'IdUsuario' => ['required'],
                'Aviso' => ['required'],
                'Descripcion' => ['required'],
                'IdTipoAviso' => ['required']
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = $request->input('IdUsuario');
                $aviso = $request->input('Aviso');
                $descripcion = $request->input('Descripcion');
                $idTipoAviso = $request->input('IdTipoAviso');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/avisos/registrar', [
                        'IdUsuario' => $idUsuario,
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

    #endregion
}
