@php
    
use Carbon\Carbon;

@endphp

@extends('layouts.home')

@section('title', 'Conversacion')

@push('styles')
<link rel="stylesheet" href="{{ asset ('css/chats/detallechat.css')}}">
@endpush

@section('content')


@if (!is_null($DatosChat))
    <input type="hidden" value="{{ $DatosChat->IdChat}}" id="id-chat"/>
    <input type="hidden" value="{{ $DatosChat->IdUsuarioEmisor}}" id="id-usuario-emisor"/>
@else
    <input type="hidden" value="0" id="id-chat"/>
    <input type="hidden" value="0" id="id-usuario-emisor"/>
@endif

<div class="col-md-12">
    <div class="container" id="contenedor">

        <div class="row segundo-color-fondo rounded-3 shadow-lg" id="informacion-chat">
            <div class="col-md-12 my-2">
                <div class="row g-5">

                    <div class="col-md-2">
                        <a type="button" class="btn btn-lg fuenteNormal tercer-color-fondo tercer-color-letra mx-1" title="Regresar a mis chats" href="{{route('chats.inicio')}}">
                            <i class="fa-solid fa-hand-point-left fa-2x"></i>
                        </a>
                    </div>

                    <div class="col-md-8 text-center">
                        @if (!is_null($DatosChat))
                            <p class="titulado fuenteGrande segundo-color-letra">{{$DatosChat->NombreReceptor}}</p>
                            <p class="titulado fuenteNormal segundo-color-letra">
                                <i class="fa-solid fa-user-tie"></i>&nbsp;{{$DatosChat->TipoUsuarioReceptor}}
                            </p>
                            <a href="mailto:{{$DatosChat->CorreoReceptor}}" target="_blank" class="titulado fuenteNormal segundo-color-letra">
                                <i class="fa-regular fa-envelope"></i>&nbsp;{{$DatosChat->CorreoReceptor}}
                            </a>
                            
                        @else
                            <p class="fuenteGrande segundo-color-letra">Usuario desconocid@</p>
                        @endif
                    </div>

                    <div class="col-md-2 text-center h-75">
                        @if(!is_null($DatosCuenta) && !is_null($DatosCuenta->imagen))
                            <img id="imagen-receptor" class="img-fluid rounded-circle shadow-lg h-75 mini-image" alt="Imagen del usuario receptor" src="{{$DatosChat->ImagenReceptor}}" />
                        @else
                            <img id="imagen-receptor" class="img-fluid rounded-circle shadow-lg h-75 mini-image" alt="Imagen del usuario receptor" src="https://raw.githubusercontent.com/Brian-GL/CourseRoom/main/src/recursos/imagenes/Course_Room_Brand_Readme.png"/>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        
        <div class="row border-bottom-0 shadow-lg" id="contenido-chat">
            <div class="col-md-12 mt-5 mb-2" id="mensajes">

                @foreach ($Mensajes as $mensaje)

                    @if (!is_null($DatosChat) && $mensaje->idUsuarioEmisor == $DatosChat->IdUsuarioEmisor)
                        
                        <!-- Usuario actual -->
                        <div class="col-md-12 d-flex justify-content-end">
                            <div class="d-flex justify-content-start mb-4">
                                <div class="card mask-custom">
                                    <div class="card-header d-flex justify-content-between p-2" style="border-bottom: 1px solid rgba(255,255,255,.3);">
                                        <div class="col-md-6 text-center text-wrap">
                                            <p class="text-start fw-bold mb-0 me-1">{{$mensaje->nombreUsuarioEmisor}}</p>
                                        </div>
                                        <div class="col-md-6 text-center text-wrap">
                                            @php
                                                $fechaRegistro = new Carbon($mensaje->fechaRegistro);
                                                $fechaRegistroFormat = $fechaRegistro->format('d/m/Y h:i A'); 
                                            @endphp
                                            <p class="text-light small mb-0 text-end"><i class="far fa-clock"></i>&nbsp;{{$fechaRegistroFormat}}</p>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        @if (is_null($mensaje->archivo))
                                            <p class="mb-0">{{$mensaje->mensaje}}</p>
                                        @else
                                            <a download="{{$mensaje->mensaje}}" href="{{ $mensaje->archivo}}" target="_blank"><i class="fa-solid fa-file-lines"></i>&nbsp;{{$mensaje->mensaje}}</a>
                                        @endif
                                    
                                    </div>
                                </div>
                                <img src="{{ $mensaje->imagenEmisor}}" alt="avatar" class="m-2 rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60" height="60">
                            </div>
                        </div>

                    @else
                        <div class="col-md-12 d-flex justify-content-start">
                            <div class="d-flex justify-content-start mb-4">
                                <img src="{{ $mensaje->imagenEmisor}}" alt="avatar" class="me-2 rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60" height="60">
                                <div class="card mask-custom">
                                    <div class="card-header d-flex justify-content-between p-2" style="border-bottom: 1px solid rgba(255,255,255,.3);">
                                        <div class="col-md-6 text-center text-wrap">
                                            <p class="text-start fw-bold mb-0 me-1">{{$mensaje->nombreUsuarioEmisor}}</p>
                                        </div>
                                        <div class="col-md-6 text-center text-wrap">
                                            @php
                                                $fechaRegistro = new Carbon($mensaje->fechaRegistro);
                                                $fechaRegistroFormat = $fechaRegistro->format('d/m/Y h:i A'); 
                                            @endphp
                                            <p class="text-light small mb-0 text-end"><i class="far fa-clock"></i>&nbsp;{{$fechaRegistroFormat}}</p>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        @if (is_null($mensaje->archivo))
                                            <p class="mb-0">{{$mensaje->mensaje}}</p>
                                        @else
                                            <a download="{{$mensaje->mensaje}}" href="{{ $mensaje->archivo}}" target="_blank"><i class="fa-solid fa-file-lines"></i>&nbsp;{{$mensaje->mensaje}}</a>
                                        @endif
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="row primer-color-fondo rounded-3 shadow-lg" id="mensajear-chat">
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
<script type="module" src=" {{asset('js/chats/detallechat.js')}}"></script>
@endpush
