<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class InicioController extends Controller
{

    #region Views

    public function inicio(Request $request){
        
        $IdUsuario = (int)$request->session()->get('IdUsuario', 0);

        $DatosCuenta = null;
        $DatosUsuario = null;

        //Obtener datos del usuario:
        $url = env('COURSEROOM_API');

        if($url != ''){

            //Datos usuario:
            $response = Http::withHeaders([
                'Authorization' => env('COURSEROOM_API_KEY'),
            ])->post($url.'/api/usuarios/detalle', [
                'IdUsuario' => $IdUsuario
            ]);

            if ($response->ok()){
                $DatosUsuario = json_decode($response->body());    
            } 

            //Cuenta:
            $response = Http::withHeaders([
                'Authorization' => env('COURSEROOM_API_KEY'),
            ])->post($url.'/api/usuarios/cuentaobtener', [
                'IdUsuario' => $IdUsuario
            ]);

            if ($response->ok()){
                $DatosCuenta = json_decode($response->body());
            } 
        } 

        return view('inicio.inicio',compact('DatosUsuario', 'DatosCuenta')); 
    }
    
        public function acerca(){ return view('inicio.acerca'); }

    #endregion

    #region Ajax



    #endregion
}
