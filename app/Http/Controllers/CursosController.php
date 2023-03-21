<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\CursosImagenes;
use App\Models\UsuariosImagenes;
use App\Models\CursoArchivosMensajes;
use App\Models\CursoArchivosCompartidos;
use App\Models\GruposImagenes;

class CursosController extends Controller
{
    #region views

    public function cursos(){

        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');
        $IdTipoUsuario = session('IdTipoUsuario');
        $Imagen = session('Imagen');

        return view('cursos.cursos', compact('DatosUsuario', 'DatosCuenta','IdTipoUsuario', 'Imagen'));
    }

    public function detallecurso(Request $request){

        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');
        $IdTipoUsuario = session('IdTipoUsuario');
        $Imagen = session('Imagen');

        $DatosCurso = null;

        $url = env('COURSEROOM_API');

        $IdCurso = $request->integer('IdCurso');

        if($url != ''){

            $response = Http::withHeaders([
                'Authorization' => env('COURSEROOM_API_KEY'),
            ])->post($url.'/api/cursos/detalleobtener', [
                'IdCurso' => $IdTarea
            ]);

            if ($response->ok()){
                $DatosCurso = json_decode($response->body());

                //Obtener información imagen desde mongo:
                $element = UsuariosImagenes::where('idUsuario', '=', $DatosCurso->idProfesor)->first();

                if(!is_null($element)){
                    $DatosCurso->imagenProfesor = $element->imagen;
                }

                $element = CursosImagenes::where('idCurso', '=', $IdCurso)->first();

                if(!is_null($element)){
                    $DatosCurso->imagen = $element->imagen;
                }
            } 
        } 

        return view('cursos.detallecurso', compact('DatosUsuario', 'DatosCuenta','IdTipoUsuario', 'DatosCurso'. 'Imagen'));
    }

    public function detallecursoestudiante(Request $request){

        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');
        $IdTipoUsuario = session('IdTipoUsuario');
        $IdUsuario = session('IdUsuario');
        $Imagen = session('Imagen');

        $Mensajes = array();

        $DatosCurso = null;

        $url = env('COURSEROOM_API');

        $IdCurso = $request->integer('IdCurso');

        if($url != ''){

            $response = Http::withHeaders([
                'Authorization' => env('COURSEROOM_API_KEY'),
            ])->post($url.'/api/cursos/estudiantedetalleobtener', [
                'IdCurso' => $IdCurso,
                'IdUsuario' => $IdUsuario
            ]);

            if ($response->ok()){
                $DatosCurso = json_decode($response->body());

                //Obtener información imagen desde mongo:
                $element = UsuariosImagenes::where('idUsuario', '=', $DatosCurso->idProfesor)->first();

                if(!is_null($element)){
                    $DatosCurso->imagenProfesor = $element->imagen;
                }

                $element = CursosImagenes::where('idCurso', '=', $IdCurso)->first();

                if(!is_null($element)){
                    $DatosCurso->imagen = $element->imagen;
                }
            } 

            //Obtener mensajes curso:
            $response = Http::withHeaders([
                'Authorization' => env('COURSEROOM_API_KEY'),
            ])->post($url.'/api/cursos/mensajesobtener', [
                'IdCurso' => $IdCurso
            ]);

            if ($response->ok()){

                $Mensajes = json_decode($response->body());

                foreach($Mensajes as &$mensaje){

                    //Obtener información imagen desde mongo:
                    $element = UsuariosImagenes::where('idUsuario', '=', $mensaje->idUsuarioEmisor)->first();
        
                    if(!is_null($element)){
                        $mensaje->imagenEmisor = $element->imagen;

                        if(!is_null($mensaje->archivo)){
                            $element = CursoArchivosMensajes::where('idMensaje', '=', $mensaje->idMensaje)->first();

                            if(!is_null($element)){
                                $mensaje->archivo = $element->archivo;
                            }
                        }
                    }
                }
            } 
        } 

        return view('cursos.detallecursoestudiante', compact('DatosUsuario', 'DatosCuenta','IdTipoUsuario', 'DatosCurso', 'Mensajes', 'IdUsuario', 'Imagen'));
    }

    public function detallecursoprofesor(Request $request){

        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');
        $IdTipoUsuario = session('IdTipoUsuario');
        $Imagen = session('Imagen');

        $DatosCurso = null;
        $Mensajes = array();

        $url = env('COURSEROOM_API');

        $IdCurso = $request->integer('IdCurso');

        if($url != ''){

            $response = Http::withHeaders([
                'Authorization' => env('COURSEROOM_API_KEY'),
            ])->post($url.'/api/cursos/profesordetalleobtener', [
                'IdCurso' => $IdCurso
            ]);

            if ($response->ok()){
                $DatosCurso = json_decode($response->body());

                //Obtener información imagen desde mongo:
                $element = UsuariosImagenes::where('idUsuario', '=', $DatosCurso->idProfesor)->first();

                if(!is_null($element)){
                    $DatosCurso->imagenProfesor = $element->imagen;
                }

                $element = CursosImagenes::where('idCurso', '=', $IdCurso)->first();

                if(!is_null($element)){
                    $DatosCurso->imagen = $element->imagen;
                }
            } 

            //Obtener mensajes curso:
            $response = Http::withHeaders([
                'Authorization' => env('COURSEROOM_API_KEY'),
            ])->post($url.'/api/cursos/mensajesobtener', [
                'IdCurso' => $IdCurso
            ]);

            if ($response->ok()){

                $Mensajes = json_decode($response->body());

                foreach($Mensajes as &$mensaje){

                    //Obtener información imagen desde mongo:
                    $element = UsuariosImagenes::where('idUsuario', '=', $mensaje->idUsuarioEmisor)->first();

                    if(!is_null($element)){
                        $mensaje->imagenEmisor = $element->imagen;

                        if(!is_null($mensaje->archivo)){
                            $element = CursoArchivosMensajes::where('idMensaje', '=', $mensaje->idMensaje)->first();

                            if(!is_null($element)){
                                $mensaje->archivo = $element->archivo;
                            }
                        }
                    }
                }
            } 
        } 

        return view('cursos.detallecursoprofesor', compact('DatosUsuario', 'DatosCuenta','IdTipoUsuario', 'DatosCurso', 'Mensajes', 'Imagen'));
    }

    #endregion

    #region AJAX

    public function cursomateriales_obtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request->integer('IdCurso');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/materialesobtener', [
                        'IdCurso' => $idCurso,
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        foreach($result as &$material){
                            $element = CursoArchivosCompartidos::where('idMaterial', '=', $material->idMaterialSubido)->first();

                            if(!is_null($element)){
                                $material->archivo = $element->archivo;
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

    public function curso_registrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'Nombre' => ['required'],
	            'Descripcion' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                if($url != ''){

                    $Nombre = $request->string('Nombre')->trim();
                    $Descripcion = $request->string('Descripcion')->trim();
                    $IdProfesor = session('IdUsuario');
    
                    $Base64Archivo = null;
                    if($request->has('Base64Imagen')){
                        $Base64Archivo = $request->input('Base64Imagen');
                    }
                    
                    $filename = null;
                    if($request->hasFile('Imagen')) {
                        $filename = time().'_'.$request->file('Imagen')->getClientOriginalName();
                    }
    
                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/registrar', [
                        'Nombre' => $nombre,
                        'Descripcion' => $descripcion,
                        'Imagen' => $filename,
                        'IdProfesor' => $idProfesor,
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        if($result->codigo > 0){
                            if($filename != null){

                                $file = $request->file('Imagen');

                                // File extension
                                $extension = $file->getClientOriginalExtension();

                                //Guardar imagen en mongo si no esta vácia:
                                $mongoCollection = new CursosImagenes;

                                $mongoCollection->idCurso = $result->codigo;
                                $mongoCollection->archivo = $Base64Archivo;
                                $mongoCollection->extension = $extension;

                                $mongoCollection->save();

                                //Guardar imagen en storage:
                                Storage::putFileAs('cursos', $file, $filename);
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

    public function curso_remover(Request $request)
    {
        try {

            $validator = Validator::make($request->all(),$rules = [
                'IdCurso' => ['required'],
	            'IdProfesor' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request -> input('IdCurso');
                $idProfesor = $request -> input('IdProfesor');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/cursos/remover', [
                        'IdCurso' => $idCurso,
                        'IdProfesor' => $idProfesor
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

    public function curso_gruposobtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request->integer('IdCurso');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/grupos', [
                        'IdCurso' => $idCurso,
                        'Activo' => null,
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        foreach($result as &$grupo){
                            $element = GruposImagenes::where('idGrupo', '=', $grupo->idGrupo)->first();

                            if(!is_null($element)){
                                $grupo->imagen = $element->imagen;
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

    public function curso_actualizar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],
                'Nombre' => ['required'],
                'Descripcion' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request->integer('IdCurso');
                $idProfesor = $request->integer('IdProfesor');
                $nombre = $request->string('Nombre');
                $descripcion = $request->string('Descripcion');
                
                $Base64Image = $request->input('Base64Image');
                $ImagenAnterior = $request->string('ImagenAnterior');

                $filename = $ImagenAnterior;
                if($request->hasFile('Imagen')) {
                    $filename = time().'_'.$request->file('Imagen')->getClientOriginalName();
                }

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/cursos/actualizar', [
                        'IdCurso' => $idCurso,
                        'IdProfesor' => $idProfesor,
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
                            $mongoCursosImagenes = CursosImagenes::where('idCurso', $idCurso)->first();

                            if(!is_null($mongoCursosImagenes)){
                                $mongoCursosImagenes->update(
                                    ['imagen' => $Base64Image,
                                    'extension' => $extension]);
                            }

                            Storage::delete('cursos/'.$ImagenAnterior);
                            
                            //Guardar imagen en storage:
                            Storage::putFileAs('cursos', $file, $filename);
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

    public function curso_abandonaractualizar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],  
                'IdUsuario'   => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request->integer('IdCurso');
                $idUsuario = $request->integer('IdUsuario');
                
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/cursos/abandonaractualizar', [
                        'IdCurso' => $idCurso,
                        'IdUsuario' => $idUsuario,
                        'Codigo' => $codigo,
                        'Mensaje' => $mensaje
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

    public function curso_cuestionarioabandonaractualizar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],  
                'IdUsuario'   => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request ->integer('idCurso');
                $idUsuario = $request ->integer('idUsuario');
                
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'cuestionarioabandonaractualizar', [
                        'IdCurso' => $idCurso,
                        'IdUsuario' => $ddUsuario,
                        'Codigo' => $codigo,
                        'Mensaje' => $mensaje
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

    public function curso_desempenoobtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request->integer('IdCurso');
                
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/desempenoobtener', [
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

    public function curso_estudianteregistrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

	            $idCurso = $request->integer('IdCurso');
                $idUsuario = session('IdUsuario');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/estudianteregistrar', [
                        'IdCurso' => $idCurso,
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

    public function curso_finalizaractualizar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],  
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request->integer('IdCurso');
                $idProfesor = session('IdUsuario');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/cursos/finalizaractualizar', [
                        'IdCurso' => $idCurso,
                        'IdProfesor' => $idProfesor,
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

    public function curso_materialregistrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],
                'NombreArchivo' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

	            $idCurso = $request->integer('IdCurso');
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
                    ])->post($url.'/api/cursos/materialregistrar', [
                        'IdCurso' => $idCurso,
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
                                $mongoCollection = new CursoArchivosCompartidos;

                                $mongoCollection->idMaterial = $result->codigo;
                                $mongoCollection->archivo = $Base64Archivo;
                                $mongoCollection->extension = $extension;

                                $mongoCollection->save();

                                //Guardar imagen en storage:
                                Storage::putFileAs('cursos', $file, $filename);
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

    public function curso_materialremover(Request $request)
    {
        try {

            $validator = Validator::make($request->all(),$rules = [
                'IdMaterial' => ['required'],
                'IdCurso' => ['required'],
	            'IdUsuario' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idMaterial = $request -> input('IdMaterial');
                $idCurso = $request -> input('IdCurso');
                $idUsuario = $request -> input('IdUsuario');
                $codigo  = input ('Codigo');
                $mensaje  = input ('Mensaje');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/cursos/materialremover', [
                        'IdMaterial' => $idMaterial,
                        'IdCurso' => $idCurso,
                        'IdUsuario' => $idUsuario,
                        'Codigo' => $codigo,
                        'Mensaje' => $mensaje,
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

    public function curso_mensajeregistrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],
                'Mensaje' => ['required'],
	            'Archivo' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

	            $idCurso = $request ->integer('IdCurso');
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
                    ])->post($url.'/api/cursos/mensajeregistrar', [
                        'IdCurso' => $idCurso,
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
                                $mongoCollection = new CursoArchivosMensajes;

                                $mongoCollection->idMensaje = $result->codigo;
                                $mongoCollection->archivo = $Base64Archivo;
                                $mongoCollection->extension = $extension;

                                $mongoCollection->save();

                                //Guardar imagen en storage:
                                Storage::putFileAs('cursos', $file, $filename);
                            }
                        }

                        return response()->json(['code' => 200 , 
                        'data' => $result, 
                        'fecha' => $fechaRegistro, 
                        'nombreArchivo' => $Base64Archivo,
                        'imagenEmisor' => session('Imagen')], 200);

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

    public function curso_mensajeremover(Request $request)
    {
        try {

            $validator = Validator::make($request->all(),$rules = [
                'IdMensaje' => ['required'],
                'IdCurso' => ['required'],
	            'IdUsuarioEmisor' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idMensaje = $request ->integer('IdMensaje');
                $idCurso = $request ->integer('IdCurso');
                $idUsuarioEmisor = $request ->integer('IdUsuarioEmisor');
            

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/cursos/mensajeremover', [
                        'IdMensaje' => $idMensaje,
                        'IdCurso' => $idCurso,
                        'IdUsuarioEmisor' => $idUsuarioEmisor,
                        'Codigo' => $codigo,
                        'Mensaje' => $mensaje,
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


    public function curso_estudianteobtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required']                
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request->integer('IdCurso');
              
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/estudianteobtener', [
                        'IdCurso' => $idCurso,
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

    public function curso_profesortareasobtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],          
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request->integer('IdCurso');
                $idProfesor = session('IdUsuario');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/profesortareasobtener', [
                        'IdCurso' => $idCurso,
                        'IdProfesor' => $idProfesor,
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

    public function cursoestudiante_buscar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'Busqueda' => ['required'],
                'IdUsuario' => ['required'],                
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $Busqueda = $request->string('Busqueda')->trim();
                $idUsuario = $request->integer('IdUsuario');
                
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/buscarobtener', [
                        'Busqueda' => $Busqueda,
                        'IdUsuario' => $idUsuario,
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        foreach($result as &$curso){
                            //Obtener información imagen desde mongo:
                            $element = UsuariosImagenes::where('idUsuario', '=', $curso->idProfesor)->first();

                            if(!is_null($element)){
                                $curso->imagenProfesor = $element->imagen;
                            }

                            $element = CursosImagenes::where('idCurso', '=', $curso->idCurso)->first();

                            if(!is_null($element)){
                                $curso->imagenCurso = $element->imagen;
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
    
    public function curso_obtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdEstatusUsuario' => ['required'],           
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = session('IdUsuario');
                $idEstatusUsuario = $request->integer('IdEstatusUsuario');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/obtener', [
                        'IdUsuario' => $idUsuario,
                        'IdEstatusUsuario' => $idEstatusUsuario,
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        foreach($result as &$curso){
                            //Obtener información imagen desde mongo:
                            $element = UsuariosImagenes::where('idUsuario', '=', $curso->idProfesor)->first();

                            if(!is_null($element)){
                                $curso->imagenProfesor = $element->imagen;
                            }

                            $element = CursosImagenes::where('idCurso', '=', $curso->idCurso)->first();

                            if(!is_null($element)){
                                $curso->imagenCurso = $element->imagen;
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

    public function curso_nuevoobtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'NumeroResultados' => ['required'],        
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idUsuario = session('IdUsuario');
                $numeroResultados = $request->integer('NumeroResultados');
                
                
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/nuevoobtener', [
                        'IdUsuario' => $idUsuario,
                        'NumeroResultados' => $numeroResultados
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        foreach($result as &$curso){
                            //Obtener información imagen desde mongo:
                            $element = UsuariosImagenes::where('idUsuario', '=', $curso->idProfesor)->first();

                            if(!is_null($element)){
                                $curso->imagenProfesor = $element->imagen;
                            }

                            $element = CursosImagenes::where('idCurso', '=', $curso->idCurso)->first();

                            if(!is_null($element)){
                                $curso->imagenCurso = $element->imagen;
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

    public function curso_profesorobtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'Finalizado' => ['required']                
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idProfesor = session('IdUsuario');
                $finalizado = $request->boolean('Finalizado');
                
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/profesorobtener', [
                        'IdProfesor' => $idProfesor,
                        'Finalizado' => $finalizado,                       
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        foreach($result as &$curso){
                            $element = CursosImagenes::where('idCurso', '=', $curso->idCurso)->first();

                            if(!is_null($element)){
                                $curso->imagen = $element->imagen;
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

    public function curso_tareasestudianteobtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],
                'IdUsuario' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');
                
                $idCurso = $request->integer('IdCurso');
                $idUsuario = $request->integer('IdUsuario');
                
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/tareasestudianteobtener', [
                        'IdUsuario' => $idUsuario,
                        'IdCurso' => $idCurso,                   
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

    public function curso_tematicaregistrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],
	            'IdTematica' => ['required'],                
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request->integer('IdCurso');
                $idTematica = $request->integer('IdTematica');
                
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/tematicaregistrar', [
                        'IdCurso' => $idCurso,
                        'IdTematica' => $idTematica,
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

    public function curso_tematicaremover(Request $request)
    {
        try {

            $validator = Validator::make($request->all(),$rules = [
                'IdTematica' => ['required'],
                'IdCurso' => ['required']	            
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idTematica = $request->integer('IdTematica');
                $idCurso = $request->integer('IdCurso');                
                
                
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/cursos/tematicaremover', [
                        'IdTematica' => $idTematica,
                        'IdCurso' => $idCurso,
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

    public function curso_tematicaobtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');
                
                $idCurso = $request->integer('IdCurso');
                
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/tematicaobtener', [
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

    public function curso_estudiantedesempenoobtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],
                'IdUsuario' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');
                
                $idCurso = $request->integer('IdCurso');
                $idUsuario = $request->integer('IdUsuario'); 
               
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/estudiantedesempenoobtener', [
                        'IdCurso' => $idCurso,
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

    public function curso_estudiantessingrupoobtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');
                
                $idCurso = $request->integer('IdCurso');
               
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/estudiantessingrupoobtener', [
                        'IdCurso' => $idCurso,
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

    public function curso_estudiantefinalizaractualizar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],  
                'IdUsuario'   => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request->integer('IdCurso');
                $idUsuario = $request->integer('IdUsuario');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/cursos/estudiantefinalizaractualizar', [
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

    public function curso_cuestionariorespuestaregistrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],
	            'IdUsuario' => ['required'],
                'IdPregunta' => ['required'],
	            'Puntaje' => ['required'],                   
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');              

                $idCurso = $request->integer('IdCurso');
                $idUsuario = $request->integer('IdUsuario');
                $idPregunta = $request->integer('IdPregunta');
                $puntaje = $request->float('Puntaje');
                
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/cuestionariorespuestaregistrar', [
                        'IdUsuario' => $idUsuario,
                        'IdPregunta' => $idPregunta,
                        'IdCurso' => $idCurso,
                        'Puntaje' => $puntaje
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