<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class PreguntasRespuestasController extends Controller
{
    #region Views

    public function inicio(){
        
        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');
        $IdTipoUsuario = session('IdTipoUsuario');

        return view('preguntasrespuestas.preguntas', compact('DatosUsuario', 'DatosCuenta', 'IdTipoUsuario'));
    }

    public function preguntasrespuestadetalle_obtener(Request $request)
    {

        $DatosPregunta = null;
        $Respuestas = array();
        $IdTipoUsuario = session('IdTipoUsuario');
        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');

        $validator = Validator::make($request->all(), $rules = [
            'IdPreguntaRespuesta' => ['required']
        ], $messages = [
            'required' => 'El campo :attribute es requerido'
        ]);

        if (!$validator->fails()) {

            $url = env('COURSEROOM_API');

            $idPreguntaRespuesta = $request->integer('IdPreguntaRespuesta');

            if($url != ''){

                //Obtener detalle de la pregunta:

                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/preguntas/detalle', [
                    'IdPreguntaRespuesta' => $idPreguntaRespuesta
                ]);

                if ($response->ok()){
                    $DatosPregunta = json_decode($response->body());
                } 
               
                //Obtener respuestas de la pregunta:

                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/preguntas/mensajeobtener', [
                    'IdPreguntaRespuesta' => $idPreguntaRespuesta
                ]);

                if($response->ok()){
                    $Respuestas = json_decode($response->body());
                }
            } 
        }

        return view('preguntasrespuestas.detallepregunta', compact('DatosPregunta', 'DatosUsuario', 'DatosCuenta', 'IdTipoUsuario', 'Respuestas')); 
    }



    #endregion

    #region Ajax
    
    public function pregunta_actualizar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdPreguntaRespuesta' => ['required'],
                'Pregunta' => ['required'],
                'Descripcion' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = session('IdUsuario');
                $idPreguntaRespuesta = $request->integer('IdPreguntaRespuesta');
                $Pregunta= (string)$request->session()->get('Pregunta', 0);
                $descripcion = $request->float('Descripcion');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/preguntas/actualizar', [
                        'IdUsuario' => $idUsuario,
                        'IdPreguntaRespuesta' => $idPreguntaRespuesta,
                        'Pregunta' => $Pregunta,
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

    public function preguntasrespuesta_registar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'Pregunta' => ['required'],
                'Descripcion' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = session('IdUsuario');
                $Pregunta = $request->string('Pregunta')->trim();
                $descripcion = $request->string('Descripcion')->trim();

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/preguntas/registrar', [
                        'IdUsuario' => $idUsuario,
                        'Pregunta' => $Pregunta,
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

    public function preguntasrespuesta_remover(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdPreguntaRespuesta' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');
                
                $idUsuario = session('IdUsuario');
                $idPreguntaRespuesta = $request->integer('IdPreguntaRespuesta');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/preguntas/remover', [
                        'IdUsuario' => $idUsuario,
                        'IdPreguntaRespuesta' => $idPreguntaRespuesta
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

    public function preguntasrespuestaestatus_actualizar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdPreguntaRespuesta' => ['required'],
                'IdEstatusPregunta' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');
            
                $idUsuario = session('IdUsuario');
                $idPreguntaRespuesta = $request->integer('IdPreguntaRespuesta');
                $idEstatusPregunta = (int)$request->session()->get('IdEstatusPregunta', 0);

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/preguntas/estatus', [
                        'IdUsuario' => $idUsuario,
                        'IdPreguntaRespuesta' => $idPreguntaRespuesta,
                        'IdEstatusPregunta' => $idEstatusPregunta
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

    public function preguntasrespuestamensaje_registrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdPreguntaRespuesta' => ['required'],
                'Mensaje' => ['required'],
                'Archivo' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idPreguntaRespuesta = $request->integer('IdPreguntaRespuesta');
                $idUsuarioEmisor = session('IdUsuario');
                $mensaje = $request->string('Mensaje')->trim();
                $archivo = $request->string('Archivo')->trim();

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/preguntas/mensajeregistrar', [
                        'IdPreguntaRespuesta' => $idPreguntaRespuesta,
                        'IdUsuarioEmisor' => $idUsuarioEmisor,
                        'Mensaje' => $mensaje,
                        'Archivo' => $archivo
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

    public function preguntasrespuestamensaje_remover(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdPreguntaRespuesta' => ['required'],
                'IdMensaje' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idPreguntaRespuesta = $request->integer('IdPreguntaRespuesta');
                $idUsuarioEmisor = session('IdUsuario');
                $idMensaje = $request->integer('IdMensaje');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/preguntas/mensajeremover', [
                        'IdPreguntaRespuesta' => $idPreguntaRespuesta,
                        'IdUsuarioEmisor' => $idUsuarioEmisor,
                        'IdMensaje' => $idMensaje,
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

    public function preguntasrespuestamensajes_obtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdPreguntaRespuesta' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idPreguntaRespuesta = $request->integer('IdPreguntaRespuesta');
            
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/preguntas/mensajeobtener', [
                        'IdPreguntaRespuesta' => $idPreguntaRespuesta
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
    public function preguntasrespuestas_buscar(Request $request)
    {
        try {

            $url = env('COURSEROOM_API');

            $busqueda = null;
            
            if($request->has('Busqueda')){
                $busqueda = $request->string('Nombre')->trim();
            }

            if($url != ''){

                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/preguntas/buscar', [
                    'Busqueda' => $busqueda,
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

    public function preguntasrespuestas_obtener(Request $request)
    {
        try {

           
            $url = env('COURSEROOM_API');

            $idUsuario = session('IdUsuario');
        
            if($url != ''){

                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/preguntas/obtener', [
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


    #endregion
}
