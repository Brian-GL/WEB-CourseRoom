<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioController extends Controller
{

    #region Views

    public function acceso(Request $request) {

        $request->session()->push('login', 'value');
        return view('inicio.acceso');

    }

    public function recuperacion() { return view('inicio.recuperacion');}

    #endregion

    #region Ajax

    public function login(){

    }

    public function recuperacion_credenciales()
    {

    }

    #endregion
}
