<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class InicioController extends Controller
{

    #region Views

    public function inicio(){
        
        $IdUsuario = session('IdUsuario');
        $IdTipoUsuario = session('IdTipoUsuario');

        //Obtener datos del usuario:
        $url = env('COURSEROOM_API');

        $DatosUsuario = session('DatosUsuario');
        if(is_null($DatosUsuario)){
           
            if($url != ''){

                //Datos usuario:
                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/usuarios/detalle', [
                    'IdUsuario' => $IdUsuario
                ]);
    
                if ($response->ok()){
                    $DatosUsuario = json_decode($response->body());  
                    session(['DatosUsuario' => $DatosUsuario]);
                } 
            } 
        } 

        //Obtener datos de la cuenta:
        $DatosCuenta = session('DatosCuenta');
        if(is_null($DatosCuenta)){
           
            if($url != ''){

                //Cuenta:
                $response = Http::withHeaders([
                    'Authorization' => env('COURSEROOM_API_KEY'),
                ])->post($url.'/api/usuarios/cuentaobtener', [
                    'IdUsuario' => $IdUsuario
                ]);
    
                if ($response->ok()){
                    $DatosCuenta = json_decode($response->body());
                    session(['DatosCuenta' => $DatosCuenta]);
                } 
            } 
        } 

        return view('inicio.inicio',compact('DatosUsuario', 'DatosCuenta', 'IdTipoUsuario')); 
    }
    
    public function acerca(){ 
        
        $DatosUsuario = session('DatosUsuario');
        $DatosCuenta = session('DatosCuenta');
        $IdTipoUsuario = session('IdTipoUsuario');

        return view('inicio.acerca', compact('DatosUsuario', 'DatosCuenta', 'IdTipoUsuario')); 
    }
    
    #endregion

    #region Ajax



    #endregion
}
