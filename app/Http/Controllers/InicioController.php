<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioController extends Controller
{

    #region Views

    public function acceso() { return view('inicio.acceso');}

    public function recuperacion() { return view('inicio.recuperacion');}

    public function registro() {


        $localidades = array();
        $tipos_usuario = array();
        return view('inicio.registro', compact('localidades','tipos_usuario'));


    }

    #endregion

    #region Ajax

    public function login(Request $request){

        // $session = $request->session()->get('AUTH_TOKEN', '');
        // if(empty($session))
        //     $request->session()->push('AUTH_TOKEN', env("APP_KEY"));

    }

    public function recuperacion_credenciales(Request $request)
    {

    }

    public function registrar_usuario(Request $request)
    {

    }

    #endregion
}
