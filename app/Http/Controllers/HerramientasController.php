<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Entities\OperacionMatematica;
use Illuminate\Support\Facades\Validator;

class HerramientasController extends Controller
{

    #region Views

    public function musica(Request $request) { return view('herramientas.musica');}

    public function matematicas(){

        $operaciones = array(
            0 => new OperacionMatematica("simplify","Simplificación"),
            1 => new OperacionMatematica("factor","Factorización"),
            2 => new OperacionMatematica("derive","Derivación"),
            3 => new OperacionMatematica("integrate", "Integración"),
            4 => new OperacionMatematica("zeroes", "Buscar Ceros"),
            5 => new OperacionMatematica("tangent", "Tangente"),
            6 => new OperacionMatematica("area", "Área Sobre Curva"),
            7 => new OperacionMatematica("cos", "Coseno"),
            8 => new OperacionMatematica("sin", "Seno"),
            9 => new OperacionMatematica("tan", "Tangente"),
            10 => new OperacionMatematica("arccos", "Arcocoseno"),
            11 => new OperacionMatematica("arcsin", "Arcoseno"),
            12 => new OperacionMatematica("arctan", "Arcotagente"),
            13 => new OperacionMatematica("abs", "Valor Absoluto"),
            14 => new OperacionMatematica("log", "Logaritmo")
        );

        return view('herramientas.matematicas', compact('operaciones'));
    }

    #endregion

    #region Ajax

    public function metadatos(Request $request){

        try {

            $validator = Validator::make($request->all(), [
                'Busqueda' => ['required', 'regex:/^(?![\&]).*/'],
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('DEEZER_API');
                $busqueda = trim($request->input('Busqueda'));

                if($url != ''){

                    $response = Http::get($url, [
                        'q' => $busqueda
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        foreach($result->data as $record){

                            $concatArtistTitle = $record->artist->name." - ".$record->title;
                            $concatTitleArtist = $record->title." - ".$record->artist->name;

                            if(str_contains($concatArtistTitle, $busqueda)
                                || str_contains($busqueda, $concatArtistTitle)
                                || str_contains($concatTitleArtist, $busqueda)
                                || str_contains($busqueda, $concatTitleArtist)
                                || $concatArtistTitle = $busqueda
                                || $concatTitleArtist = $busqueda)
                            {
                                return response()->json(['code' => 200,  'data' => [
                                    'Artista' => $record->artist->name,
                                    'Caratula' => $record->album->cover_xl,
                                    'DeezerID' => $record->id,
                                    'DeezerURL' => $record->link,
                                    'Titulo' => $record->title
                                ]], 200);
                            }
                        }

                        return response()->json(['code' => 404 , 'data' => 'Not found'], 200);

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

    public function operador(Request $request){

        try {

            $validator = Validator::make($request->all(), [
                'Operacion' => ['required'],
                'Expresion' => ['required']
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('NEWTON_API');

                if($url != ''){

                    $operacion = trim($request->input('Operacion'));
                    $expresion = trim($request->input('Expresion'));

                    $response = Http::get($url.$operacion.'/'.$expresion);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        return response()->json(['code' => 200, 'data' => [
                            'expresion' => $result->expression,
                            'resultado' => $result->result
                        ]], 200);

                    } else{
                        return response()->json(['code' => 500 , 'data' => 'Not found'], 200);
                    }
                } else{
                    return response()->json(['code' => 404 , 'data' => 'Empty url'], 200);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 500);
        }
    }

    public function multimedia(Request $request){
        try {

            $validator = Validator::make($request->all(), [
                'Busqueda' => ['required', 'regex:/^(?![\&]).*/'],
                'Artista' => ['required', 'regex:/^(?![\&]).*/']
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('YOUTUBE_API');
                $busqueda = trim($request->input('Busqueda'));
                $artista = trim($request->input('Artista'));

                if($url != ''){

                    $response = Http::get($url, [
                        'part' => 'snippet',
                        'q' => $busqueda,
                        'type' => 'video',
                        'maxResults' => 5,
                        'key' => env('YOUTUBE_API_KEY')
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        foreach($result->items as $record){

                            $channel_title = $record->snippet->channelTitle;
                            $video_title = $record->snippet->title;

                            if($artista == $channel_title){

                                if(str_contains($busqueda, $video_title)
                                || str_contains($video_title, $busqueda))
                                {
                                    return response()->json(['code' => 200,  'data' => [
                                        'Id' => $record->id->videoId
                                    ]], 200);
                                }
                            }
                        }

                        if(count($result->items) > 0){
                            return response()->json(['code' => 200,  'data' => [
                                'Id' => $result->items[0]->id->videoId
                            ]], 200);
                        }

                        return response()->json(['code' => 404 , 'data' => 'Not found'], 404);

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
