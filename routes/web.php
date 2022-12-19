<?php

use App\Http\Controllers\InicioController;
use App\Http\Controllers\HerramientasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

#region Inicio

Route::get('/',  [InicioController::class, 'acceso'])->name('inicio.acceso');
Route::get('/recuperacion',  [InicioController::class, 'recuperacion'])->name('inicio.recuperacion');
Route::get('/registro',  [InicioController::class, 'registro'])->name('inicio.registro');
Route::get('/inicio',  [InicioController::class, 'inicio'])->name('inicio.inicio');

Route::post('/login',  [InicioController::class, 'login']);
Route::post('/recuperacion',  [InicioController::class, 'recuperacion_credenciales']);
Route::post('/registrar',  [InicioController::class, 'registrar_usuario']);

#endregion

#region Herramientas

Route::get('/herramientas/musica',  [HerramientasController::class, 'musica'])->name('herramientas.musica')->middleware('session.token');
Route::get('/herramientas/matematicas',  [HerramientasController::class, 'matematicas'])->name('herramientas.matematicas')->middleware('session.token');
Route::post('/herramientas/metadatos',  [HerramientasController::class, 'metadatos'])->middleware('session.token');
Route::post('/herramientas/operador',  [HerramientasController::class, 'operador'])->middleware('session.token');
Route::post('/herramientas/multimedia',  [HerramientasController::class, 'multimedia'])->middleware('session.token');

#endregion

Auth::routes();

