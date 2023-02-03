<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ArchivosController extends Controller
{
    #region Views

    #endregion

    #region AJAX

    public function archivo_actualizar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'Archivo' => ['required'],
                'IdTipoArchivo' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $archivo = $request -> input('Archivo');
                $idTipoArchivo = $request -> input('IdTipoArchivo');
                $idRegistro = input('IdRegistro');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/archivo/actualizar', [
                        'Archivo' => $archivo,
                        'IdTipoArchivo' => $idTipoArchivo,
                        'IdRegistro' => $idRegistro
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

    #endregion

}