<?php

use App\Http\Controllers\DefaultController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\AvisosController;
use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\GruposController;
use App\Http\Controllers\HerramientasController;
use App\Http\Controllers\PreguntasRespuestasController;
use App\Http\Controllers\TareasController;
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


#region Default

Route::get('/',  [DefaultController::class, 'acceso'])->name('inicio.acceso');
Route::get('/recuperacion',  [DefaultController::class, 'recuperacion'])->name('inicio.recuperacion');
Route::get('/registro',  [DefaultController::class, 'registro'])->name('inicio.registro');

Route::post('/default/acceder',  [DefaultController::class, 'acceder']);
Route::post('/default/recuperacion',  [DefaultController::class, 'recuperacion_credenciales']);
Route::post('/default/registrar',  [DefaultController::class, 'registrar_usuario']);


#endregion

#region Inicio

Route::get('/inicio',  [InicioController::class, 'inicio'])->name('inicio.inicio')->middleware('session.token');
Route::get('/acerca',  [InicioController::class, 'acerca'])->name('inicio.acerca')->middleware('session.token');


#endregion

#region Avisos

Route::get('/avisos',  [AvisosController::class, 'avisos'])->name('avisos.inicio')->middleware('session.token');


Route::put('/avisos/actualizar',  [AvisosController::class, 'aviso_actualizar'])->middleware('session.token');
Route::post('/avisos/registrar',  [AvisosController::class, 'aviso_registrar'])->middleware('session.token');
Route::delete('/avisos/remover',  [AvisosController::class, 'aviso_remover'])->middleware('session.token');
Route::post('/avisos/detalle',  [AvisosController::class, 'avisodetalle_obtener'])->middleware('session.token');
Route::post('/avisos/plagioprofesor',  [AvisosController::class, 'avisoplagioprofesor_registrar'])->middleware('session.token');
Route::post('/avisos/obtener',  [AvisosController::class, 'avisos_obtener'])->middleware('session.token');
Route::post('/avisos/validar',  [AvisosController::class, 'avisos_validar'])->middleware('session.token');

#endregion

#region Catalogos

Route::post('/catalogos/cursoestatus',  [CatalogosController::class, 'catalogocursoestatus_obtener'])->middleware('session.token');
Route::post('/catalogos/estados',  [CatalogosController::class, 'catalogoestados_obtener'])->middleware('session.token');
Route::post('/catalogos/estatustareapendiente',  [CatalogosController::class, 'catalogotareapendienteestatus_obtener'])->middleware('session.token');
Route::post('/catalogos/localidades',  [CatalogosController::class, 'catalogolocalidades_obtener'])->middleware('session.token');
Route::post('/catalogos/preguntarespuesta',  [CatalogosController::class, 'catalogopreguntarespuestaestatus_obtener'])->middleware('session.token');
Route::post('/catalogos/preguntascuestionario',  [CatalogosController::class, 'catalogopreguntascuestionario_obtener'])->middleware('session.token');
Route::post('/catalogos/tematicas',  [CatalogosController::class, 'catalogotematicas_obtener'])->middleware('session.token');
Route::post('/catalogos/tiposusuario',  [CatalogosController::class, 'catalogotiposusuario_obtener'])->middleware('session.token');

#endregion

#region Chats

Route::get('/conversaciones',  [ChatsController::class, 'chats'])->name('chats.inicio')->middleware('session.token');
Route::get('/chats/conversacion',  [ChatsController::class, 'conversacion'])->name('chats.conversacion')->middleware('session.token');

Route::post('/chats/conversacion',  [ChatsController::class, 'conversacion'])->middleware('session.token');
Route::post('/chats/registrar',  [ChatsController::class, 'chat_registrar'])->middleware('session.token');
Route::delete('/chats/remover',  [ChatsController::class, 'chat_remover'])->middleware('session.token');
Route::post('/chats/mensajeregistrar',  [ChatsController::class, 'chatmensaje_registrar'])->middleware('session.token');
Route::delete('/chats/mensajeremover',  [ChatsController::class, 'chatmensaje_remover'])->middleware('session.token');
Route::post('/chats/mensajesobtener',  [ChatsController::class, 'chatmensajes_obtener'])->middleware('session.token');
Route::post('/chats/buscar',  [ChatsController::class, 'chats_buscar'])->middleware('session.token');
Route::post('/chats/obtener',  [ChatsController::class, 'chats_obtener'])->middleware('session.token');

#endregion

#region Grupos

Route::put('/grupos/actualizar',  [GruposController::class, 'grupo_actualizar'])->middleware('session.token');
Route::post('/grupos/mensajes',  [GruposController::class, 'gruposmensajes_obtener'])->middleware('session.token');
Route::post('/grupos/obtener',  [GruposController::class, 'grupos_obtener'])->middleware('session.token');
Route::post('/grupos/miembros',  [GruposController::class, 'grupomiembros_obtener'])->middleware('session.token');
Route::post('/grupos/tareaspendientes',  [GruposController::class, 'grupotareaspendientes_obtener'])->middleware('session.token');
Route::post('/grupos/tareapendientedetalle',  [GruposController::class, 'grupotareapendientedetalle_obtener'])->middleware('session.token');
Route::put('/grupos/tareapendienteestatus',  [GruposController::class, 'grupotareapendienteestatus_actualizar'])->middleware('session.token');
Route::delete('/grupos/miembroremover',  [GruposController::class, 'grupomiembro_remover'])->middleware('session.token');
Route::post('/grupos/miembroregistrar',  [GruposController::class, 'grupomiembro_registrar'])->middleware('session.token');
Route::put('/grupos/tareapendienteactualizar',  [GruposController::class, 'grupotareapendiente_actualizar'])->middleware('session.token');
Route::post('/grupos/tareapendienteregistrar',  [GruposController::class, 'grupotareapendiente_registrar'])->middleware('session.token');

#endregion

#region Tareas

Route::get('/mis-tareas',  [TareasController::class, 'tareas'])->name('tareas.inicio')->middleware('session.token');

Route::post('/tareas/archivosadjuntos',  [TareasController::class, 'tareaarchivosadjuntos_obtener'])->middleware('session.token');
Route::post('/tareas/estudiantedetalle',  [TareasController::class, 'tareaestudiantedetalle_obtener'])->middleware('session.token');
Route::post('/tareas/mes',  [TareasController::class, 'tareasmes_obtener'])->middleware('session.token');
Route::post('/tareas/imagenesentregadas',  [TareasController::class, 'tareaimagenesentregadas_obtener'])->middleware('session.token');
Route::post('/tareas/retroalimentaciondetalle',  [TareasController::class, 'tarearetroalimentaciondetalle_obtener'])->middleware('session.token');
Route::post('/tareas/actualizar',  [TareasController::class, 'tarea_actualizar'])->middleware('session.token');
Route::post('/tareas/calificar',  [TareasController::class, 'tareacalificar_actualizar'])->middleware('session.token');
Route::post('/tareas/archivoentregado',  [TareasController::class, 'tareaarchivoentregado_registrar'])->middleware('session.token');
Route::post('/tareas/remover',  [TareasController::class, 'tarea_remover'])->middleware('session.token');
Route::post('/tareas/registrar',  [TareasController::class, 'tarea_registrar'])->middleware('session.token');
Route::post('/tareas/retroalimentacion',  [TareasController::class, 'tarearetroalimentacion_registrar'])->middleware('session.token');

#endregion

#region Herramientas

Route::get('/herramientas/musica',  [HerramientasController::class, 'musica'])->name('herramientas.musica')->middleware('session.token');
Route::get('/herramientas/matematicas',  [HerramientasController::class, 'matematicas'])->name('herramientas.matematicas')->middleware('session.token');
Route::post('/herramientas/metadatos',  [HerramientasController::class, 'metadatos'])->middleware('session.token');
Route::post('/herramientas/operador',  [HerramientasController::class, 'operador'])->middleware('session.token');
Route::post('/herramientas/multimedia',  [HerramientasController::class, 'multimedia'])->middleware('session.token');

#endregion

#region PreguntasRespuestas

Route::get('/preguntas',  [PreguntasRespuestasController::class, 'inicio'])->name('preguntasrespuestas.inicio')->middleware('session.token');

#endregion

#region Usuarios
Route::get('/perfil',  [UsuariosController::class, 'perfil'])->name('usuarios.perfil')->middleware('session.token');
Route::get('/sesiones',  [UsuariosController::class, 'sesiones'])->name('usuarios.sesiones')->middleware('session.token');

Route::post('/usuarios/actualizar',  [UsuariosController::class, 'usuario_actualizar'])->middleware('session.token');
Route::post('/usuarios/registrar',  [UsuariosController::class, 'usuario_registrar'])->middleware('session.token');
Route::delete('/usuarios/remover',  [UsuariosController::class, 'usuario_remover'])->middleware('session.token');
Route::post('/usuarios/acceso',  [UsuariosController::class, 'usuarioacceso_obtener'])->middleware('session.token');
Route::put('/usuarios/cuenta',  [UsuariosController::class, 'usuariocuenta_actualizar'])->middleware('session.token');
Route::post('/usuarios/cuentaobtener',  [UsuariosController::class, 'usuariocuenta_obtener'])->middleware('session.token');
Route::post('/usuarios/desempeno',  [UsuariosController::class, 'usuariodesempeno_obtener'])->middleware('session.token');
Route::post('/usuarios/desempenoregistrar',  [UsuariosController::class, 'usuariodesempeno_registrar'])->middleware('session.token');
Route::post('/usuarios/detalle',  [UsuariosController::class, 'usuariodetalle_obtener'])->middleware('session.token');
Route::post('/usuarios/nuevapuntualidad',  [UsuariosController::class, 'usuarionuevapuntualidadcurso_obtener'])->middleware('session.token');
Route::post('/usuarios/nuevapuntualidadgeneral',  [UsuariosController::class, 'usuarionuevapuntualidadgeneral_obtener'])->middleware('session.token');
Route::post('/usuarios/nuevopromedio',  [UsuariosController::class, 'usuarionuevopromediocurso_obtener'])->middleware('session.token');
Route::post('/usuarios/nuevopromediogeneral',  [UsuariosController::class, 'usuarionuevopromediogeneral_obtener'])->middleware('session.token');
Route::post('/usuarios/buscar',  [UsuariosController::class, 'usuarios_buscar'])->middleware('session.token');
Route::put('/usuarios/sesion',  [UsuariosController::class, 'usuariosesion_actualizar'])->middleware('session.token');
Route::post('/usuarios/sesionvalidar',  [UsuariosController::class, 'usuariosesion_validar'])->middleware('session.token');
Route::post('/usuarios/sesiones',  [UsuariosController::class, 'usuariosesiones_obtener'])->middleware('session.token');
Route::post('/usuarios/tematica',  [UsuariosController::class, 'usuariotematica_registrar'])->middleware('session.token');
Route::delete('/usuarios/tematicaremover',  [UsuariosController::class, 'usuariotematica_remover'])->middleware('session.token');
Route::post('/usuarios/tematicasobtener',  [UsuariosController::class, 'usuariotematicas_obtener'])->middleware('session.token');
Route::post('/usuarios/credencial',  [UsuariosController::class, 'usuariocredencial_obtener'])->middleware('session.token');

#endregion

Auth::routes();

