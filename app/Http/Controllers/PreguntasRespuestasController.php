<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreguntasRespuestasController extends Controller
{
    #region Views

    public function inicio(Request $request){
        
        $DatosUsuario = $request->session()->get('DatosUsuario', null)[0];
        $DatosCuenta = $request->session()->get('DatosCuenta', null)[0];

        return view('preguntasrespuestas.preguntas', compact('DatosUsuario', 'DatosCuenta'));}

    #endregion

    #region Ajax


    #endregion
}
