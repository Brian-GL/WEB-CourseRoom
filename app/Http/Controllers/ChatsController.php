<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatsController extends Controller
{
    #region views

    #endregion

    #region AJAX
    
    public function chat_registrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'IdUsuarioEmisor' => ['required'],
                'IdUsuarioReceptor' => ['required']
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $IdUsuarioEmisor = $request->input('IdUsuarioEmisor');
                $IdUsuarioReceptor = $request->input('IdUsuarioReceptor');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/chats/registrar', [
                        'idUsuarioEmisor' => $IdUsuarioEmisor,
                        'idUsuarioReceptor' => $IdUsuarioReceptor
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
