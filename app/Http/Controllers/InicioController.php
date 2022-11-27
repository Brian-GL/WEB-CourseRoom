<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioController extends Controller
{

    public function acceso()
    {
        return view('inicio.acceso');
    }

    public function recuperacion()
    {
        return view('inicio.recuperacion');
    }
}
