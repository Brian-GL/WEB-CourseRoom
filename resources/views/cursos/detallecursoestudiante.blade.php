@php
use Carbon\Carbon;
@endphp

@extends('layouts.home')

@section('title', 'Detalle Curso')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/cursos/detallecursoestudiante.css')}}">
@endpush

@section('content')

@if (!is_null($DatosCurso))
    <input type="hidden" value="{{ $IdTarea}}" id="id-curso"/>
    <input type="hidden" value="{{ $IdUsuario}}" id="id-usuario"/>
    <input type="hidden" value="{{ $DatosCurso->finalizado}}" id="estatus-curso"/>
@else
    <input type="hidden" value="0" id="id-curso"/>
    <input type="hidden" value="0" id="id-usuario"/>
    <input type="hidden" value="false" id="estatus-curso"/>
@endif

<input type="hidden" value="{{ asset('usuarios/').'/'}}" id="assets-usuarios"/>
<input type="hidden" value="{{ asset('cursos/').'/'}}" id="assets-cursos"/>

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
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="mensajes-tab" data-bs-toggle="tab" data-bs-target="#mensajes" type="button" role="tab" aria-controls="mensajes" aria-selected="false">Mensajes</button>
                            </li>
                            @if (!is_null($DatosCurso) && !$DatosCurso->finalizado)
                                <li class="nav-item btn" role="presentation">
                                    <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="cuestionario-tab" data-bs-toggle="tab" data-bs-target="#cuestionario" type="button" role="tab" aria-controls="cuestionario" aria-selected="false">Cuestionario</button>
                                </li>
                            @endif
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
                                            $fechaRegistro = new Carbon($DatosCurso->fechaRegistroCurso);
                                            $fechaRegistroFormat = $fechaRegistro->format('d/m/Y h:i A');

                                            $fechaRegistroEstudiante = new Carbon($DatosCurso->fechaRegistro);
                                            $fechaRegistroEstudianteFormat = $fechaRegistroEstudiante->format('d/m/Y h:i A');

                                        @endphp

                                        <div class="mt-1">
                                            <p class="titulado fuenteGrande segundo-color-letra"> {{$DatosCurso->nombre}}</p> 
                                            <span class="fuenteNormal tercer-color-letra">{{$DatosCurso->descripcionEstatus}}</span>
                                        </div>
                                        <div class="mt-2 mb-4">
                                            <p class="titulado fuenteNormal segundo-color-letra text-wrap">{{$DatosCurso->descripcion}}</p> 
                                        </div>
                                        <p class="titulado fuenteNormal segundo-color-letra">Creado el {{$fechaRegistroFormat}}</p>
                                        <p class="titulado fuenteNormal segundo-color-letra">Miembro desde el <b>{{$fechaRegistroEstudianteFormat}}</b></p>
                                    @else
                                        <p class="fuenteGrande segundo-color-letra">Curso desconocido</p>
                                    @endif
                                </div>
        
                                <div class="col-md-6 text-center">
                                    @if(!is_null($DatosCurso))
                                        @if(!is_null($DatosCurso->imagen))
                                            <img id="imagen-curso" class="img-fluid rounded-circle shadow-lg h-75 mb-1" alt="Imagen del curso" src="{{ asset('cursos/'.$DatosCurso->imagenCurso)}}" />
                                        @endif
                                        @if( !is_null($DatosCurso->imagenProfesor))
                                            <img id="imagen-profesor" class="img-fluid rounded-circle shadow-lg h-75 mb-1" alt="Imagen del profesor" src="{{ asset('usuarios/'.$DatosCurso->imagenProfesor)}}" />
                                        @endif
                                        <p class="titulado fuenteNormal segundo-color-letra">Creada por {{$DatosCurso->nombreProfesor}}</p>
                                        <hr>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="miembros" role="tabpanel" aria-labelledby="miembros-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-miembros-estudiante"> </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tareas" role="tabpanel" aria-labelledby="tareas-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-tareas-estudiante-curso"> </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="desempeno" role="tabpanel" aria-labelledby="desempeno-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-curso-estudiante-desempeno"> </table>
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

                        <div class="tab-pane fade" id="mensajes" role="tabpanel" aria-labelledby="mensajes-tab">
                            
                            <div class="row border-bottom-0 shadow-lg" id="contenido-curso">
                                <div class="col-md-12 mt-5 mb-2" id="mensajes">
                    
                                    @foreach ($Mensajes as $mensaje)
                    
                                        <div class="col-md-12 d-flex justify-content-start">
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
                                                            <a href="{{ asset('cursos/'.$mensaje->archivo)}}" target="_blank"><i class="fa-solid fa-file-lines"></i>&nbsp;{{$mensaje->mensaje}}</a>
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

                        @if (!is_null($DatosCurso) && !$DatosCurso->finalizado)
                            <div class="tab-pane fade" id="cuestionario" role="tabpanel" aria-labelledby="cuestionario-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <form method="HEAD" id="form-cuestionario">

                                            <div class="row g-3 mt-2">
                                                
                                            </div>

                                        </form>
                                    
                                    </div>
                                </div>
                            </div>

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@push('scripts')
<script type="module" src=" {{asset('assets/js/cursos/detallecursoestudiante.js')}}"></script>
@endpush
