<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\TareaArchivosEntregados;
use App\Models\TareaArchivosRetroalimentaciones;
use App\Models\TareaArchivosAdjuntos;
use App\Models\UsuariosImagenes;
use App\Models\CursosImagenes;

class TareasController extends Controller
{
    #region Views

    public function tareas(){

        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');
        $IdTipoUsuario = session('IdTipoUsuario');
        $Imagen = session('Imagen');

        return view('tareas.tareas', compact('DatosUsuario', 'DatosCuenta','IdTipoUsuario', 'Imagen'));
    }

    public function tareaestudiantedetalle_obtener(Request $request){
       
        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');
        $IdTipoUsuario = session('IdTipoUsuario');
        $IdUsuario = session('IdUsuario');
        $Imagen = session('Imagen');
        $DatosTarea = null;

        $url = env('COURSEROOM_API');

        $IdTarea = $request->integer('IdTarea');

        if($url != ''){

            $response = Http::withHeaders([
                'Authorization' => env('COURSEROOM_API_KEY'),
            ])->post($url.'/api/tareas/estudiantedetalle', [
                'IdTarea' => $IdTarea,
                'IdUsuario' => $IdUsuario
            ]);

            if ($response->ok()){
                $DatosTarea = json_decode($response->body());

                //Obtener información imagen desde mongo:
                $element = UsuariosImagenes::where('idUsuario', '=', $DatosTarea->idProfesor)->first();

                if(!is_null($element)){
                    $DatosTarea->imagenProfesor = $element->imagen;
                }

                $element = CursosImagenes::where('idCurso', '=', $DatosTarea->idCurso)->first();

                if(!is_null($element)){
                    $DatosTarea->imagenCurso = $element->imagen;
                }
            } 
        } 
        
        return view('tareas.detalletareaestudiante', compact('DatosUsuario', 'DatosCuenta','IdTipoUsuario', 'DatosTarea', 'IdTarea', 'IdUsuario', 'Imagen'));
    }

    public function tareaprofesordetalle_obtener(Request $request){
       
        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');
        $IdTipoUsuario = session('IdTipoUsuario');
        $Imagen = session('Imagen');
        
        $DatosTarea = null;

        $url = env('COURSEROOM_API');

        $IdTarea = $request->integer('IdTarea');
        $IdUsuario = $request->integer('IdUsuario');

        if($url != ''){

            $response = Http::withHeaders([
                'Authorization' => env('COURSEROOM_API_KEY'),
            ])->post($url.'/api/tareas/profesordetalle', [
                'IdUsuario' => $IdUsuario,
                'IdTarea' => $IdTarea,
            ]);

            if ($response->ok()){
                $DatosTarea = json_decode($response->body());

                //Obtener información imagen desde mongo:
                $element = CursosImagenes::where('idCurso', '=', $DatosTarea->idCurso)->first();

                if(!is_null($element)){
                    $DatosTarea->imagenCurso = $element->imagen;
                }
            } 
        } 
        
        return view('tareas.detalletareaprofesor', compact('DatosUsuario', 'DatosCuenta','IdTipoUsuario', 'DatosTarea', 'IdTarea', 'IdUsuario', 'Imagen'));
    }

    public function tareadetalle_obtener(Request $request){
       
        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');
        $IdTipoUsuario = session('IdTipoUsuario');
        $Imagen = session('Imagen');
        
        $DatosTarea = null;

        $url = env('COURSEROOM_API');

        $IdTarea = $request->integer('IdTarea');

        if($url != ''){

            $response = Http::withHeaders([
                'Authorization' => env('COURSEROOM_API_KEY'),
            ])->post($url.'/api/tareas/detalle', [
                'IdTarea' => $IdTarea
            ]);

            if ($response->ok()){
                $DatosTarea = json_decode($response->body());

                //Obtener información imagen desde mongo:
                   
                $element = CursosImagenes::where('idCurso', '=', $DatosTarea->idCurso)->first();

                if(!is_null($element)){
                    $DatosTarea->imagenCurso = $element->imagen;
                }
            } 
        } 
        
        return view('tareas.detalletarea', compact('DatosUsuario', 'DatosCuenta','IdTipoUsuario', 'DatosTarea', 'IdTarea', 'Imagen'));
    }


    #endregion

    #region AJAX

    public function tareaarchivosadjuntos_obtener(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdTarea' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idTarea = $request->integer('IdTarea');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/tareas/archivosadjuntos', [
                        'IdTarea' => $idTarea
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        foreach($result as &$material){
                            $element = TareaArchivosAdjuntos::where('idArchivoAdjunto', '=', $material->idArchivoAdjunto)->first();

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

    public function tareasmes_obtener(Request $request){
        try {

            $url = env('COURSEROOM_API');

            $IdUsuario = session('IdUsuario');
            $mes = Carbon::now()->addHours(-5)->month;

            if($url != ''){

                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/tareas/mes', [
                    'IdUsuario' => $IdUsuario,
                    'Mes' => $mes
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

    public function tarearetroalimentaciondetalle_obtener(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdRetroalimentacion' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idRetroalimentacion = $request->integer('IdRetroalimentacion');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/tareas/retroalimentaciondetalle', [
                        'IdRetroalimentacion' => $idRetroalimentacion
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        if(!is_null($result->archivo)){

                            $element = TareaArchivosRetroalimentaciones::where('idRetroalimentacion', '=', $idRetroalimentacion)->first();

                            if(!is_null($element)){
                                $result->archivo = $element->archivo;
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

    public function tarea_actualizar(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdTarea' => ['required'],
                'Nombre' => ['required'],
                'Descripcion' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idTarea = $request->integer('IdTarea');
                $idProfesor = session('IdUsuario');
                $nombre = $request->string('Nombre')->trim();
                $descripcion = $request->string('Descripcion')->trim();

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/tareas/actualizar', [
                        'IdTarea' => $idTarea,
                        'IdProfesor' => $idProfesor,
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

    public function tareacalificar_actualizar(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdTarea' => ['required'],
                'IdUsuario' => ['required'],
                'Calificacion' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idTarea = $request->integer('IdTarea');
                $idProfesor = session('IdUsuario');
                $IdUsuario = $request->integer('IdUsuario');
                $calificacion = $request->float('Calificacion');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/tareas/calificar', [
                        'IdTarea' => $idTarea,
                        'IdProfesor' => $idProfesor,
                        'IdUsuario' => $IdUsuario,
                        'Calificacion' => $calificacion
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

    public function tareaarchivoentregado_registrar(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdTarea' => ['required'],
                'NombreArchivo' => ['required'],
                'Archivo' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idTarea = $request->integer('IdTarea');
                $IdUsuario = session('IdUsuario');
                
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
                    ])->post($url.'/api/tareas/archivoentregado', [
                        'IdTarea' => $idTarea,
                        'IdUsuario' => $IdUsuario,
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
                                $mongoCollection = new TareaArchivosEntregados;

                                $mongoCollection->idArchivoEntregado = $result->codigo;
                                $mongoCollection->archivo = $Base64Archivo;
                                $mongoCollection->extension = $extension;

                                $mongoCollection->save();

                                //Guardar imagen en storage:
                                Storage::putFileAs('tareas', $file, $filename);
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

    public function tarea_remover(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdTarea' => ['required'],
                'IdProfesor' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idTarea = $request->integer('IdTarea');
                $idProfesor = $request->integer('IdProfesor');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/tareas/remover', [
                        'IdTarea' => $idTarea,
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

    public function tarea_registrar(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],
                'Nombre' => ['required'],
                'Descripcion' => ['required'],
                'FechaEntrega' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request->integer('IdCurso');
                $idProfesor = session('IdUsuario');
                $nombre = $request->string('Nombre')->trim();
                $descripcion = $request->string('Descripcion')->trim();
                $fechaEntrega = $request->date('FechaEntrega');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/tareas/registrar', [
                        'IdCurso' => $idCurso,
                        'IdProfesor' => $idProfesor,
                        'Nombre' => $nombre,
                        'Descripcion' => $descripcion,
                        'FechaEntrega' => $fechaEntrega
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

    public function tarearetroalimentacion_registrar(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdTarea' => ['required'],
                'Nombre' => ['required'],
                'IdUsuario' => ['required'],
                'Retroalimentacion' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idTarea = $request->integer('IdTarea');
                $idProfesor = session('IdUsuario');
                $idUsuario = $request->integer('IdUsuario');
                $nombre = $request->string('Nombre')->trim();
                $retroalimentacion = $request->string('Retroalimentacion')->trim();
                
                $nombreArchivo = null;
                if($request->has('NombreArchivo')){
                    $nombreArchivo = $request->string('NombreArchivo');
                }

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
                    ])->post($url.'/api/tareas/retroalimentacion', [
                        'IdTarea' => $idTarea,
                        'IdProfesor' => $idProfesor,
                        'IdUsuario' => $idUsuario,
                        'Nombre' => $nombre,
                        'Retroalimentacion' => $retroalimentacion,
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
                                $mongoCollection = new TareaArchivosRetroalimentaciones;

                                $mongoCollection->idRetroalimentacion = $result->codigo;
                                $mongoCollection->archivo = $Base64Archivo;
                                $mongoCollection->extension = $extension;

                                $mongoCollection->save();

                                //Guardar imagen en storage:
                                Storage::putFileAs('tareas', $file, $filename);
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

    public function tareaarchivosentregados_obtener(Request $request){
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdTarea' => ['required'],
                'IdUsuario' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idTarea = $request->integer('IdTarea');
                $idUsuario = $request->integer('IdUsuario');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/tareas/archivosentregados', [
                        'IdTarea' => $idTarea,
                        'IdUsuario' => $idUsuario,
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        $ArchivosEntregados = array();

                        foreach($result as &$archivoEntregado){

                            $element = TareaArchivosEntregados::where('idArchivoEntregado', '=', $archivoEntregado->idArchivoEntregado)->first();

                            $archivo = '';
                            if(!is_null($element)){
                                $archivo = $element->archivo;
                            }

                            array_push($ArchivosEntregados, [
                                'idArchivoEntregado' => $archivoEntregado->idArchivoEntregado,
                                'nombre' => $archivoEntregado->nombre,
                                'archivo' => $archivo,
                                'fechaRegistro' => $archivoEntregado->fechaRegistro,
                                'fechaActualizacion' => $archivoEntregado->fechaActualizacion,
                                'nombreArchivo' => $archivoEntregado->archivo
                            ]);
                           
                        }

                        return response()->json(['code' => 200 , 'data' => $ArchivosEntregados], 200);

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

    public function tareaestudiante_obtener(Request $request){
        try {

            
            $url = env('COURSEROOM_API');
            
            $idUsuario = session('IdUsuario');

            if($url != ''){

                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/tareas/estudiante', [
                    'IdUsuario' => $idUsuario,
                ]);

                if ($response->ok()){

                    $result = json_decode($response->body());

                    foreach($result as &$tarea){
                       
                        $element = CursosImagenes::where('idCurso', '=', $tarea->idCurso)->first();

                        if(!is_null($element)){
                            $tarea->imagenCurso = $element->imagen;
                        }
                    }

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

    public function tareascreadasprofesor_obtener(Request $request)
    {
        try {

            $url = env('COURSEROOM_API');
            
            $idProfesor = session('IdUsuario');

            if($url != ''){

                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/tareas/creadaprofesor', [
                    'IdProfesor' => $idProfesor,
                ]);

                if ($response->ok()){

                    $result = json_decode($response->body());

                    foreach($result as &$tarea){
                       
                        $element = CursosImagenes::where('idCurso', '=', $tarea->idCurso)->first();

                        if(!is_null($element)){
                            $tarea->imagenCurso = $element->imagen;
                        }
                    }

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

    public function tareareatroalimentaciones_obtener(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdUsuario' => ['required'],
                'IdTarea' => ['required'],
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');
                
                $idUsuario = $request->integer('IdUsuario');
                $idTarea = $request->integer('IdTarea');
                
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/tareas/retroalimentaciones', [
                        'IdUsuario' => $idUsuario,
                        'IdTarea' => $idTarea,
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

    public function tareascalificar_obtener(Request $request)
    {
        try {

            $url = env('COURSEROOM_API');
            
            $idProfesor = session('IdUsuario');
            
            if($url != ''){

                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/tareas/calificarobtener', [
                    'IdProfesor' => $idProfesor,
                ]);

                if ($response->ok()){

                    $result = json_decode($response->body());

                    foreach($result as &$tarea){
                        //Obtener información imagen desde mongo:
                        $element = UsuariosImagenes::where('idUsuario', '=', $tarea->idUsuario)->first();

                        if(!is_null($element)){
                            $tarea->imagenEstudiante = $element->imagen;
                        }

                        $element = CursosImagenes::where('idCurso', '=', $tarea->idCurso)->first();

                        if(!is_null($element)){
                            $tarea->imagenCurso = $element->imagen;
                        }
                    }

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

    public function tareaentregar_actualizar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdTarea' => ['required'],
                'IdUsuario' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');
                
                $idTarea = $request->integer('IdTarea');
                $idUsuario = $request->integer('IdUsuario');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/tareas/entregar', [
                        'IdTarea' => $idTarea,
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

    public function tareaarchivoentregado_remover(Request $request)
    {
        try {

            $validator = Validator::make($request->all(),$rules = [
                'IdTarea' => ['required'],
                'IdUsuario' => ['required'],
                'IdArchivoEntregado' => ['required'],
                'NombreArchivoEntregado' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idTarea = $request->integer('IdTarea');
                $idUsuario = $request->integer('IdUsuario');
                $idArchivoEntregado = $request->integer('IdArchivoEntregado');
                $nombreArchivoEntregado = $request->string('NombreArchivoEntregado');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/tareas/archivoentregadoremover', [
                        'IdUsuario' => $idUsuario,
                        'IdTarea' => $idTarea,
                        'IdArchivoEntregado' => $idArchivoEntregado,
                    ]);

                    if ($response->ok()){

                        $result = json_decode($response->body());

                        //Remover archivo en mongo:
                        $mongoTareaArchivosEntregados = TareaArchivosEntregados::where('idArchivoEntregado', $idArchivoEntregado)->first();

                        if(!is_null($mongoTareaArchivosEntregados)){
                            $mongoTareaArchivosEntregados->delete();
                        }

                        Storage::delete('tareas/'.$nombreArchivoEntregado);
                        
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

    public function tareaarchivoadjunto_remover(Request $request)
    {
        try {

            $validator = Validator::make($request->all(),$rules = [
                'IdTarea' => ['required'],
                'IdUsuario' => ['required'],
                'IdArchivoAdjunto' => ['required'],
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');
                
                $idTarea = $request->integer('IdTarea');
                $idUsuario = $request->integer('IdUsaurio');
                $idArchivoAdjunto = $request->integer('IdArchivoAdjunto');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/tareas/archivoadjunto', [
                        'IdUsuario' => $idUsuario,
                        'IdTarea' => $idTarea,
                        'IdArchivoAdjunto' => $idArchivoAdjunto,
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

    public function tareaarchivoadjunto_registrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdTarea' => ['required'],
                'NombreArchivo' => ['required'],
                'Archivo' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idTarea = $request->integer('IdTarea');
                $idProfesor = session('IdUsuario');
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
                    ])->post($url.'/api/tareas/archivoadjuntoregistrar', [
                        'IdTarea' => $idTarea,
                        'IdProfesor' => $idProfesor,
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
                                $mongoCollection = new TareaArchivosAdjuntos;

                                $mongoCollection->idArchivoAdjunto = $result->codigo;
                                $mongoCollection->archivo = $Base64Archivo;
                                $mongoCollection->extension = $extension;

                                $mongoCollection->save();

                                //Guardar imagen en storage:
                                Storage::putFileAs('tareas', $file, $filename);
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

    #endregion
}
