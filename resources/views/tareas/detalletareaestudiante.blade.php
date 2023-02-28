@php
use Carbon\Carbon;
@endphp

@extends('layouts.home')

@section('title', 'Detalle Tarea')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/tareas/detalletareaestudiante.css')}}">
@endpush

@section('content')

@if (!is_null($Datostarea))
    <input type="hidden" value="{{ $idtarea}}" id="id-tarea"/>
@else
    <input type="hidden" value="0" id="id-tarea"/>
@endif

<input type="hidden" value="{{ asset('usuarios/').'/'}}" id="assets-usuarios"/>
<input type="hidden" value="{{ asset('tareas/').'/'}}" id="assets-tareas"/>

<div class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-1 text-center">
                        <a type="button" class="btn fuenteNormal tercer-color-fondo tercer-color-letra" title="Regresar a mis tareas" href="{{route('tareas.inicio')}}">
                            <i class="fa-solid fa-hand-point-left fa-2x"></i>
                        </a> 
                    </div>
                    <div class="col-md-11">
                        <h2 class="d-inline my-3 display-6 text-start fw-bolder primer-color-letra">Detalle de la tarea</h2>
                    </div>
                </div>
                

                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-pills my-0-5 nav-fill" role="tablist">
                            <li class="nav-item btn" role="presentation">
                                <button class="nav-link active fuenteNormal primer-color-letra primer-color-fondo" id="datos-generales-tab" data-bs-toggle="tab" data-bs-target="#datos-generales" type="button" role="tab" aria-controls="datos-generales" aria-selected="true">Datos Generales</button>
                            </li>
                            <li class="nav-item btn" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="archivos-adjuntos-tab" data-bs-toggle="tab" data-bs-target="#archivos-adjuntos" type="button" role="tab" aria-controls="archivos-adjuntos" aria-selected="false">Archivos Adjuntos</button>
                            </li>
                            <li class="nav-item btn" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="archivos-entregados-tab" data-bs-toggle="tab" data-bs-target="#archivos-entregados" type="button" role="tab" aria-controls="archivos-entregados" aria-selected="false">Archivos Entregados</button>
                            </li>
                            <li class="nav-item btn" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="retroalimentaciones-tab" data-bs-toggle="tab" data-bs-target="#retroalimentaciones" type="button" role="tab" aria-controls="retroalimentaciones" aria-selected="false">Retroalimentaciones</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="box row pt-1">

                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="datos-generales" role="tabpanel" aria-labelledby="datos-generales-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    @if (!is_null($Datostarea))
                                       
                                        @php
                                            $fechaRegistro = new Carbon($Datostarea->fechaRegistro);
                                            $fechaRegistroFormat = $fechaRegistro->format('d/m/Y h:i A');
                                            $fechaActualizacionFormat = 'No disponible'; 
                                            
                                            if (!is_null($Datostarea->fechaActualizacion))
                                            {
                                                $fechaActualizacion = new Carbon($Datostarea->fechaActualizacion);
                                                $fechaActualizacionFormat = $fechaActualizacion->format('d/m/Y h:i A'); 
                                            }
                                           
                                        @endphp

                                        <div class="mt-1">
                                            <p class="titulado fuenteGrande segundo-color-letra d-inline" contenteditable="true" id="nombre-value"> {{$Datostarea->nombre}}</p> 
                                            <p class="fuenteNormal segundo-color-letra d-inline"><i class="fa-solid fa-pen-to-square"></i></p>
                                        </div>
                                        <div class="mt-2 mb-4">
                                            <p class="titulado fuenteNormal segundo-color-letra text-wrap d-inline" contenteditable="true" id="descripcion-value">{{$Datostarea->descripcion}}</p> 
                                            <p class="fuenteNormal segundo-color-letra d-inline"><i class="fa-solid fa-pen-to-square"></i></p>
                                        </div>
                                        <p class="titulado fuenteNormal segundo-color-letra">Creado el {{$fechaRegistroFormat}}</p>
                                        <p class="titulado fuenteNormal segundo-color-letra text-wrap">Del curso: <b>{{$Datostarea->curso}}</b></p>
                                        <p class="titulado fuenteNormal segundo-color-letra text-wrap">Actualizada: {{$fechaActualizacionFormat}}</p>
                                    @else
                                        <p class="fuenteGrande segundo-color-letra">tarea desconocido</p>
                                    @endif
                                </div>
        
                                <div class="col-md-6 text-center">
                                    @if(!is_null($Datostarea) && !is_null($Datostarea->imagen))
                                        <img id="imagen-tarea" class="img-fluid rounded-circle shadow-lg h-75 mb-1" alt="Imagen del tarea" src="{{ asset('tareas/'.$Datostarea->imagen)}}" />
                                    @else
                                        <img id="imagen-tarea" class="img-fluid rounded-circle shadow-lg h-75 mb-1" alt="Imagen del tarea" src="https://raw.githubusercontent.com/Brian-GL/CourseRoom/main/src/recursos/imagenes/Course_Room_Brand_Readme.png"/>
                                    @endif

                                    @if (!is_null($Datostarea))
                                        <div class="d-block mt-1 mx-2">
                                            <button id="actualizar-tarea" type="button" onclick="Actualizartarea()" class="btn btn-lg segundo-color-letra segundo-color-fondo">Actualizar tarea</button>
                                            <div class="btn btn-rounded tercer-color-letra tercer-color-fondo">
                                                <label class="form-label m-1 fuenteNormal" for="imagen">Cambiar imagen</label>
                                                <input type="file" class="form-control d-none fuenteNormal" id="imagen" accept="image/png, imagejpg, image/jpeg"/>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show active" id="archivos-adjuntos" role="tabpanel" aria-labelledby="archivos-adjuntos-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-archivos-adjuntos"> </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="archivos-entregados" role="tabpanel" aria-labelledby="archivos-entregados-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <div class="row">
                                        <div class="col-md-7"></div>
                                        <div class="col-md-2 d-flex justify-content-center">
                                            <button type="submit" class="w-100 btn tercer-color-letra tercer-color-fondo" id="subir-archivo-entregado">
                                                <i class="fa-solid fa-upload"></i>&nbsp;Subir archivo
                                            </button>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-2 d-flex justify-content-center">
                                            <button type="submit" class="w-100 btn primer-color-letra primer-color-fondo" id="entregar-tarea">
                                                <i class="fa-solid fa-upload"></i>&nbsp;Entregar tarea
                                            </button>
                                        </div>
                                    </div>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-archivos-entregados-estudiante"> </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="retroalimentaciones" role="tabpanel" aria-labelledby="retroalimentaciones-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-retroalimentaciones"> </table>
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

@stop

@push('scripts')
<script type="module" src=" {{asset('assets/js/tareas/detalletareaestudiante.js')}}"></script>
@endpush
