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

        return view('preguntasrespuestas.preguntas', compact('DatosUsuario', 'DatosCuenta'));}

    #endregion

    #region Ajax


    #endregion
}
