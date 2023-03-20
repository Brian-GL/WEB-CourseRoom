@php
use Carbon\Carbon;
@endphp

@extends('layouts.home')

@section('title', 'Detalle Tarea')

@push('styles')
<link rel="stylesheet" href="{{ asset ('build/assets/detalletarea.95be0adc.css')}}">
@endpush

@section('content')

@if (!is_null($DatosTarea))
    <input type="hidden" value="{{ $IdTarea}}" id="id-tarea"/>
    <input type="hidden" value="{{ $DatosTarea->estatus}}" id="estatus-tarea"/>
@else
    <input type="hidden" value="0" id="id-tarea"/>
    <input type="hidden" value="" id="estatus-tarea"/>
@endif

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
                        </ul>
                    </div>
                </div>

                <div class="box row pt-1">

                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="datos-generales" role="tabpanel" aria-labelledby="datos-generales-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    @if (!is_null($DatosTarea))
                                       
                                        @php
                                            $fechaRegistro = new Carbon($DatosTarea->fechaRegistro);
                                            $fechaRegistroFormat = $fechaRegistro->format('d/m/Y h:i A');

                                            $fechaEntrega = new Carbon($DatosTarea->fechaEntrega);
                                            $fechaEntregaFormat = $fechaRegistro->format('d/m/Y h:i A');

                                        @endphp

                                        <div class="mt-1">
                                            <p class="titulado fuenteGrande segundo-color-letra" contenteditable="true" id="nombre-tarea"> {{$DatosTarea->tarea}}</p> 
                                            <p class="fuenteNormal segundo-color-letra d-inline"><i class="fa-solid fa-pen-to-square"></i></p>
                                        </div>
                                        <div class="mt-2 mb-4">
                                            <p class="titulado fuenteNormal segundo-color-letra text-wrap" contenteditable="true" id="descripcion-tarea">{{$DatosTarea->descripcion}}</p> 
                                            <p class="fuenteNormal segundo-color-letra d-inline"><i class="fa-solid fa-pen-to-square"></i></p>
                                        </div>
                                        <p class="titulado fuenteNormal segundo-color-letra">Creada el {{$fechaRegistroFormat}}</p>
                                        <p class="titulado fuenteNormal segundo-color-letra">Para entrega el <b>{{$fechaEntregaFormat}}</b></p>
                                    @else
                                        <p class="fuenteGrande segundo-color-letra">Tarea desconocida</p>
                                    @endif
                                </div>
        
                                <div class="col-md-6 text-center">
                                    @if(!is_null($DatosTarea))
                                        @if(!is_null($DatosTarea->imagenCurso))
                                            <img id="imagen-curso" class="img-fluid rounded-circle shadow-lg h-75 mb-1" alt="Imagen del curso" src="{{ $DatosTarea->imagenCurso}}" />
                                        @endif
                                        <p class="titulado fuenteNormal segundo-color-letra text-wrap">Del curso <b>{{$DatosTarea->curso}}</b></p>

                                        <div class="d-block mt-1 mx-2">
                                            <button id="actualizar-tarea" type="button" class="btn btn-lg segundo-color-letra segundo-color-fondo">Actualizar tarea</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="archivos-adjuntos" role="tabpanel" aria-labelledby="archivos-adjuntos-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        @if (!is_null($DatosTarea) && $DatosTarea->modificable)
                                            <div class="col-md-10"></div>
                                            <div class="col-md-2 d-flex justify-content-center">
                                                <button type="submit" class="w-100 btn primer-color-letra primer-color-fondo" id="subir-archivo-adjunto">
                                                    <i class="fa-solid fa-file-pen"></i>&nbsp;Subir archivo adjunto
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-archivos-adjuntos"> </table>
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
<script type="module" src=" {{asset('build/assets/detalletarea.4a31c423.js')}}"></script>
@endpush
