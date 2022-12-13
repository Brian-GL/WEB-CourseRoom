<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioController extends Controller
{

    //$request->session()->push('login', 'value');

    #region Views

    public function acceso() { return view('inicio.acceso');}

    public function recuperacion() { return view('inicio.recuperacion');}

    public function registro() { return view('inicio.registro');}

    #endregion

    #region Ajax

    public function login(){

    }

    public function recuperacion_credenciales()
    {

    }

    #endregion
}
