@php
use Carbon\Carbon;
$max_date = Carbon::now()->addMonths(6)->toDateTimeString();
$min_date = Carbon::now()->addHours(8)->toDateTimeString();
@endphp

@extends('layouts.home')

@section('title', 'Detalle Curso')

@push('styles')
<link rel="stylesheet" href="{{ asset ('build/assets/detallecursoprofesor.88e9b477.css')}}">
@endpush

@section('content')

@if (!is_null($DatosCurso))
    <input type="hidden" value="{{ $IdTarea}}" id="id-curso"/>
    <input type="hidden" value="{{ $DatosCurso->finalizado}}" id="estatus-curso"/>
@else
    <input type="hidden" value="0" id="id-curso"/>
    <input type="hidden" value="false" id="estatus-curso"/>
@endif

<div class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-1 text-center">
                        <a type="button" class="btn fuenteNormal tercer-color-fondo tercer-color-letra" title="Regresar a mis cursos" href="{{route('cursos.inicio')}}">
                            <i class="fa-solid fa-hand-point-left fa-2x"></i>
                        </a> 
                    </div>
                    <div class="col-md-11">
                        <h2 class="d-inline my-3 display-6 text-start fw-bolder primer-color-letra">Detalle del curso</h2>
                    </div>
                </div>
                

                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-pills my-0-5 nav-fill" role="tablist">
                            <li class="nav-item btn" role="presentation">
                                <button class="nav-link active fuenteNormal primer-color-letra primer-color-fondo" id="datos-generales-tab" data-bs-toggle="tab" data-bs-target="#datos-generales" type="button" role="tab" aria-controls="datos-generales" aria-selected="true">Datos Generales</button>
                            </li>
                            <li class="nav-item btn" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="miembros-tab" data-bs-toggle="tab" data-bs-target="#miembros" type="button" role="tab" aria-controls="miembros" aria-selected="false">Miembros</button>
                            </li>
                            <li class="nav-item btn" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="tareas-tab" data-bs-toggle="tab" data-bs-target="#tareas" type="button" role="tab" aria-controls="tareas" aria-selected="false">Tareas</button>
                            </li>
                            <li class="nav-item btn" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="desempeno-tab" data-bs-toggle="tab" data-bs-target="#desempeno" type="button" role="tab" aria-controls="desempeno" aria-selected="false">Desempeño</button>
                            </li>
                            <li class="nav-item btn" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="materiales-tab" data-bs-toggle="tab" data-bs-target="#materiales" type="button" role="tab" aria-controls="materiales" aria-selected="false">Materiales</button>
                            </li>
                            <li class="nav-item btn" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="grupos-tab" data-bs-toggle="tab" data-bs-target="#grupos" type="button" role="tab" aria-controls="grupos" aria-selected="false">Grupos</button>
                            </li>
                            <li class="nav-item btn" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="mensajes-tab" data-bs-toggle="tab" data-bs-target="#mensajes" type="button" role="tab" aria-controls="mensajes" aria-selected="false">Mensajes</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="box row pt-1">

                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="datos-generales" role="tabpanel" aria-labelledby="datos-generales-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    @if (!is_null($DatosCurso))
                                       
                                        @php
                                            $fechaRegistro = new Carbon($DatosCurso->fechaRegistro);
                                            $fechaRegistroFormat = $fechaRegistro->format('d/m/Y h:i A');
                                        @endphp

                                        <div class="mt-1">
                                            <p class="titulado fuenteGrande segundo-color-letra"> {{$DatosCurso->nombre}}</p> 
                                        </div>
                                        <div class="mt-2 mb-4">
                                            <p class="titulado fuenteNormal segundo-color-letra text-wrap">{{$DatosCurso->descripcion}}</p> 
                                        </div>
                                        <p class="titulado fuenteNormal segundo-color-letra">Creado el {{$fechaRegistroFormat}}</p>
                                    @else
                                        <p class="fuenteGrande segundo-color-letra">Curso desconocido</p>
                                    @endif
                                </div>
        
                                <div class="col-md-6 text-center">
                                    @if(!is_null($DatosCurso))
                                        @if(!is_null($DatosCurso->imagen))
                                            <img id="imagen-curso" class="img-fluid rounded-circle shadow-lg h-75 mb-1" alt="Imagen del curso" src="{{$DatosCurso->imagen}}" />
                                        @endif
                                        @if( !is_null($DatosCurso->imagenProfesor))
                                            <img id="imagen-profesor" class="img-fluid rounded-circle shadow-lg h-75 mb-1" alt="Imagen del profesor" src="{{ $DatosCurso->imagenProfesor}}" />
                                        @endif
                                        <p class="titulado fuenteNormal segundo-color-letra">Creada por {{$DatosCurso->nombreProfesor}}</p>
                                        <hr>

                                        @php
                                            $fechaRegistro = new Carbon($DatosCurso->fechaRegistro);
                                        @endphp

                                        @if ($fechaRegistro->floatDiffInMonths(Carbon::now()) > 3)
                                            <div class="d-block mt-1 mx-2">
                                                <button id="finalizar-curso" type="button" onclick="ActualizarGrupo()" class="btn btn-lg segundo-color-letra segundo-color-fondo">Finalizar curso</button>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="miembros" role="tabpanel" aria-labelledby="miembros-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-miembros-profesor"> </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tareas" role="tabpanel" aria-labelledby="tareas-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        @if (!is_null($DatosCurso) && !$DatosCurso->finalizado)
                                            <div class="col-md-10"></div>
                                            <div class="col-md-2 d-flex justify-content-center">
                                                <button type="submit" class="w-100 btn tercer-color-letra tercer-color-fondo" id="crear-tarea">
                                                    <i class="fa-solid fa-briefcase"></i>&nbsp;Crear tarea
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-md-12"></div>
                                        @endif
                                    </div>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-tareas-profesor-curso"> </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="desempeno" role="tabpanel" aria-labelledby="desempeno-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-curso-desempeno"> </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="materiales" role="tabpanel" aria-labelledby="materiales-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <div class="row">
                                        @if (!is_null($DatosCurso) && !$DatosCurso->finalizado)
                                            <div class="col-md-10"></div>
                                            <div class="col-md-2 d-flex justify-content-center">
                                                <button type="submit" class="w-100 btn tercer-color-letra tercer-color-fondo" id="subir-material">
                                                    <i class="fa-solid fa-upload"></i>&nbsp;Subir material
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-md-12"></div>
                                        @endif
                                    </div>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-materiales"> </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="grupos" role="tabpanel" aria-labelledby="grupos-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <div class="row">
                                        @if (!is_null($DatosCurso) && !$DatosCurso->finalizado)
                                            <div class="col-md-10"></div>
                                            <div class="col-md-2 d-flex justify-content-center">
                                                <button type="submit" class="w-100 btn tercer-color-letra tercer-color-fondo" id="crear-grupo">
                                                    <i class="fa-solid fa-people-line"></i>&nbsp;Crear grupo
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-md-12"></div>
                                        @endif
                                    </div>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-grupos-curso"> </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="mensajes" role="tabpanel" aria-labelledby="mensajes-tab">
                            
                            <div class="row border-bottom-0 shadow-lg" id="contenido-curso">
                                <div class="col-md-12 mt-5 mb-2" id="mensajes">
                    
                                    @foreach ($Mensajes as $mensaje)
                    
                                        <div class="col-md-12 d-flex justify-content-start">
                                            <div class="d-flex justify-content-start mb-4">
                                                <img src="{{ $mensaje->imagenEmisor}}" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60">
                                                <div class="card mask-custom">
                                                    <div class="card-header d-flex justify-content-between p-3" style="border-bottom: 1px solid rgba(255,255,255,.3);">
                                                        <div class="col-md-6 text-center text-wrap">
                                                            <p class="fw-bold mb-0">{{$mensaje->nombreUsuarioEmisor}}</p>
                                                        </div>
                                                        <div class="col-md-6 text-center text-wrap">
                                                            @php
                                                                $fechaRegistro = new Carbon($mensaje->fechaRegistro);
                                                                $fechaRegistroFormat = $fechaRegistro->format('d/m/Y h:i A'); 
                                                            @endphp
                                                            <p class="text-light small mb-0"><i class="far fa-clock"></i>&nbsp;{{$fechaRegistroFormat}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                
                                                        @if (is_null($mensaje->archivo))
                                                            <p class="mb-0">{{$mensaje->mensaje}}</p>
                                                        @else
                                                            <a href="{{ $mensaje->archivo}}" target="_blank"><i class="fa-solid fa-file-lines"></i>&nbsp;{{$mensaje->mensaje}}</a>
                                                        @endif
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                    
                                    @endforeach
                                </div>
                            </div>
                    
                            <div class="row primer-color-fondo rounded-3 shadow-lg" id="mensajear-curso">
                                <div class="col-md-12 my-2">
                                    <div class="row g-5">
                                        @if (!is_null($DatosCurso) && !$DatosCurso->finalizado)
                                            <div class="col-md-11">
                                                <input type="text" class="w-100 fuenteNormal form-control tercer-color-fondo tercer-color-letra" type="text" id="mensaje" name="mensaje" placeholder="Escribe un mensaje..."  maxlength="4000" minlength="1"/>
                                            </div>
                                            <div class="col-md-1 d-flex justify-content-end">
                        
                                                <button type="button" class="btn fuenteNormal segundo-color-fondo segundo-color-letra mx-1" title="Enviar respuesta" id="enviar-mensaje">
                                                    <i class="fa-regular fa-paper-plane"></i> 
                                                </button>
                        
                                                <button type="button" class="btn fuenteNormal segundo-color-fondo segundo-color-letra mx-1" id="enviar-archivo" title="Enviar archivo">
                                                    <i class="fa-solid fa-file-arrow-up"></i>
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-md-12"></div>
                                        @endif
                                    
                                    </div>
                                </div>
                            </div>
                           
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Grupo -->
<div class="modal fade text-center" id="agregar-grupo-modal" tabindex="-1" role="dialog" aria-labelledby="titulo-modal-agregar-grupo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content primer-color-letra primer-color-fondo">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-modal-agregar-grupo">Agregar grupo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="HEAD" id="form-agregar-grupo">
                <div class="modal-body">
                    <div class="container-fluid g-5">
                    
                        <div class="row mt-2">
                            <div class="col-md-12 form-group">
                                <label for="nombre-grupo" class="form-label">Nombre*</label>
                                <input type="text" class="form-control fuenteNormal tercer-color-fondo tercer-color-letra" name="nombre-grupo" id="nombre-grupo" placeholder="Ingrese el nombre del grupo" maxlength="150" minlength="3" required>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 form-group">
                                <label for="descripcion-grupo" class="form-label">Descripción*</label>
                                <textarea class="form-control fuenteNormal primer-color-fondo primer-color-letra" name="descripcion-grupo" cols="30" rows="10" id="descripcion-grupo" placeholder="Ingrese la descripción del grupo" maxlength="4000" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn segundo-color-letra segundo-color-fondo" data-bs-dismiss="modal">❌ Cancelar</button>
                    <button type="submit" class="btn tercer-color-letra tercer-color-fondo" id="crear-grupo">✅ Crear grupo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Crear Tarea -->
<div class="modal fade text-center" id="agregar-tarea-modal" tabindex="-1" role="dialog" aria-labelledby="titulo-modal-agregar-tarea" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content primer-color-letra primer-color-fondo">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-modal-agregar-tarea">Agregar tarea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="HEAD" id="form-agregar-tarea">
                <div class="modal-body">
                    <div class="container-fluid g-5">
                    
                        <div class="row mt-2">
                            <div class="col-md-12 form-group">
                                <label for="nombre-tarea" class="form-label">Nombre*</label>
                                <input type="text" class="form-control fuenteNormal tercer-color-fondo tercer-color-letra" name="nombre-tarea" id="nombre-tarea" placeholder="Ingrese el nombre de la tarea" maxlength="150" minlength="3" required>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 form-group">
                                <label for="descripcion-tarea" class="form-label">Descripción*</label>
                                <textarea class="form-control fuenteNormal primer-color-fondo primer-color-letra" name="descripcion-tarea" cols="30" rows="10" id="descripcion-tarea" placeholder="Ingrese la descripción de la tarea" maxlength="4000" required></textarea>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 form-group">
                                <label for="fecha-entrega-tarea" class="form-label">Fecha de entrega</label>
                                <input class="fuenteNormal form-control tercer-color-fondo tercer-color-letra" type="datetime" name="fecha-entrega-tarea" id="fecha-entrega-tarea" min="{{$min_date}}" max="{{$max_date}}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn segundo-color-letra segundo-color-fondo" data-bs-dismiss="modal">❌ Cancelar</button>
                    <button type="submit" class="btn tercer-color-letra tercer-color-fondo" id="crear-tarea">✅ Crear tarea</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Asignar Usuario Grupo -->
<div class="modal fade text-center" id="agregar-usuario-grupo-modal" tabindex="-1" role="dialog" aria-labelledby="titulo-modal-agregar-usuario-grupo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content primer-color-letra primer-color-fondo">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-modal-agregar-grupo">Agregar usuario a grupo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="HEAD" id="form-agregar-usuario-grupo">
                <div class="modal-body">
                    <div class="container-fluid g-5">
                    
                        <input type="hidden" id="id-grupo" value="">

                        <div class="row mt-2">
                            <div class="col-md-12 form-group">
                                <label for="nombre-grupo-agregar-usuario" class="form-label">Grupo</label>
                                <input type="text" class="form-control fuenteNormal tercer-color-fondo tercer-color-letra" name="nombre-grupo-agregar-usuario" id="nombre-grupo-agregar-usuario" placeholder="Nombre del grupo" maxlength="150" minlength="3" readonly>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 form-group">
                                <label for="descripcion-grupo" class="form-label">Estudiante*</label>
                                <select id="select-usuario-agregar" class="form-control segundo-color-letra segundo-color-fondo" required>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn segundo-color-letra segundo-color-fondo" data-bs-dismiss="modal">❌ Cancelar</button>
                    <button type="submit" class="btn tercer-color-letra tercer-color-fondo" id="agregar-usuario-grupo">✅ Enrolar usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop

@push('scripts')
<script type="module" src=" {{asset('build/assets/detallecursoprofesor.44b3b530.js')}}"></script>
@endpush
