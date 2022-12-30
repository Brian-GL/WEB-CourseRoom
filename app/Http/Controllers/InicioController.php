<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioController extends Controller
{

    #region Views

    public function inicio(){
        $nombre = "'Username'";
        return view('inicio.inicio',compact('nombre')); }
    public function acerca(){ return view('inicio.acerca'); }

    #endregion

    #region Ajax



    #endregion
}
