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
use App\Http\Controllers\CursosController;
use App\Http\Controllers\ArchivosController;
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
Route::post('/catalogos/tiposarchivo',  [CatalogosController::class, 'catalogotiposarchivo_obtener'])->middleware('session.token');

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

Route::get('/mis-grupos',  [GruposController::class, 'grupos'])->name('grupos.inicio')->middleware('session.token');

Route::post('/grupos/detalle',  [GruposController::class, 'gruposdetalle_obtener'])->middleware('session.token');
Route::post('/grupos/actualizar',  [GruposController::class, 'grupo_actualizar'])->middleware('session.token');
Route::post('/grupos/mensajes',  [GruposController::class, 'gruposmensajes_obtener'])->middleware('session.token');
Route::post('/grupos/obtener',  [GruposController::class, 'grupos_obtener'])->middleware('session.token');
Route::post('/grupos/miembros',  [GruposController::class, 'grupomiembros_obtener'])->middleware('session.token');
Route::post('/grupos/archivoscompartidos',  [GruposController::class, 'grupoarchivoscompartidos_obtener'])->middleware('session.token');
Route::post('/grupos/archivocompartidoregistrar',  [GruposController::class, 'grupoarchivocompartido_registrar'])->middleware('session.token');
Route::post('/grupos/tareaspendientes',  [GruposController::class, 'grupotareaspendientes_obtener'])->middleware('session.token');
Route::post('/grupos/tareapendientedetalle',  [GruposController::class, 'grupotareapendientedetalle_obtener'])->middleware('session.token');
Route::post('/grupos/tareapendienteestatus',  [GruposController::class, 'grupotareapendienteestatus_actualizar'])->middleware('session.token');
Route::delete('/grupos/miembroremover',  [GruposController::class, 'grupomiembro_remover'])->middleware('session.token');
Route::post('/grupos/miembroregistrar',  [GruposController::class, 'grupomiembro_registrar'])->middleware('session.token');
Route::put('/grupos/tareapendienteactualizar',  [GruposController::class, 'grupotareapendiente_actualizar'])->middleware('session.token');
Route::post('/grupos/tareapendienteregistrar',  [GruposController::class, 'grupotareapendiente_registrar'])->middleware('session.token');
Route::post('/grupos/registrar',  [GruposController::class, 'grupos_registrar'])->middleware('session.token');
Route::delete('/grupos/remover',  [GruposController::class, 'grupos_remover'])->middleware('session.token');
Route::put('/grupos/abandonaractualizar',  [GruposController::class, 'gruposabandonar_actualizar'])->middleware('session.token');
Route::delete('/grupos/archivocompartidoremover',  [GruposController::class, 'gruposarchivocompartido_remover'])->middleware('session.token');
Route::post('/grupos/mensajeregistrar',  [GruposController::class, 'gruposmensaje_registrar'])->middleware('session.token');
Route::delete('/grupos/mensajeremover',  [GruposController::class, 'gruposmensaje_remover'])->middleware('session.token');


#endregion

#region Tareas

Route::get('/mis-tareas',  [TareasController::class, 'tareas'])->name('tareas.inicio')->middleware('session.token');
Route::post('/tareas/estudiantedetalle',  [TareasController::class, 'tareaestudiantedetalle_obtener'])->middleware('session.token');
Route::post('/tareas/profesordetalle',  [TareasController::class, 'tareaprofesordetalle_obtener'])->middleware('session.token');
Route::post('/tareas/detalle',  [TareasController::class, 'tareadetalle_obtener'])->middleware('session.token');

Route::post('/tareas/archivosadjuntos',  [TareasController::class, 'tareaarchivosadjuntos_obtener'])->middleware('session.token');
Route::post('/tareas/mes',  [TareasController::class, 'tareasmes_obtener'])->middleware('session.token');
Route::post('/tareas/retroalimentaciondetalle',  [TareasController::class, 'tarearetroalimentaciondetalle_obtener'])->middleware('session.token');
Route::post('/tareas/actualizar',  [TareasController::class, 'tarea_actualizar'])->middleware('session.token');
Route::post('/tareas/calificar',  [TareasController::class, 'tareacalificar_actualizar'])->middleware('session.token');
Route::post('/tareas/archivoentregado',  [TareasController::class, 'tareaarchivoentregado_registrar'])->middleware('session.token');
Route::post('/tareas/remover',  [TareasController::class, 'tarea_remover'])->middleware('session.token');
Route::post('/tareas/registrar',  [TareasController::class, 'tarea_registrar'])->middleware('session.token');
Route::post('/tareas/retroalimentacion',  [TareasController::class, 'tarearetroalimentacion_registrar'])->middleware('session.token');
Route::post('/tareas/archivosentregados',  [TareasController::class, 'tareaarchivosentregados_obtener'])->middleware('session.token');
Route::post('/tareas/estudiante',  [TareasController::class, 'tareaestudiante_obtener'])->middleware('session.token');
Route::post('/tareas/creadasprofesor',  [TareasController::class, 'tareascreadasprofesor_obtener'])->middleware('session.token');
Route::post('/tareas/retroalimentaciones',  [TareasController::class, 'tareareatroalimentaciones_obtener'])->middleware('session.token');
Route::post('/tareas/calificarobtener',  [TareasController::class, 'tareascalificar_obtener'])->middleware('session.token');
Route::post('/tareas/entregar',  [TareasController::class, 'tareaentregar_actualizar'])->middleware('session.token');
Route::post('/tareas/archivoentregadoremover',  [TareasController::class, 'tareaarchivoentregado_remover'])->middleware('session.token');
Route::post('/tareas/archivoadjunto',  [TareasController::class, 'tareaarchivoadjunto_remover'])->middleware('session.token');
Route::post('/tareas/archivoadjuntoregistrar',  [TareasController::class, 'tareaarchivoadjunto_registrar'])->middleware('session.token');


#endregion

#region Herramientas

Route::get('/herramientas/musica',  [HerramientasController::class, 'musica'])->name('herramientas.musica')->middleware('session.token');
Route::get('/herramientas/matematicas',  [HerramientasController::class, 'matematicas'])->name('herramientas.matematicas')->middleware('session.token');
Route::post('/herramientas/metadatos',  [HerramientasController::class, 'metadatos'])->middleware('session.token');
Route::post('/herramientas/operador',  [HerramientasController::class, 'operador'])->middleware('session.token');
Route::post('/herramientas/multimedia',  [HerramientasController::class, 'multimedia'])->middleware('session.token');

#endregion

#region PreguntasRespuestas

Route::get('/preguntas-y-respuestas',  [PreguntasRespuestasController::class, 'inicio'])->name('preguntasrespuestas.inicio')->middleware('session.token');

Route::post('/preguntas/actualizar',  [PreguntasRespuestasController::class, 'pregunta_actualizar'])->middleware('session.token');
Route::post('/preguntas/registrar',  [PreguntasRespuestasController::class, 'preguntasrespuesta_registar'])->middleware('session.token');
Route::delete('/preguntas/remover',  [PreguntasRespuestasController::class, 'preguntasrespuesta_remover'])->middleware('session.token');
Route::post('/preguntas/detalle',  [PreguntasRespuestasController::class, 'preguntasrespuestadetalle_obtener'])->middleware('session.token');
Route::post('/preguntas/estatusactualizar',  [PreguntasRespuestasController::class, 'preguntasrespuestaestatus_actualizar'])->middleware('session.token');
Route::post('/preguntas/mensajeregistrar',  [PreguntasRespuestasController::class, 'preguntasrespuestamensaje_registrar'])->middleware('session.token');
Route::delete('/preguntas/mensajeremover',  [PreguntasRespuestasController::class, 'preguntasrespuestamensaje_remover'])->middleware('session.token');
Route::post('/preguntas/mensajeobtener',  [PreguntasRespuestasController::class, 'preguntasrespuestamensajes_obtener'])->middleware('session.token');
Route::post('/preguntas/buscar',  [PreguntasRespuestasController::class, 'preguntasrespuestas_buscar'])->middleware('session.token');
Route::post('/preguntas/obtener',  [PreguntasRespuestasController::class, 'preguntasrespuestas_obtener'])->middleware('session.token');

#endregion

#region Usuarios
Route::get('/perfil',  [UsuariosController::class, 'perfil'])->name('usuarios.perfil')->middleware('session.token');
Route::get('/sesiones',  [UsuariosController::class, 'sesiones'])->name('usuarios.sesiones')->middleware('session.token');
Route::get('/mi-desempeno',  [UsuariosController::class, 'mi_desempeno'])->name('usuarios.midesempeno')->middleware('session.token');

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
Route::post('/usuarios/sesiones',  [UsuariosController::class, 'usuariosesiones_obtener'])->middleware('session.token');
Route::post('/usuarios/tematica',  [UsuariosController::class, 'usuariotematica_registrar'])->middleware('session.token');
Route::delete('/usuarios/tematicaremover',  [UsuariosController::class, 'usuariotematica_remover'])->middleware('session.token');
Route::post('/usuarios/tematicasobtener',  [UsuariosController::class, 'usuariotematicas_obtener'])->middleware('session.token');
Route::post('/usuarios/credencial',  [UsuariosController::class, 'usuariocredencial_obtener'])->middleware('session.token');
Route::post('/usuarios/informacioncalculator',  [UsuariosController::class, 'usuariocalculatorinformacion_obtener'])->middleware('session.token');

#endregion


#region Cursos

Route::get('/mis-cursos',  [CursosController::class, 'cursos'])->name('cursos.inicio')->middleware('session.token');
Route::post('/cursos/detalle',  [CursosController::class, 'detallecurso'])->middleware('session.token');
Route::post('/cursos/detalleestudiante',  [CursosController::class, 'detallecursoestudiante'])->middleware('session.token');
Route::post('/cursos/detalleprofesor',  [CursosController::class, 'detallecursoprofesor'])->middleware('session.token');

Route::post('/cursos/registrar',  [CursosController::class, 'curso_registrar'])->middleware('session.token');
Route::delete('/cursos/remover',  [CursosController::class, 'curso_remover'])->middleware('session.token');
Route::post('/cursos/grupos',  [CursosController::class, 'curso_gruposobtener'])->middleware('session.token');
Route::post('/cursos/actualizar',  [CursosController::class, 'curso_actualizar'])->middleware('session.token');
Route::put('/cursos/abandonaractualizar',  [CursosController::class, 'curso_abandonaractualizar'])->middleware('session.token');
Route::put('/cursos/cuestionarioabandonaractualizar',  [CursosController::class, 'curso_cuestionarioabandonaractualizar'])->middleware('session.token');
Route::post('/cursos/desempenoobtener',  [CursosController::class, 'curso_desempenoobtener'])->middleware('session.token');
Route::post('/cursos/estudianteregistrar',  [CursosController::class, 'curso_estudianteregistrar'])->middleware('session.token');
Route::post('/cursos/finalizaractualizar',  [CursosController::class, 'curso_finalizaractualizar'])->middleware('session.token');
Route::post('/cursos/materialesobtener',  [CursosController::class, 'cursomateriales_obtener'])->middleware('session.token');
Route::post('/cursos/materialregistrar',  [CursosController::class, 'curso_materialregistrar'])->middleware('session.token');
Route::post('/cursos/materialremover',  [CursosController::class, 'curso_materialremover'])->middleware('session.token');
Route::post('/cursos/mensajeregistrar',  [CursosController::class, 'curso_mensajeregistrar'])->middleware('session.token');
Route::delete('/cursos/mensajeremover',  [CursosController::class, 'curso_mensajeremover'])->middleware('session.token');
Route::post('/cursos/mensajesobtener',  [CursosController::class, 'curso_mensajesobtener'])->middleware('session.token');
Route::post('/cursos/estudianteobtener',  [CursosController::class, 'curso_estudianteobtener'])->middleware('session.token');
Route::post('/cursos/profesortareasobtener',  [CursosController::class, 'curso_profesortareasobtener'])->middleware('session.token');
Route::post('/cursos/buscarobtener',  [CursosController::class, 'curso_promedioobtener'])->middleware('session.token');
Route::post('/cursos/obtener',  [CursosController::class, 'curso_obtener'])->middleware('session.token');
Route::post('/cursos/nuevoobtener',  [CursosController::class, 'curso_nuevoobtener'])->middleware('session.token');
Route::post('/cursos/profesorobtener',  [CursosController::class, 'curso_profesorobtener'])->middleware('session.token');
Route::post('/cursos/tareasestudianteobtener',  [CursosController::class, 'curso_tareasestudianteobtener'])->middleware('session.token');
Route::post('/cursos/tematicaregistrar',  [CursosController::class, 'curso_tematicaregistrar'])->middleware('session.token');
Route::delete('/cursos/tematicaremover',  [CursosController::class, 'curso_tematicaremover'])->middleware('session.token');
Route::post('/cursos/tematicaobtener',  [CursosController::class, 'curso_tematicaobtener'])->middleware('session.token');
Route::post('/cursos/estudiantedesempenoobtener',  [CursosController::class, 'curso_estudiantedesempenoobtener'])->middleware('session.token');
Route::post('/cursos/estudiantessingrupoobtener',  [CursosController::class, 'curso_estudiantessingrupoobtener'])->middleware('session.token');
Route::post('/cursos/estudiantefinalizaractualizar',  [CursosController::class, 'curso_estudiantefinalizaractualizar'])->middleware('session.token');
Route::post('/cursos/cuestionariorespuestaregistrar',   [CursosController::class, 'curso_cuestionariorespuestaregistrar'])->middleware('session.token');
Route::post('/cursos/estudiantebuscar',   [CursosController::class, 'cursoestudiante_buscar'])->middleware('session.token');

#endregion

#region Archivo
Route::put('/archivo/actualizar',  [CursosController::class, 'archivo_actualizar'])->middleware('session.token');

#endregion
Auth::routes();

