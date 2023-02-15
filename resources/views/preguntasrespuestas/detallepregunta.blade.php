@php
    
use Carbon\Carbon;

@endphp

@extends('layouts.home')

@section('title', 'Pregunta')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/chats/detallepregunta.css')}}">
@endpush

@section('content')


@if (!is_null($DatosPregunta))
    <input type="hidden" value="{{ $DatosPregunta->idPregunta}}" id="id-pregunta"/>

@else
    <input type="hidden" value="0" id="id-pregunta"/>
@endif

<input type="hidden" value="{{ asset('usuarios/').'/'}}" id="assets-usuarios"/>


<div class="col-md-12">
    <div class="container" id="contenedor">

        <div class="row segundo-color-fondo rounded-3 shadow-lg" id="informacion-pregunta">
            <div class="col-md-12 my-2">
                <div class="row g-5">

                    <div class="col-md-2">
                        <a type="button" class="btn btn-lg fuenteNormal tercer-color-fondo tercer-color-letra mx-1" title="Regresar a mis preguntas" href="{{route('preguntasrespuestas.inicio')}}">
                            <i class="fa-solid fa-hand-point-left fa-2x"></i>
                        </a>
                    </div>

                    <div class="col-md-8 text-center">
                        @if (!is_null($DatosPregunta))

                            @php
                                $fechaRegistro = new Carbon($DatosPregunta->fechaRegistro);
                                $fechaRegistroFormat = $fechaRegistro->format('d/m/Y h:i A'); 
                            @endphp

                            <p class="titulado fuenteGrande segundo-color-letra">{{$DatosPregunta->pregunta}}</p>
                            <p class="titulado fuenteNormal segundo-color-letra text-wrap">{{$DatosPregunta->descripcion}}</p>
                            <p class="titulado fuenteNormal segundo-color-letra">
                                <i class="fa-regular fa-envelope"></i>&nbsp;Por {{$DatosPregunta->nombreUsuario}} el {{$fechaRegistroFormat}}
                            </p>
                            <p class="titulado fuenteNormal segundo-color-letra text-wrap">{{$DatosPregunta->estatus}}</p>
                        @else
                            <p class="fuenteGrande segundo-color-letra">Pregunta desconocida</p>
                        @endif
                    </div>

                    <div class="col-md-2 text-center h-75">
                        @if(!is_null($DatosPregunta) && !is_null($DatosPregunta->imagenUsuario))
                            <img id="imagen-receptor" class="img-fluid rounded-circle shadow-lg h-75" alt="Imagen del usuario receptor" src="{{ asset('usuarios/'.$DatosPregunta->imagenUsuario)}}" />
                        @else
                            <img id="imagen-receptor" class="img-fluid rounded-circle shadow-lg h-75" alt="Imagen del usuario receptor" src="https://raw.githubusercontent.com/Brian-GL/CourseRoom/main/src/recursos/imagenes/Course_Room_Brand_Readme.png"/>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        
        <div class="row border-bottom-0 shadow-lg" id="contenido-pregunta">
            <div class="col-md-12 mt-5 mb-2" id="mensajes">

                @foreach ($Mensajes as $mensaje)

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
                                            <a href="{{ asset('chats/'.$mensaje->archivo)}}" target="_blank"><i class="fa-solid fa-file-lines"></i>&nbsp;{{$mensaje->mensaje}}</a>
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

                        <button type="button" class="btn fuenteNormal segundo-color-fondo segundo-color-letra mx-1" title="Enviar mensaje" id="enviar-mensaje">
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


@stop


@push('scripts')
<script type="module" src=" {{asset('assets/js/preguntas/detallepregunta.js')}}"></script>
@endpush
