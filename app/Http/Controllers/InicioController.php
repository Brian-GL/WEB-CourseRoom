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

        //Obtener datos del usuario:
        $url = env('COURSEROOM_API');

        $DatosUsuario = null;
        $DatosCuenta = null;

        $DatosUsuarioArray = $request->session()->get('DatosUsuario', null);
        if(empty($DatosUsuarioArray)){
           
            if($url != ''){

                //Datos usuario:
                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/usuarios/detalle', [
                    'IdUsuario' => $IdUsuario
                ]);
    
                if ($response->ok()){
                    $DatosUsuario = json_decode($response->body());  
                    $request->session()->push('DatosUsuario', $DatosUsuario);
                } 
            } 

        } else{
            $DatosUsuario = $DatosUsuarioArray[0];
        }

        //Obtener datos de la cuenta:
        $DatosCuentaArray = $request->session()->get('DatosCuenta', null);
        if(empty($DatosCuentaArray)){
           
            if($url != ''){

                //Cuenta:
                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/usuarios/cuentaobtener', [
                    'IdUsuario' => $IdUsuario
                ]);
    
                if ($response->ok()){
                    $DatosCuenta = json_decode($response->body());
                    $request->session()->push('DatosCuenta', $DatosCuenta);
                } 
            } 

        } else{
            $DatosCuenta = $DatosCuentaArray[0];
        }

        return view('inicio.inicio',compact('DatosUsuario', 'DatosCuenta')); 
    }
    
    public function acerca(Request $request){ 
        
        $DatosUsuario = $request->session()->get('DatosUsuario', null)[0];
        $DatosCuenta = $request->session()->get('DatosCuenta', null)[0];

        return view('inicio.acerca', compact('DatosUsuario', 'DatosCuenta')); 
    }

    
    #endregion

    #region Ajax



    #endregion
}
