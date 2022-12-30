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

                $IdGrupo = $request->input('IdGrupo');
                $IdCurso = $request->input('IdCurso');
                $Nombre = $request->input('Nombre');
                $Descripcion = $request->input('Descripcion');
                $Imagen = $request->input('Imagen');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/grupos/actualizar', [
                        'idGrupo' => $IdGrupo,
                        'idCurso' => $IdCurso,
                        'nombre' => $Nombre,
                        'descripcion' => $Descripcion,
                        'imagen' => $Imagen
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
