<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DefaultController extends Controller
{
     #region Views

     public function acceso() { return view('default.acceso');}

     public function recuperacion() { return view('default.recuperacion');}

     public function registro(Request $request) {
         $session = $request->session()->get('AUTH_TOKEN', '');
         if(empty($session))
             $request->session()->push('AUTH_TOKEN', env("APP_KEY"));

         $localidades = array();
         $tipos_usuario = array();
         return view('default.registro', compact('localidades','tipos_usuario'));
     }

     #endregion

     #region Ajax

     public function acceder(Request $request){

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
