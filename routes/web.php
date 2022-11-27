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

Route::get('/',  [InicioController::class, 'acceso']);
Route::get('/recuperacion',  [InicioController::class, 'recuperacion']);

Route::get('/herramientas/musica',  [HerramientasController::class, 'musica'])->name('herramientas.musica');
Route::post('/herramientas/metadatos',  [HerramientasController::class, 'metadatos'])->name('herramientas.metadatos');

Auth::routes();

