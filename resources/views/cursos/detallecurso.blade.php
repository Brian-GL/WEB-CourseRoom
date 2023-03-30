@php
    
use Carbon\Carbon;

@endphp

@extends('layouts.home')

@section('title', 'Curso')

@push('styles')
<link rel="stylesheet" href="{{ asset ('css/cursos/detallecurso.css')}}">
@endpush

@section('content')


@if (!is_null($DatosCurso))
    <input type="hidden" value="{{ $IdCurso}}" id="id-curso"/>
@else
    <input type="hidden" value="0" id="id-curso"/>
@endif

<div class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

            <div class="row my-2">
                <div class="col-md-12 d-flex">
                    <a type="button" class="btn fuenteNormal tercer-color-fondo tercer-color-letra align-items-center" title="Regresar a mis cursos" href="{{route('cursos.inicio')}}">
                        <i class="fa-solid fa-hand-point-left fa-2x"></i>
                    </a> 
                    <span class="ps-1 d-inline fs-2 text-start fw-bolder primer-color-letra">Detalle del curso</h2>
                </div>
            </div>
                
            <div class="row">
                <div class="col-md-12 text-center">
                    @if (!is_null($DatosCurso))
                        <img id="imagen-curso" class="image img-fluid rounded-circle shadow-lg h-75 mb-1" alt="Imagen del curso" src="{{ $DatosCurso->imagen}}" />
                    @endif
                </div>
            </div>

            <div class="row">

                <div class="col-md-6">
                    @if (!is_null($DatosCurso))
                        
                        @php
                            $fechaRegistro = new Carbon($DatosCurso->fechaRegistro);
                            $fechaRegistroFormat = $fechaRegistro->format('d/m/Y h:i A');
                        @endphp
                        <div class="mt-1">
                            <p class="titulado fuenteGrande segundo-color-letra" id="nombre-curso"> {{$DatosCurso->nombre}}</p> 
                        </div>
                        <div class="mt-2 mb-4">
                            <p class="titulado fuenteNormal segundo-color-letra text-wrap">{{$DatosCurso->descripcion}}</p> 
                        </div>
                        <div class="mt-2 mb-4">
                            <p class="titulado fuenteNormal segundo-color-letra">Creada el {{$fechaRegistroFormat}}</p>
                        </div>
                        
                        @if($IdTipoUsuario == 1)
                            <button class="btn btn-lg tercer-color-letra tercer-color-fondo" id="enrolar-curso" title="Enrolarse a este curso">
                                <i class="fa-solid fa-school"></i>&nbsp;Enrolarme 👩🏽‍🎓
                            </button>
                        @endif

                    @else
                        <p class="fuenteGrande segundo-color-letra">Curso desconocido</p>
                    @endif
                </div>

                <div class="col-md-6 text-center">
                    @if(!is_null($DatosCurso))
                        @if( !is_null($DatosCurso->imagenProfesor))
                            <img id="imagen-profesor" class="image img-fluid rounded-circle shadow-lg h-75 mb-1" alt="Imagen del profesor" src="{{ $DatosCurso->imagenProfesor}}" />
                        @endif
                        <p class="titulado fuenteNormal segundo-color-letra">Creada por el profesor {{$DatosCurso->nombreProfesor}}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@stop


@push('scripts')
<script type="module" src=" {{asset('js/cursos/detallecurso.js')}}"></script>
@endpush
