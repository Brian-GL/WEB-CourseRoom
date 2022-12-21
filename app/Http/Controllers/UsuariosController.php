<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    #region View

    #endregion


    #region Ajax

    public function usuario_actualizar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'IdUsuario' => ['required'],
                'Nombre' => ['required'],
                'Paterno' => ['required'],
                'IdLocalidad' => ['required']
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
                        'IdLocalidad' => $idLocalidad,
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
