<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HerramientasController extends Controller
{
    public function musica()
    {
        return view('herramientas.musica');
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
                    return response()->json(['code' => 200 , 'message' => 'OK', 'result' => [
                        'Artista' => $record->artist->name,
                        'Caratula' => $record->album->cover_xl,
                        'DeezerID' => $record->id,
                        'DeezerURL' => $record->link,
                        'Titulo' => $record->title
                    ]], 200);
                }
            }

            return response()->json(['code' => 404 , 'message' => 'Not found', 'result' => 'Not found'], 200);

        } else{
            return response()->json(['code' => 500 , 'message' => 'Error', 'result' => $response->body()], 200);
        }
    }
}
