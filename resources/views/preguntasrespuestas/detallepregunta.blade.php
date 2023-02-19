@php
    
use Carbon\Carbon;

@endphp

@extends('layouts.home')

@section('title', 'Pregunta')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/preguntasrespuestas/detallepregunta.css')}}">
@endpush

@section('content')


@if (!is_null($DatosPregunta))
    <input type="hidden" value="{{ $idPreguntaRespuesta}}" id="id-pregunta"/>
@else
    <input type="hidden" value="0" id="id-pregunta"/>
@endif

<input type="hidden" value="{{ asset('usuarios/').'/'}}" id="assets-usuarios"/>

<div class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2 class="my-3 display-5 text-start fw-bolder primer-color-letra">Detalle de la pregunta</h2>

                <div class="row">
                    <div class="col-md-1">
                        <a type="button" class="btn fuenteNormal tercer-color-fondo tercer-color-letra" title="Regresar a mis preguntas" href="{{route('preguntasrespuestas.inicio')}}">
                            <i class="fa-solid fa-hand-point-left fa-2x"></i>
                        </a>
                    </div>
                    <div class="col-md-11">
                        <ul class="nav nav-pills my-0-5 nav-fill" role="tablist">
                            <li class="nav-item btn" role="presentation">
                                <button class="nav-link active fuenteNormal primer-color-letra primer-color-fondo" id="datos-generales-tab" data-bs-toggle="tab" data-bs-target="#datos-generales" type="button" role="tab" aria-controls="datos-generales" aria-selected="true">Datos generales</button>
                            </li>
                            <li class="nav-item btn" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="respuestas-tab" data-bs-toggle="tab" data-bs-target="#respuestas" type="button" role="tab" aria-controls="respuestas" aria-selected="false">Respuestas</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="box row pt-1">

                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="datos-generales" role="tabpanel" aria-labelledby="datos-generales-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    @if (!is_null($DatosPregunta))
                                       
                                        @php
                                            $fechaRegistro = new Carbon($DatosPregunta->fechaRegistro);
                                            $fechaRegistroFormat = $fechaRegistro->format('d/m/Y h:i A');
                                            $fechaActualizacionFormat = 'No disponible'; 
                                            
                                            if (!is_null($DatosPregunta->fechaActualizacion))
                                            {
                                                $fechaActualizacion = new Carbon($DatosPregunta->fechaActualizacion);
                                                $fechaActualizacionFormat = $fechaActualizacion->format('d/m/Y h:i A'); 
                                            }
                                           
                                        @endphp

                                        @if (!is_null($IdUsuario) && $IdUsuario = $DatosPregunta->idUsuario && $DatosPregunta->estatusPregunta == 'Abierta')
                                            <div class="mt-1">
                                                <p class="titulado fuenteGrande segundo-color-letra d-inline" contenteditable="true"> {{$DatosPregunta->pregunta}}</p> 
                                                <p class="fuenteNormal segundo-color-letra d-inline"><i class="fa-solid fa-pen-to-square"></i></p>
                                            </div>
                                            <div class="mt-2 mb-4">
                                                <p class="titulado fuenteNormal segundo-color-letra text-wrap d-inline" contenteditable="true">{{$DatosPregunta->descripcion}}</p> 
                                                <p class="fuenteNormal segundo-color-letra d-inline"><i class="fa-solid fa-pen-to-square"></i></p>
                                            </div>
                                        @else
                                            <p class="titulado fuenteGrande segundo-color-letra"> {{$DatosPregunta->pregunta}}</p>
                                            <p class="titulado fuenteNormal segundo-color-letra text-wrap">{{$DatosPregunta->descripcion}}</p>
                                        @endif
                                        <p class="titulado fuenteNormal segundo-color-letra">Por {{$DatosPregunta->nombreUsuario}} el {{$fechaRegistroFormat}}</p>
                                        <p class="titulado fuenteNormal segundo-color-letra text-wrap">Estatus: <b>{{$DatosPregunta->estatusPregunta}}</b></p>
                                        <p class="titulado fuenteNormal segundo-color-letra text-wrap">Actualizada: {{$fechaActualizacionFormat}}</p>
                                    @else
                                        <p class="fuenteGrande segundo-color-letra">Pregunta desconocida</p>
                                    @endif
                                </div>
        
                                <div class="col-md-6 text-center">
                                    @if(!is_null($DatosPregunta) && !is_null($DatosPregunta->imagenUsuario))
                                        <img id="imagen-receptor" class="img-fluid rounded-circle shadow-lg h-75 mb-1" alt="Imagen del usuario receptor" src="{{ asset('usuarios/'.$DatosPregunta->imagenUsuario)}}" />
                                    @else
                                        <img id="imagen-receptor" class="img-fluid rounded-circle shadow-lg h-75 mb-1" alt="Imagen del usuario receptor" src="https://raw.githubusercontent.com/Brian-GL/CourseRoom/main/src/recursos/imagenes/Course_Room_Brand_Readme.png"/>
                                    @endif

                                    @if (!is_null($DatosPregunta) && !is_null($IdUsuario) && $IdUsuario = $DatosPregunta->idUsuario && $DatosPregunta->estatusPregunta == 'Abierta')
                                        <div class="d-block mt-1 mx-2">
                                            <button id="actualizar-pregunta" type="button" class="btn btn-lg segundo-color-letra segundo-color-fondo">Actualizar pregunta</button>
                                            <button id="solucionar-pregunta" type="button" class="btn btn-lg primer-color-letra primer-color-fondo">Marcar solucionada</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="respuestas" role="tabpanel" aria-labelledby="respuestas-tab">
                            
                            <div class="row border-bottom-0 shadow-lg" id="contenido-pregunta">
                                <div class="col-md-12 mt-5 mb-2" id="mensajes">
                    
                                    @foreach ($Respuestas as $mensaje)
                    
                                        <div class="col-md-12 d-flex justify-content-start">
                                            <div class="w-50">
                                                <div class="d-flex justify-content-start mb-4">
                                                    <img src="{{ asset('usuarios/'.$mensaje->imagenEmisor)}}" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60">
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
                                                                <a href="{{ asset('preguntas/'.$mensaje->archivo)}}" target="_blank"><i class="fa-solid fa-file-lines"></i>&nbsp;{{$mensaje->mensaje}}</a>
                                                            @endif
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                    
                                    @endforeach
                                </div>
                            </div>
                    
                            <div class="row primer-color-fondo rounded-3 shadow-lg" id="mensajear-pregunta">
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

                    </div>

                </div>

            </div>


        </div>
    </div>
</div>



@stop


@push('scripts')
<script type="module" src=" {{asset('assets/js/preguntasrespuestas/detallepregunta.js')}}"></script>
@endpush
