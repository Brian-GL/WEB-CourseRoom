<?php

use App\Http\Controllers\InicioController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\AvisosController;
use App\Http\Controllers\GruposController;
use App\Http\Controllers\HerramientasController;
use App\Http\Controllers\UsuariosController;
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
Route::get('/inicio',  [InicioController::class, 'inicio'])->name('inicio.inicio')->middleware('session.token');
Route::get('/acerca',  [InicioController::class, 'acerca'])->name('inicio.acerca')->middleware('session.token');

Route::post('/login',  [InicioController::class, 'login']);
Route::post('/recuperacion',  [InicioController::class, 'recuperacion_credenciales']);
Route::post('/registrar',  [InicioController::class, 'registrar_usuario']);

#endregion

#region Chats

Route::post('/chats/registrar',  [ChatsController::class, 'chat_registrar'])->middleware('session.token');

#endregion

#region Avisos

Route::put('/avisos/actualizar',  [AvisosController::class, 'aviso_actualizar'])->middleware('session.token');
Route::post('/avisos/registrar',  [AvisosController::class, 'aviso_registrar'])->middleware('session.token');

#endregion

#region Grupos

Route::put('/grupos/actualizar',  [GruposController::class, 'grupo_actualizar'])->middleware('session.token');

#endregion

#region Herramientas

Route::get('/herramientas/musica',  [HerramientasController::class, 'musica'])->name('herramientas.musica')->middleware('session.token');
Route::get('/herramientas/matematicas',  [HerramientasController::class, 'matematicas'])->name('herramientas.matematicas')->middleware('session.token');
Route::post('/herramientas/metadatos',  [HerramientasController::class, 'metadatos'])->middleware('session.token');
Route::post('/herramientas/operador',  [HerramientasController::class, 'operador'])->middleware('session.token');
Route::post('/herramientas/multimedia',  [HerramientasController::class, 'multimedia'])->middleware('session.token');

#endregion


#region Usuarios
Route::get('/perfil',  [UsuariosController::class, 'perfil'])->name('usuarios.perfil')->middleware('session.token');

Route::put('/usuarios/actualizar',  [UsuariosController::class, 'usuario_actualizar'])->middleware('session.token');

#endregion

Auth::routes();

