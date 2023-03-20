@php
use Carbon\Carbon;
$max_date = Carbon::now()->addMonths(6)->toDateTimeString();
$min_date = Carbon::now()->toDateTimeString();
@endphp

@extends('layouts.home')

@section('title', 'Grupo')

@push('styles')
<link rel="stylesheet" href="{{ asset ('build/assets/detallegrupo.89d1a034.css')}}">
@endpush

@section('content')

@if (!is_null($DatosGrupo))
    <input type="hidden" value="{{ $idGrupo}}" id="id-grupo"/>
    <input type="hidden" value="{{$DatosGrupo->imagen}}" id="imagen-anterior">
@else
    <input type="hidden" value="0" id="id-grupo"/>
    <input type="hidden" value="" id="imagen-anterior">
@endif

<div class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-1 text-center">
                        <a type="button" class="btn fuenteNormal tercer-color-fondo tercer-color-letra" title="Regresar a mis grupos" href="{{route('grupos.inicio')}}">
                            <i class="fa-solid fa-hand-point-left fa-2x"></i>
                        </a> 
                    </div>
                    <div class="col-md-11">
                        <h2 class="d-inline my-3 display-6 text-start fw-bolder primer-color-letra">Detalle del grupo</h2>
                    </div>
                </div>
                

                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-pills my-0-5 nav-fill" role="tablist">
                            <li class="nav-item btn" role="presentation">
                                <button class="nav-link active fuenteNormal primer-color-letra primer-color-fondo" id="datos-generales-tab" data-bs-toggle="tab" data-bs-target="#datos-generales" type="button" role="tab" aria-controls="datos-generales" aria-selected="true">Datos generales</button>
                            </li>
                            <li class="nav-item btn" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="miembros-tab" data-bs-toggle="tab" data-bs-target="#miembros" type="button" role="tab" aria-controls="miembros" aria-selected="false">Miembros</button>
                            </li>
                            <li class="nav-item btn" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="mensajes-tab" data-bs-toggle="tab" data-bs-target="#mensajes" type="button" role="tab" aria-controls="mensajes" aria-selected="false">Mensajes</button>
                            </li>
                            <li class="nav-item btn" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="archivos-compartidos-tab" data-bs-toggle="tab" data-bs-target="#archivos-compartidos" type="button" role="tab" aria-controls="archivos-compartidos" aria-selected="false">Archivos compartidos</button>
                            </li>
                            <li class="nav-item btn" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="tareas-pendientes-tab" data-bs-toggle="tab" data-bs-target="#tareas-pendientes" type="button" role="tab" aria-controls="tareas-pendientes" aria-selected="false">Tareas pendientes</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="box row pt-1">

                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="datos-generales" role="tabpanel" aria-labelledby="datos-generales-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    @if (!is_null($DatosGrupo))
                                       
                                        @php
                                            $fechaRegistro = new Carbon($DatosGrupo->fechaRegistro);
                                            $fechaRegistroFormat = $fechaRegistro->format('d/m/Y h:i A');
                                            $fechaActualizacionFormat = 'No disponible'; 
                                            
                                            if (!is_null($DatosGrupo->fechaActualizacion))
                                            {
                                                $fechaActualizacion = new Carbon($DatosGrupo->fechaActualizacion);
                                                $fechaActualizacionFormat = $fechaActualizacion->format('d/m/Y h:i A'); 
                                            }
                                           
                                        @endphp

                                        <div class="mt-1">
                                            <p class="titulado fuenteGrande segundo-color-letra d-inline" contenteditable="true" id="nombre-value"> {{$DatosGrupo->nombre}}</p> 
                                            <p class="fuenteNormal segundo-color-letra d-inline"><i class="fa-solid fa-pen-to-square"></i></p>
                                        </div>
                                        <div class="mt-2 mb-4">
                                            <p class="titulado fuenteNormal segundo-color-letra text-wrap d-inline" contenteditable="true" id="descripcion-value">{{$DatosGrupo->descripcion}}</p> 
                                            <p class="fuenteNormal segundo-color-letra d-inline"><i class="fa-solid fa-pen-to-square"></i></p>
                                        </div>
                                        <p class="titulado fuenteNormal segundo-color-letra">Creado el {{$fechaRegistroFormat}}</p>
                                        <p class="titulado fuenteNormal segundo-color-letra text-wrap">Del curso: <b>{{$DatosGrupo->curso}}</b></p>
                                        <p class="titulado fuenteNormal segundo-color-letra text-wrap">Actualizada: {{$fechaActualizacionFormat}}</p>
                                    @else
                                        <p class="fuenteGrande segundo-color-letra">Grupo desconocido</p>
                                    @endif
                                </div>
        
                                <div class="col-md-6 text-center">
                                    @if(!is_null($DatosGrupo) && !is_null($DatosGrupo->imagen))
                                        <img id="imagen-grupo" class="img-fluid rounded-circle shadow-lg h-75 mb-1" alt="Imagen del grupo" src="{{ $DatosGrupo->imagen}}" />
                                    @else
                                        <img id="imagen-grupo" class="img-fluid rounded-circle shadow-lg h-75 mb-1" alt="Imagen del grupo" src="https://raw.githubusercontent.com/Brian-GL/CourseRoom/main/src/recursos/imagenes/Course_Room_Brand_Readme.png"/>
                                    @endif

                                    @if (!is_null($DatosGrupo))
                                        <div class="d-block mt-1 mx-2">
                                            <button id="actualizar-grupo" type="button" onclick="ActualizarGrupo()" class="btn btn-lg segundo-color-letra segundo-color-fondo">Actualizar grupo</button>
                                            <div class="btn btn-rounded tercer-color-letra tercer-color-fondo">
                                                <label class="form-label m-1 fuenteNormal" for="imagen">Cambiar imagen</label>
                                                <input type="file" class="form-control d-none fuenteNormal" id="imagen" accept="image/png, imagejpg, image/jpeg"/>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="miembros" role="tabpanel" aria-labelledby="miembros-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-miembros"> </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="mensajes" role="tabpanel" aria-labelledby="mensajes-tab">
                            
                            <div class="row border-bottom-0 shadow-lg" id="contenido-grupo">
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
                    
                            <div class="row primer-color-fondo rounded-3 shadow-lg" id="mensajear-grupo">
                                <div class="col-md-12 my-2">
                                    <div class="row g-5">
                                    
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
                                    
                                    </div>
                                </div>
                            </div>
                           
                        </div>

                        <div class="tab-pane fade" id="archivos-compartidos" role="tabpanel" aria-labelledby="archivos-compartidos-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <div class="row">
                                        <div class="col-md-10"></div>
                                        <div class="col-md-2 d-flex justify-content-center">
                                            <button type="submit" class="w-100 btn tercer-color-letra tercer-color-fondo" id="subir-archivo-compartido">
                                                <i class="fa-solid fa-upload"></i>&nbsp;Subir archivo compartido
                                            </button>
                                        </div>
                                    </div>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-archivos-compartidos"> </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tareas-pendientes" role="tabpanel" aria-labelledby="tareas-pendientes-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <div class="row">
                                        <div class="col-md-10"></div>
                                        <div class="col-md-2 d-flex justify-content-center">
                                            <button type="submit" class="w-100 btn tercer-color-letra tercer-color-fondo" id="crear-tarea-pendiente">
                                                <i class="fa-solid fa-upload"></i>&nbsp;Crear tarea
                                            </button>
                                        </div>
                                    </div>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-tareas-pendientes"> </table>
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

<!-- Modal Crear Tarea Pendiente -->
<div class="modal fade text-center" id="agregar-tarea-pendiente-modal" tabindex="-1" role="dialog" aria-labelledby="titulo-modal-agregar-tarea-pendiente" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content primer-color-letra primer-color-fondo">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-modal-agregar-tarea-pendiente">Agregar tarea pendiente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="HEAD" id="form-agregar-tarea-pendiente">
                <div class="modal-body">
                    <div class="container-fluid g-5">
                    
                        <div class="row mt-2">
                            <div class="col-md-12 form-group">
                                <label for="nombre-tarea-pendiente" class="form-label">Nombre*</label>
                                <input type="text" class="form-control fuenteNormal tercer-color-fondo tercer-color-letra" name="nombre-tarea-pendiente" id="nombre-tarea-pendiente" placeholder="Ingrese el nombre de la tarea pendiente" maxlength="150" minlength="3" required>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 form-group">
                                <label for="descripcion-tarea-pendiente" class="form-label">Descripción*</label>
                                <textarea class="form-control fuenteNormal primer-color-fondo primer-color-letra" name="descripcion-tarea-pendiente" cols="30" rows="10" id="descripcion-tarea-pendiente" placeholder="Ingrese la descripción de la tarea pendiente" maxlength="4000" required></textarea>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 form-group">
                                <label for="fecha-finalizacion-tarea-pendiente" class="form-label">Fecha de finalización</label>
                                <input class="fuenteNormal form-control tercer-color-fondo tercer-color-letra" type="datetime" name="fecha-finalizacion-tarea-pendiente" id="fecha-finalizacion-tarea-pendiente" min="{{$min_date}}" max="{{$max_date}}" required>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 form-group">
                                <label for="miembro-a-cargo-tarea-pendiente" class="form-label">Miembro a cargo</label>
                                <select class="form-select fuenteNormal form-select-lg primer-color-fondo primer-color-letra" name="miembro-a-cargo-tarea-pendiente" id="miembro-a-cargo-tarea-pendiente" required></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn segundo-color-letra segundo-color-fondo" data-bs-dismiss="modal">❌ Cancelar</button>
                    <button type="submit" class="btn tercer-color-letra tercer-color-fondo" id="crear-tarea-pendiente">✅ Crear tarea pendiente</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Detalle Tarea Pendiente -->
<div class="modal fade text-center" id="detalle-tarea-pendiente-modal" tabindex="-1" role="dialog" aria-labelledby="titulo-modal-detalle-tarea-pendiente" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content primer-color-letra primer-color-fondo">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-modal-detalle-tarea-pendiente">Detalle tarea pendiente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="HEAD" id="form-detalle-tarea-pendiente">
                <div class="modal-body">
                    <div class="container-fluid g-5">
                    
                        <input type="hidden" name="id-tarea-pendiente" id="id-tarea-pendiente" required>
                        <div class="row mt-2">
                            <div class="col-md-12 form-group">
                                <label for="nombre-detalle-tarea-pendiente" class="form-label">Nombre*</label>
                                <input type="text" class="form-control fuenteNormal tercer-color-fondo tercer-color-letra" name="nombre-detalle-tarea-pendiente" id="nombre-detalle-tarea-pendiente" placeholder="Ingrese el nombre de la tarea pendiente" maxlength="150" minlength="3" readonly>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 form-group">
                                <label for="descripcion-detalle-tarea-pendiente" class="form-label">Descripción</label>
                                <textarea class="form-control fuenteNormal primer-color-fondo primer-color-letra" name="descripcion-detalle-tarea-pendiente" cols="30" rows="10" id="descripcion-detalle-tarea-pendiente" placeholder="Ingrese la descripción de la tarea pendiente" maxlength="4000" readonly></textarea>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 form-group">
                                <label for="fecha-finalizacion-detalle-tarea-pendiente" class="form-label">Fecha de finalización</label>
                                <input class="fuenteNormal form-control tercer-color-fondo tercer-color-letra" type="datetime" name="fecha-finalizacion-detalle-tarea-pendiente" id="fecha-finalizacion-detalle-tarea-pendiente" readonly>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 form-group">
                                <label for="miembro-creador-detalle-tarea-pendiente" class="form-label">Creada por</label>
                                <input type="text" class="form-control fuenteNormal tercer-color-fondo tercer-color-letra" name="miembro-creador-detalle-tarea-pendiente" id="miembro-creador-detalle-tarea-pendiente" placeholder="Ingrese el nombre de la tarea pendiente" maxlength="150" minlength="3" readonly>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 form-group">
                                <label for="miembro-a-cargo-detalle-tarea-pendiente" class="form-label">Miembro a cargo</label>
                                <input type="text" class="form-control fuenteNormal tercer-color-fondo tercer-color-letra" name="miembro-a-cargo-detalle-tarea-pendiente" id="nombre-detalle-tarea-pendiente" placeholder="Ingrese el nombre de la tarea pendiente" maxlength="150" minlength="3" readonly>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 form-group">
                                <label for="fecha-registro-detalle-tarea-pendiente" class="form-label">Creada el</label>
                                <input class="fuenteNormal form-control tercer-color-fondo tercer-color-letra" type="datetime" name="fecha-registro-detalle-tarea-pendiente" id="fecha-registro-detalle-tarea-pendiente" readonly>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 form-group">
                                <label for="estatus-detalle-tarea-pendiente" class="form-label">Estatus</label>
                                <select class="form-select fuenteNormal form-select-lg primer-color-fondo primer-color-letra" name="estatus-detalle-tarea-pendiente" id="estatus-detalle-tarea-pendiente" required></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn segundo-color-letra segundo-color-fondo" data-bs-dismiss="modal">❌ Cancelar</button>
                    <button type="submit" class="btn tercer-color-letra tercer-color-fondo" id="crear-curso">✅ Actualizar estatus</button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop


@push('scripts')
<script type="module" src=" {{asset('build/assets/detallegrupo.67ebf81d.js')}}"></script>
@endpush
