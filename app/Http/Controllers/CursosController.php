<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\CursosImagenes;


class CursosController extends Controller
{
    #region views

    public function cursos(){

        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');
        $IdTipoUsuario = session('IdTipoUsuario');

        return view('cursos.cursos', compact('DatosUsuario', 'DatosCuenta','IdTipoUsuario'));
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
                    $Imagen = input('Imagen');
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
                'Descripcion' => ['required'],
                'Imagen' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request -> input('IdCurso');
                $idProfesor = input('IdProfesor');
                $nombre = $request -> input ('Nombre');
                $descripcion = $request -> input('Descripcion');
                $imagen = $request -> input('Imagen');
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/cursos/actualizar', [
                        'IdCurso' => $idCurso,
                        'IdProfesor' => $idProfesor,
                        'Nombre' => $nombre,
                        'Descripcion' => $descripcion,
                        'Imagen' => $imagen
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

                $idCurso = $request -> input ('IdCurso');
                $idUsuario = $request -> input ('IdUsuario');
                $codigo  = input ('Codigo');
                $mensaje  = input ('Mensaje');
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

                $idCurso = $request -> input ('idCurso');
                $idUsuario = $request -> input ('idUsuario');
                $codigo  = input ('codigo');
                $mensaje  = input ('mensaje');
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
                'IdCurso' => ['required'],
	            'IdUsuario' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

	            $idCurso = $request -> input('IdCurso');
                $idUsuario = $request -> input('IdUsuario');
                $codigo = input('Codigo');
                $mensaje = input('Mensaje');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/estudianteregistrar', [
                        'IdCurso' => $idCurso,
                        'IdUsuario' => $idUsuario,
                        'Codigo' => $codigo,
                        'Mensaje' => $mensaje,
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

    public function curso_estudiantedetalleobtener(Request $request)
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

                $idCurso = $request -> input('IdCurso');
                $idUsuario = $request -> input('IdUsuario');
                $nombre = input('Nombre');
                $descripcion = input('Descripcion');
                $imagen = input('Imagen');
                $idProfesor = input('IdProfesor');
                $nombreProfesor = input('NombreProfesor');
                $imagenProfesor = input('ImagenProfesor');
                $fechaRegistroCurso = input('FechaRegistroCurso');
                $fechaActualizacionCurso = input('FechaActualizacionCurso');
                $finalizado = input('Finalizado');
                $fechaRegistro = input('FechaRegistro');
                $fechaActualizacion = input('FechaActualizacion');
                $estatus = input('Estatus');
                $descripcionEstatus = input('DescripcionEstatus');
                
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/estudiantedetalleobtener', [
                        'IdCurso' => $idCurso,
                        'IdUsuario' => $idUsuario,
                        'Nombre' => $nombre,
                        'Descripcion' => $descripcion,
                        'Imagen' => $imagen,
                        'IdProfesor' => $idProfesor,
                        'NombreProfesor' => $nombreProfesor,
                        'ImagenProfesor' => $imagenProfesor,
                        'FechaRegistroCurso' => $fechaRegistroCurso,
                        'FechaActualizacionCurso' => $fechaActualizacionCurso,
                        'Finalizado' => $finalizado,
                        'FechaRegistro' => $fechaRegistro,
                        'FechaActualizacion' => $fechaActualizacion,
                        'Estatus' => $estatus,
                        'DescripcionEstatus' => $descripcionEstatus,
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

    public function curso_finalizaractualizar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],  
                'IdProfesor'   => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request -> input ('IdCurso');
                $idProfesor = $request -> input ('Idprofesor');
                $codigo  = input ('Codigo');
                $mensaje  = input ('Mensaje');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/cursos/finalizaractualizar', [
                        'IdCurso' => $idCurso,
                        'IdProfesor' => $idProfesor,
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

    public function curso_materialregistrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],
	            'IdUsuario' => ['required'],
                'NombreArchivo' => ['required'],
	            'Archivo' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

	            $idCurso = $request -> input('IdCurso');
                $idUsuario = $request -> input('IdUsuario');
                $nombreArchivo = $request -> input('nombreArchivo');
                $archivo = $request -> input('Archivo');
                $codigo = input('Codigo');
                $mensaje = input('Mensaje');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/materialregistrar', [
                        'IdCurso' => $idCurso,
                        'IdUsuario' => $idUsuario,
                        'NombreArchivo' => $nombreArchivo,
                        'archivo' => $archivo,
                        'Codigo' => $codigo,
                        'Mensaje' => $mensaje,
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

    public function curso_mensajeregistrar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],
	            'IdUsuarioEmisor' => ['required'],
                'Mensaje' => ['required'],
	            'Archivo' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

	            $idCurso = $request -> input('IdCurso');
                $idUsuarioEmisor = $request -> input('IdUsuarioEmisor');
                $mensaje = $request -> input('Mensaje');
                $archivo = $request -> input('Archivo');
                $codigo = input('Codigo');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/mensajeregistrar', [
                        'IdCurso' => $idCurso,
                        'IdUsuarioEmisor' => $idUsuarioEmisor,
                        'Mensaje' => $mensaje,
                        'Archivo' => $archivo,
                        'Codigo' => $codigo,
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

                $idMensaje = $request -> input('IdMensaje');
                $idCurso = $request -> input('IdCurso');
                $idUsuarioEmisor = $request -> input('IdUsuarioEmisor');
                $codigo  = input ('Codigo');
                $mensaje  = input ('Mensaje');

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

    public function curso_mensajesobtener(Request $request) 
    {
        try {

            $validator = Validator::make($request->all(), $rules = [
                'IdCurso' => ['required'],
                'UltimoMensaje' => ['required']
            ], $messages = [
                'required' => 'El campo :attribute es requerido'
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 404 , 'data' => $validator->errors()->first()], 200);
            } else {

                $url = env('COURSEROOM_API');

                $idCurso = $request -> input('IdCurso');
                $ultimoMensaje = $request -> input('UltimoMensaje');
                $idMensaje = input('IdMensaje');
                $mensaje = input('Mensaje');
                $archivo = input('Archivo');
                $idUsuarioEmisor = input('IdUsuarioEmisor');
                $nombreUsuarioEmisor = input('NombreUsuarioEmisor');
                $fechaRegistro = input('FechaRegistro');
                
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/mensajesobtener', [
                        'IdCurso' => $idCurso,
                        'UltimoMensaje' => $ultimoMensaje,
                        'IdMensaje' => $idMensaje,
                        'Mensaje' => $mensaje,
                        'Archivo' => $archivo,
                        'IdUsuarioEmisor' => $idUsuarioEmisor,
                        'NombreUsuarioEmisor' => $nombreUsuarioEmisor,
                        'FechaRegistro' => $fechaRegistro,
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

    public function curso_profesordetalleobtener(Request $request)
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

                $idCurso = $request -> input('IdCurso');
                $nombre = input('Nombre');
                $descripcion    = input('Descripcion');
                $imagen = input('Imagen');
                $idProfesor = input('IdProfesor');
                $nombreProfesor = input('NombreProfesor');
                $imagenProfesor = input('ImagenProfesor');
                $fechaRegistro  = input('FechaRegistro');
                $fechaActualizacion = input('FechaActualizacion');
                $puntaje    = input('Puntaje');
                $finalizado = input('Finalizado');
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/profesordetalleobtener', [
                        'IdCurso' => $idCurso,
                        'Nombre' => $nombre,
                        'Descripcion' => $descripcion,
                        'Imagen' => $imagen,
                        'IdProfesor' => $idProfesor,
                        'NombreProfesor' => $nombreProfesor,
                        'ImagenProfesor' => $imagenProfesor,
                        'FechaRegistro' => $fechaRegistro,
                        'FechaActualizacion' => $fechaActualizacion,
                        'Puntaje' => $puntaje,
                        'Finalizado' => $finalizado,
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

                $idCurso = $request -> input('IdCurso');
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

    public function curso_promedioobtener(Request $request)
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

                $idCurso = $request -> input('IdCurso');
                $promedioCurso = input('PromedioCurso');
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/promedioobtener', [
                        'IdCurso' => $idCurso,
                        'PromedioCurso' => $promedioCurso,
                        
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

    public function curso_buscarObtener(Request $request)
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

                $busqueda = $request -> input('Busqueda');
                $idUsuario = $request -> input('IdUsuario');
                $idCurso = input('IdCurso');
                $curso = input('Curso');
                $imagenCurso = input('imagenCurso');
                $idProfesor = input('IdProfesor');
                $profesor = input('Profesor');
                $imagenProfesor = input('ImagenProfesor');
                $listaTematicas = input('ListaTematicas');
                $fechaRegistro = input('FechaRegistro');
                $puntaje = input('Puntaje');
                $fechaIngreso = input('FechaIngreso');
                $estatus = input('Estatus');
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/buscarobtener', [
                        'IdCurso' => $idCurso,
                        'Busqueda' => $busqueda,
                        'IdUsuario' => $idUsuario,
                        'IdCurso' => $idCurso,
                        'Curso' => $curso,
                        'ImagenCurso' => $imagenCurso,
                        'IdProfesor' => $idProfesor,
                        'Profesor' => $profesor,
                        'ImagenProfesor,' => $imagenProfesor,
                        'ListaTematicas' => $listaTematicas,
                        'FechaRegistro' => $fechaRegistro,
                        'Puntaje' => $puntaje,
                        'FechaIngreso' => $fechaIngreso,
                        'Estatus' => $estatus,
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

                $idCurso = $request -> input('IdCurso');
                $idTematica = $request -> input('IdTematica');
                $mensaje = input('Mensaje');
                $codigo = input('Codigo');
                
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/tematicaregistrar', [
                        'IdCurso' => $idCurso,
                        'IdTematica' => $idTematica,
                        'Mensaje' => $mensaje,
                        'Codigo' => $codigo,
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

                $idTematica = $request -> input('IdTematica');
                $idCurso = $request -> input('IdCurso');                
                $codigo  = input ('Codigo');
                $mensaje  = input ('Mensaje');
                
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->delete($url.'/api/cursos/tematicaremover', [
                        'IdTematica' => $idTematica,
                        'IdCurso' => $idCurso,
                        'Codigo' => $codigo,
                        'Mensaje' => $mensaje,
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
                
                $idCurso = $request -> input('IdCurso');
                $idTematica = input('IdTematica');
                $tematica = input('Tematica');
                
                
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/tematicaobtener', [
                        'IdCurso' => $idCurso,
                        'IdTematica' => $idTematica,
                        'Tematica' => $tematica,                       
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
                
                $idCurso = $request -> input('IdCurso');
                $idUsuario = input('IdUsuario');
                $estudiante = input('Estudiante');
                $fechaIngreso = input('FechaIngreso');
               
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/estudiantessingrupoobtener', [
                        'IdCurso' => $idCurso,
                        'IdUsuario' => $idUsuario,
                        'Estudiante' => $estudiante,
                        'FechaIngreso' => $fechaIngreso,
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

                $idCurso = $request -> input ('IdCurso');
                $idUsuario = $request -> input ('IdUsaurio');
                $codigo  = input ('Codigo');
                $mensaje  = input ('Mensaje');

                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->put($url.'/api/cursos/estudiantefinalizaractualizar', [
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

                $idCurso = $request -> input('IdCurso');
                $idUsuario = $request -> input('IdUsuario');
                $idPregunta = $request -> input('IdPregunta');
                $puntaje = $request -> input('Puntaje');
                $mensaje = input('Mensaje');
                $codigo = input('Codigo');
                
                if($url != ''){

                    $response = Http::withHeaders([
                        'Authorization' => env('COURSEROOM_API_KEY'),
                    ])->post($url.'/api/cursos/cuestionariorespuestaregistrar', [
                        'IdUsuario' => $ddUsuario,
                        'IdPregunta' => $idPregunta,
                        'IdCurso' => $idCurso,
                        'Puntaje' => $puntaje,
                        'Mensaje' => $mensaje,
                        'Codigo' => $codigo,
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