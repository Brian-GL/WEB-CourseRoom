<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\GruposArchivosMensajes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class GruposController extends Controller
{
    #region Views

    public function grupos(){

        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');
        $IdTipoUsuario = session('IdTipoUsuario');

        return view('grupos.grupos', compact('DatosUsuario', 'DatosCuenta', 'IdTipoUsuario'));
    }

    public function gruposdetalle_obtener(Request $request)
    {
        $DatosGrupo = null;
        $Mensajes = null;
        $idGrupo = null;
        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');
        $IdTipoUsuario = session('IdTipoUsuario');

        $validator = Validator::make($request->all(), $rules = [
            'IdGrupo' => ['required']
        ], $messages = [
            'required' => 'El campo :attribute es requerido'
        ]);

        if (!$validator->fails()) {
            $url = env('COURSEROOM_API');

            $idGrupo = $request->integer('IdGrupo');

            if($url != ''){

                //Obtener datos grupo:
                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/grupos/detalleobtener', [
                    'IdGrupo' => $idGrupo
                ]);

                if ($response->ok()){
                    $DatosGrupo = json_decode($response->body());
                } 

                //Obtener mensajes grupo:
                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/grupos/mensajes', [
                    'IdGrupo' => $idGrupo
                ]);

                if ($response->ok()){

                    $Mensajes = json_decode($response->body());
                } 
            } 
        }
            
        return view('grupos.detallegrupo', compact('DatosUsuario', 'DatosCuenta', 'IdTipoUsuario', 'DatosGrupo','idGrupo', 'Mensajes'));
    }

    #endregion

    #region AJAX

    public function grupo_actualizar(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required'],
                'Nombre' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->integer('IdGrupo');
                $nombre = $request->string('Nombre')->trim();
                $descripcion = $request->string('Descripcion')->trim();
                
                $Base64Image = $request->input('Base64Image');
                $ImagenAnterior = $request->string('ImagenAnterior');

                $filename = $ImagenAnterior;
                if($request->hasFile('Imagen')) {
                    $filename = time().'_'.$request->file('Imagen')->getClientOriginalName();
                }

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/grupos/actualizar', [
                        'IdGrupo' => $idGrupo,
                        'IdCurso' => $idCurso,
                        'Nombre' => $nombre,
                        'Descripcion' => $descripcion,
                        'Imagen' => $filename
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        //Actualizar imagen
                        if($filename != $ImagenAnterior){

                            $file = $request->file('Imagen');

                            // File extension
                            $extension = $file->getClientOriginalExtension();

                            //Actualizar imagen en mongo si no esta vácia:
                            $mongoImagenes = GruposImagenes::where('idGrupo', $idGrupo)->first();

                            if(!is_null($mongoImagenes)){
                                $mongoImagenes->update(
                                    ['imagen' => $Base64Image,
                                    'extension' => $extension]);
                            }

                            Storage::delete('grupos/'.$ImagenAnterior);
                            //Guardar imagen en storage:
                            Storage::putFileAs('grupos', $file, $filename);
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

    public function gruposmensajes_obtener(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->integer('IdGrupo');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/grupos/mensajes', [
                        'IdGrupo' => $idGrupo
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

    public function grupos_obtener(Request $request){
        try {

            $url = env('COURSEROOM_API');

            if($url != ''){

                $IdUsuario = session('IdUsuario');
                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/grupos/obtener', [
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

    public function grupomiembros_obtener(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->integer('IdGrupo');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/grupos/miembros', [
                        'IdGrupo' => $idGrupo,
                        'IdUsuario' => null
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

    public function grupoarchivoscompartidos_obtener(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->integer('IdGrupo');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/grupos/archivoscompartidos', [
                        'IdGrupo' => $idGrupo
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

    public function grupotareaspendientes_obtener(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->integer('IdGrupo');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/grupos/tareaspendientes', [
                        'IdGrupo' => $idGrupo
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

    public function grupotareapendientedetalle_obtener(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdTareaPendiente' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idTareaPendiente = $request->integer('IdTareaPendiente');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/grupos/tareapendientedetalle', [
                        'IdTareaPendiente' => $idTareaPendiente
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

    public function grupotareapendienteestatus_actualizar(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required'],
                'IdTareaPendiente' => ['required'],
                'IdUsuarioReceptor' => ['required'],
                'IdEstatusTareaPendiente' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->integer('IdGrupo');
                $idTareaPendiente = $request->integer('IdTareaPendiente');
                $idUsuarioReceptor = session('IdUsuario');
                $idEstatusTareaPendiente = $request->integer('IdEstatusTareaPendiente');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/grupos/tareapendienteestatus', [
                        'IdGrupo' => $idGrupo,
                        'IdTareaPendiente' => $idTareaPendiente,
                        'IdUsuarioReceptor' => $idUsuarioReceptor,
                        'IdEstatusTareaPendiente' => $idEstatusTareaPendiente
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

    public function grupomiembro_remover(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required'],
                'IdProfesor' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->integer('IdGrupo');
                $idProfesor = $request->integer('IdProfesor');
                $IdUsuario = (int)$request->session()->get('IdUsuario', 0);

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/grupos/miembroremover', [
                        'IdGrupo' => $idGrupo,
                        'IdProfesor' => $idProfesor,
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
            }

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        }
    }

    public function grupomiembro_registrar(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required'],
                'IdUsuario' => ['required'],
                'IdCurso' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->integer('IdGrupo');
                $idProfesor = session('IdUsuario');
                $idCurso = $request->integer('IdCurso');
                $IdUsuario = $request->integer('IdUsuario');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/grupos/miembroregistrar', [
                        'IdGrupo' => $idGrupo,
                        'IdProfesor' => $idProfesor,
                        'IdCurso' => $idCurso,
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
            }

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        }
    }

    public function grupotareapendiente_actualizar(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required'],
                'IdTareaPendiente' => ['required'],
                'Nombre' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->integer('IdGrupo');
                $IdUsuario = (int)$request->session()->get('IdUsuario', 0);
                $idTareaPendiente = $request->integer('IdTareaPendiente');
                $nombre = $request->string('Nombre')->trim();
                $descripcion = $request->string('Descripcion')->trim();

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/grupos/tareapendienteactualizar', [
                        'IdGrupo' => $idGrupo,
                        'IdUsuario' => $idUsuario,
                        'IdTareaPendiente' => $idTareaPendiente,
                        'Nombre' => $nombre,
                        'Descripcion' => $descripcion
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

    public function grupotareapendiente_registrar(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required'],
                'IdUsuarioReceptor' => ['required'],
                'Nombre' => ['required'],
                'Descripcion' => ['required'],
                'FechaFinalizacion' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idGrupo = $request->integer('IdGrupo');
                $idUsuario = session('IdUsuario');
                $idUsuarioReceptor = $request->integer('IdUsuarioReceptor');
                $nombre = $request->string('Nombre')->trim();
                $descripcion = $request->string('Descripcion')->trim();
                $fechaFinalizacion = $request->date('FechaFinalizacion');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/grupos/tareapendienteregistrar', [
                        'IdGrupo' => $idGrupo,
                        'IdUsuarioEmisor' => $idUsuario,
                        'IdUsuarioReceptor' => $idUsuarioReceptor,
                        'Nombre' => $nombre,
                        'Descripcion' => $descripcion,
                        'FechaFinalizacion' => $fechaFinalizacion
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

    public function grupos_registrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],
                'Nombre' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request->integer('IdCurso');
                $nombre = $request->string('Nombre')->trim();
                $descripcion = $request->string('Descripcion');
                
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
                    ])->post($url.'/api/grupos/registrar', [
                        'IdCurso' => $idCurso,
                        'Nombre' => $nombre,
                        'Descripcion' => $descripcion,
                        'Imagen' => $filename
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        if($result->codigo > 0){
                            if($filename != null){

                                $file = $request->file('Archivo');

                                // File extension
                                $extension = $file->getClientOriginalExtension();

                                //Guardar imagen en mongo si no esta vácia:
                                $mongoCollection = new GruposImagenes;

                                $mongoCollection->idGrupo = $result->codigo;
                                $mongoCollection->archivo = $Base64Archivo;
                                $mongoCollection->extension = $extension;

                                $mongoCollection->save();

                                //Guardar imagen en storage:
                                Storage::putFileAs('grupos', $file, $filename);
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

    public function grupos_remover(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required'],
                'IdProfesor' => ['required'],
                'IdCurso' => ['required'],
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');
                
                $idGrupo = $request->integer('IdGrupo');
                $idProfesor = $request->integer('IdProfesor');
                $idCurso = (int)$request->session()->get('IdCurso', 0);

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/grupos/remover', [
                        'IdGrupo' => $idGrupo,
                        'IdProfesor' => $idProfesor,
                        'IdCurso' => $idCurso
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

    public function gruposabandonar_actualizar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required'],
                'IdUsuario' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');
                
                $idGrupo = $request->integer('IdGrupo');
                $IdUsuario = $request->integer('IdUsuario');
                

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/grupos/abandonaractualizar', [
                        'IdGrupo' => $idGrupo,
                        'IdUsuario' => $idUsuario,
                        
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

    public function grupoarchivocompartido_registrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required'],
                'Archivo' => ['required'],
                'NombreArchivo' => ['required'],
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');
                
                $idGrupo = $request->integer('IdGrupo');
                $idUsuario = session('IdUsuario');
                $nombreArchivo = $request->string('NombreArchivo');
                
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
                    ])->post($url.'/api/grupos/archivocompartido', [
                        'IdGrupo' => $idGrupo,
                        'IdUsuario' => $idUsuario,
                        'NombreArchivo' => $nombreArchivo,
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
                                $mongoCollection = new GrupoArchivosCompartidos;

                                $mongoCollection->idArchivoCompartido = $result->codigo;
                                $mongoCollection->archivo = $Base64Archivo;
                                $mongoCollection->extension = $extension;

                                $mongoCollection->save();

                                //Guardar imagen en storage:
                                Storage::putFileAs('grupos', $file, $filename);
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

    public function gruposarchivocompartido_remover(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdArchivoCompartido' => ['required'],
                'IdGrupo' => ['required'],
                'IdUsuario' => ['required'],
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');
                               
                $idArchivoCompartido = $request->integer('IdArchivoCompartido');
                $idGrupo = $request->integer('IdGrupo');
                $idUsuario = $request->integer('IdUsuario');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/grupos/archivocompartidoremover', [
                        'IdArchivoCompartido' => $idArchivoCompartido,
                        'IdGrupo' => $idGrupo,
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
            }

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , 'data' => $th->getMessage()], 200);
        }
    }

    public function gruposmensaje_registrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdGrupo' => ['required'],
                'Mensaje' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');
                
                $idGrupo = $request->integer('IdGrupo');
                $idUsuarioEmisor = session('IdUsuario');
                $mensaje = $request->integer('Mensaje');
                
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
                    ])->post($url.'/api/grupos/mensajeregistrar', [
                        'IdGrupo' => $idGrupo,
                        'IdUsuarioEmisor' => $idUsuarioEmisor,
                        'Mensaje' => $mensaje,
                        'Archivo' => $filename
                    ]);

                    if ($response->ok()){
                        $fechaRegistro = Carbon::now()->addHours(-5);
                        $result = json_decode($response->body());

                        if($result->codigo > 0){
                            if($filename != null){

                                $file = $request->file('Archivo');

                                // File extension
                                $extension = $file->getClientOriginalExtension();

                                //Guardar imagen en mongo si no esta vácia:
                                $mongoCollection = new GruposArchivosMensajes;

                                $mongoCollection->idMensaje = $result->codigo;
                                $mongoCollection->archivo = $Base64Archivo;
                                $mongoCollection->extension = $extension;

                                $mongoCollection->save();

                                //Guardar imagen en storage:
                                Storage::putFileAs('grupos', $file, $filename);
                            }
                        }

                        return response()->json(['code' => 200 , 
                        'data' => $result, 
                        'fecha' => $fechaRegistro, 
                        'nombreArchivo' => $filename,
                        'imagenEmisor' => session('DatosCuenta')->imagen], 200);

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

    public function gruposmensaje_remover(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuarioEmisor' => ['required'],
                'IdGrupo' => ['required'],
                'IdMensaje' => ['required'],
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');
                              
                $idUsuarioEmisor = $request->integer('IdUsuarioEmisor');
                $idGrupo = $request->integer('IdGrupo');
                $idMensaje = $request->integer('IdMensaje');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/grupos/mensajeremover', [
                        'IdUsuarioEmisor' => $idUsuarioEmisor,
                        'IdGrupo' => $idGrupo,
                        'IdMensaje' => $idMensaje
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
