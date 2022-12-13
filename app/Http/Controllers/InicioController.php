<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioController extends Controller
{

    #region Views

    public function acceso(Request $request) {

        $session = $request->session()->get('AUTH_TOKEN', '');
        if(empty($session))
            $request->session()->push('AUTH_TOKEN', env("APP_KEY"));

        return view('inicio.acceso');
    }

    public function recuperacion(Request $request) { return view('inicio.recuperacion');}

    public function registro() {


        $localidades = array();
        $tipos_usuario = array();
        return view('inicio.registro', compact('localidades','tipos_usuario'));


    }

    #endregion

    #region Ajax

    public function login(){

    }

    public function recuperacion_credenciales()
    {

    }

    #endregion
}
