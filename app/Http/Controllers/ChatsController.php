<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\ChatsArchivosMensajes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ChatsController extends Controller
{
    #region views

    public function chats(){
        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');
        $IdTipoUsuario = session('IdTipoUsuario');

        return view('chats.chats', compact('DatosUsuario', 'DatosCuenta','IdTipoUsuario'));
    }

    #endregion

    #region AJAX

    public function conversacion(Request $request){ 
        

        $DatosChat = null;
        $Mensajes = array();
        $IdTipoUsuario = session('IdTipoUsuario');
        $IdUsuario = session('IdUsuario');
        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');

        $validator = Validator::make($request->all(), $rules = [
            'IdChat' => ['required'],
            'IdUsuarioReceptor' => ['required'],
        ], $messages = [
            'required' => 'El campo :attribute es requerido'
        ]);

        if (!$validator->fails()) {

            $url = env('COURSEROOM_API');

            $idChat = $request->integer('IdChat');
            $idUsuarioReceptor = $request->integer('IdUsuarioReceptor');

            if($url != ''){

                //Obtener datos del usuario receptor:
                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/usuarios/detalle', [
                    'IdUsuario' => $idUsuarioReceptor
                ]);
    
                if ($response->ok()){
                    $DatosUsuarioReceptor = json_decode($response->body());  
                    //Obtener datos de la cuenta:
                    
                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/usuarios/cuentaobtener', [
                        'IdUsuario' => $idUsuarioReceptor
                    ]);
        
                    if ($response->ok()){
                        
                        $DatosCuentaReceptor = json_decode($response->body());
                        $DatosChat =  (object) [
                            'IdChat' => $idChat,
                            'IdUsuarioEmisor'=> $IdUsuario,
                            'IdUsuarioReceptor'=> $idUsuarioReceptor,
                            'NombreReceptor' => $DatosUsuarioReceptor->nombre.' '.$DatosUsuarioReceptor->paterno.' '.$DatosUsuarioReceptor->materno,
                            'ImagenReceptor' => $DatosCuentaReceptor->imagen,
                            'CorreoReceptor' => $DatosCuentaReceptor->correoElectronico,
                            'TipoUsuarioReceptor' => $DatosUsuarioReceptor->tipoUsuario,
                        ];

                        //Obtener mensajes del chat:

                        $response = Http::withHeaders([
                            'Authorization' => env('COURSEROOM_API_KEY'),
                        ])->post($url.'/api/chats/mensajesobtener', [
                            'IdChat' => $idChat,
                            'FechaVisualizacion' => null
                        ]);

                        if($response->ok()){
                            $Mensajes = json_decode($response->body());
                        }
                    } 
                }  
            } 
        }

        return view('chats.detallechat', compact('DatosChat', 'DatosUsuario', 'DatosCuenta', 'Mensajes', 'IdTipoUsuario')); 
    }

    public function chat_registrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuarioReceptor' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuarioEmisor = session('IdUsuario');
                $idUsuarioReceptor = $request->integer('IdUsuarioReceptor');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/chats/registrar', [
                        'IdUsuarioEmisor' => $idUsuarioEmisor,
                        'IdUsuarioReceptor' => $idUsuarioReceptor
                    ]);

                    $result = json_decode($response->body());

                    if ($response->ok()){
                        return response()->json(['code' => 200 , 'data' => $result], 200);
                    } else{
                        return response()->json(['code' => 400 , 'data' => $result], 200);
                    }

                } else{
                    return response()->json(['code' => 404 , 'data' => 'Empty url'], 200);
                }
            }

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        }

    }

    public function chat_remover(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdChat' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idChat = $request->integer('IdChat');
                $IdUsuario = (int)$request->session()->get('IdUsuario', 0);

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/chats/remover', [
                        'IdChat' => $idChat,
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

    public function chatmensaje_registrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdChat' => ['required'],
                'Mensaje' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idChat = $request->integer('IdChat');
                $idUsuarioEmisor = session('IdUsuario');
                $mensaje = $request->string('Mensaje')->trim();
                
                $Base64Archivo = null;
                if($request->has('Base64Archivo')){
                    $Base64Archivo = $request->input('Base64Archivo');
                }
                
                $filename = null;
                if($request->hasFile('Archivo')) {
                    $filename = time().'_'.$request->file('Archivo')->getClientOriginalName();
                }
               
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/chats/mensajeregistrar', [
                        'IdChat' => $idChat,
                        'IdUsuarioEmisor' => $idUsuarioEmisor,
                        'Mensaje' => $mensaje,
                        'Archivo' => $filename
                    ]);

                    if ($response->ok()){
                        
                        $result = json_decode($response->body());

                        if($result->codigo > 0){
                            if($filename != null){

                                $file = $request->file('Archivo');

                                // File extension
                                $extension = $file->getClientOriginalExtension();

                                //Guardar imagen en mongo si no esta vácia:
                                $mongoChatArchivosMensajes = new ChatsArchivosMensajes;

                                $mongoChatArchivosMensajes->idMensaje = $result->codigo;
                                $mongoChatArchivosMensajes->archivo = $Base64Archivo;
                                $mongoChatArchivosMensajes->extension = $extension;

                                $mongoChatArchivosMensajes->save();

                                //Guardar imagen en storage:
                                Storage::putFileAs('chats', $file, $filename);
                            }
                        }

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

    public function chatmensaje_remover(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdChat' => ['required'],
                'IdUsuarioEmisor' => ['required'],
                'IdMensaje' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idChat = $request->integer('IdChat');
                $idUsuarioEmisor = $request->integer('IdUsuarioEmisor');
                $idMensaje = $request->integer('IdMensaje');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/chats/mensajeremover', [
                        'IdChat' => $idChat,
                        'IdUsuarioEmisor' => $idUsuarioEmisor,
                        'IdMensaje' => $idMensaje
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

    public function chatmensajes_obtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdChat' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idChat = $request->integer('IdChat');

                if($url != ''){

                    $fechaVisualizacion = Carbon::now()->addHours(-5);
                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/chats/mensajesobtener', [
                        'IdChat' => $idChat,
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
            }

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        }

    }

    public function chats_buscar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuarioEmisor' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuarioEmisor = $request->integer('IdUsuarioEmisor');
                $nombre = $request->string('Nombre')->trim();
                $paterno = $request->string('Paterno')->trim();
                $materno = $request->string('Materno')->trim();

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/chats/buscar', [
                        'IdUsuarioEmisor' => $idUsuarioEmisor,
                        'Nombre' => $nombre,
                        'Paterno' => $paterno,
                        'Materno' => $materno
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

    public function chats_obtener(Request $request)
    {
        try {

            $url = env('COURSEROOM_API');

            $IdUsuario = session('IdUsuario');

            if($url != ''){

                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/chats/obtener', [
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

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        }

    }

    #endregion
}
