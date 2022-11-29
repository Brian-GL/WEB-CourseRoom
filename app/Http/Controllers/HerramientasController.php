<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Entities\OperacionMatematica;

class HerramientasController extends Controller
{
    public function musica()
    {
        return view('herramientas.musica');
    }

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

    public function metadatos(Request $request){

        $url = env('DEEZER_API');
        $busqueda = $request->input('busqueda');

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
                    || str_contains($busqueda, $concatTitleArtist))
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
    }

    public function operador(Request $request){

        $url = env('NEWTON_API');

        $operacion = $request->input('operacion');
        $expresion = $request->input('expresion');

        $response = Http::get($url.$operacion.'/'.$expresion);

        if ($response->ok()){

            $result = json_decode($response->body());

            return response()->json(['code' => 200, 'data' => [
                'expresion' => $result->expression,
                'resultado' => $result->result
            ]], 200);

        } else{
            return response()->json(['code' => 500 , 'data' => $response->body()], 200);
        }
    }
}
