@php
use Carbon\Carbon;
@endphp

@extends('layouts.home')

@section('title', 'Detalle Tarea')

@push('styles')
<link rel="stylesheet" href="{{ asset ('css/tareas/detalletareaprofesor.css')}}">
@endpush

@section('content')

@if (!is_null($DatosTarea))
    <input type="hidden" value="{{ $IdTarea}}" id="id-tarea"/>
    <input type="hidden" value="{{ $IdUsuario}}" id="id-usuario"/>
@else
    <input type="hidden" value="0" id="id-tarea"/>
    <input type="hidden" value="0" id="id-usuario"/>
@endif

<div class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="row mb-2">
                    <div class="col-md-1 text-center">
                        <a type="button" class="btn fuenteNormal tercer-color-fondo tercer-color-letra" title="Regresar a mis tareas" href="{{route('tareas.inicio')}}">
                            <i class="fa-solid fa-hand-point-left fa-2x"></i>
                        </a> 
                    </div>
                    <div class="col-md-11">
                        <h2 class="d-inline my-3 display-6 text-start fw-bolder primer-color-letra">Detalle de la entrega de tarea</h2>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs my-0-5 justify-content-center" role="tablist">
                            <li class="nav-item mx-1" role="presentation">
                                <button class="nav-link active fuenteNormal primer-color-letra primer-color-fondo" id="datos-generales-tab" data-bs-toggle="tab" data-bs-target="#datos-generales" type="button" role="tab" aria-controls="datos-generales" aria-selected="true">Datos Generales</button>
                            </li>
                            <li class="nav-item mx-1" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="archivos-adjuntos-tab" data-bs-toggle="tab" data-bs-target="#archivos-adjuntos" type="button" role="tab" aria-controls="archivos-adjuntos" aria-selected="false">Archivos Adjuntos</button>
                            </li>
                            <li class="nav-item mx-1" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="archivos-entregados-tab" data-bs-toggle="tab" data-bs-target="#archivos-entregados" type="button" role="tab" aria-controls="archivos-entregados" aria-selected="false">Archivos Entregados</button>
                            </li>
                            <li class="nav-item mx-1" role="presentation">
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
                                    @if (!is_null($DatosTarea))
                                       
                                        @php
                                            $fechaRegistro = new Carbon($DatosTarea->fechaRegistro);
                                            $fechaRegistroFormat = $fechaRegistro->format('d/m/Y h:i A');

                                            $fechaEntrega = new Carbon($DatosTarea->fechaEntrega);
                                            $fechaEntregaFormat = $fechaRegistro->format('d/m/Y h:i A');

                                            $fechaCalificacionFormat = 'No disponible'; 
                                            
                                            if (!is_null($DatosTarea->fechaCalificacion))
                                            {
                                                $fechaCalificacion = new Carbon($DatosTarea->fechaCalificacion);
                                                $fechaCalificacionFormat = $fechaCalificacion->format('d/m/Y h:i A'); 
                                            }

                                            $fechaEntregadaFormat = 'No disponible'; 
                                            
                                            if (!is_null($DatosTarea->fechaEntregada))
                                            {
                                                $fechaEntregada = new Carbon($DatosTarea->fechaEntregada);
                                                $fechaEntregadaFormat = $fechaEntregada->format('d/m/Y h:i A'); 
                                            }
                                           
                                        @endphp

                                        <div class="mt-1">
                                            <p class="titulado fuenteGrande segundo-color-letra"> {{$DatosTarea->nombre}}</p> 
                                            <span class="fuenteNormal tercer-color-letra">{{$DatosTarea->estatus}}</span>
                                        </div>
                                        <div class="mt-2 mb-4">
                                            <p class="titulado fuenteNormal segundo-color-letra text-wrap">{{$DatosTarea->descripcion}}</p> 
                                        </div>
                                        
                                        <p class="titulado fuenteNormal segundo-color-letra">Creada el {{$fechaRegistroFormat}}</p>
                                        <p class="titulado fuenteNormal segundo-color-letra">Para entrega el <b>{{$fechaEntregaFormat}}</b></p>
                                       
                                       
                                    @else
                                        <p class="fuenteGrande segundo-color-letra">Tarea desconocida</p>
                                    @endif
                                </div>
        
                                <div class="col-md-6 text-center">
                                    @if(!is_null($DatosTarea))
                                        <img id="imagen-curso" class="image img-fluid rounded-circle shadow-lg mt-2" alt="Imagen del curso" src="{{ $DatosTarea->imagenCurso}}" />
                                        <p class="titulado fuenteNormal segundo-color-letra text-wrap">Del curso <b>{{$DatosTarea->curso}}</b></p>
                                        <hr><br>
                                        <p class="titulado fuenteNormal segundo-color-letra">Entregada el {{$fechaEntregadaFormat}}</p>
                                        <p class="titulado fuenteNormal segundo-color-letra">Calificada el <b>{{$fechaCalificacionFormat}}</b></p>
                                        <p class="titulado fuenteNormal segundo-color-letra">Calificación: <b>{{$DatosTarea->calificacion}}</b></p>
                                        <p class="titulado fuenteNormal segundo-color-letra">Puntualidad: <b>{{$DatosTarea->puntualidad}}</b></p>
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

                        <div class="tab-pane fade" id="archivos-entregados" role="tabpanel" aria-labelledby="archivos-entregados-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <div class="row">
                                        @if (!is_null($DatosTarea) && $DatosTarea->estatus != 'Calificada' && $DatosTarea->modificable)
                                            <div class="col-md-10"></div>
                                            <div class="col-md-2 d-flex justify-content-center">
                                                <button type="submit" class="w-100 btn primer-color-letra primer-color-fondo" id="calificar-tarea">
                                                    <b><i class="fa-solid fa-chalkboard-user"></i>&nbsp;Calificar tarea</b>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-archivos-entregados-profesor"> </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="retroalimentaciones" role="tabpanel" aria-labelledby="retroalimentaciones-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        @if (!is_null($DatosTarea) && $DatosTarea->modificable)
                                            <div class="col-md-10"></div>
                                            <div class="col-md-2 d-flex justify-content-center">
                                                <button type="submit" class="w-100 btn primer-color-letra primer-color-fondo" id="agregar-retroalimentacion">
                                                    <i class="fa-solid fa-graduation-cap"></i>&nbsp;Agregar retroalimentación
                                                </button>
                                            </div>
                                        @endif
                                    </div>
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


<!-- Modal Agregar Retroalimentación -->
<div class="modal fade text-center" id="agregar-retroalimentacion-modal" tabindex="-1" role="dialog" aria-labelledby="titulo-modal-agregar-retroalimentacion" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content primer-color-letra primer-color-fondo">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-modal-agregar-retroalimentacion">Agregar retroalimentación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="HEAD" id="form-agregar-retroalimentacion">
                <div class="modal-body">
                    <div class="container-fluid g-5">
                    
                        <div class="row mt-2">
                            <div class="col-md-12 form-group">
                                <label for="nombre-retroalimentacion" class="form-label">Nombre*</label>
                                <input type="text" class="form-control fuenteNormal tercer-color-fondo tercer-color-letra" name="nombre-retroalimentacion" id="nombre-retroalimentacion" placeholder="Ingrese el nombre de la retroalimentación" maxlength="150" minlength="3" required>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 form-group">
                                <label for="descripcion-retroalimentacion" class="form-label">Descripción*</label>
                                <textarea class="form-control fuenteNormal primer-color-fondo primer-color-letra" name="descripcion-retroalimentacion" cols="30" rows="10" id="descripcion-retroalimentacion" placeholder="Ingrese la descripción de la retroalimentación" maxlength="4000" required></textarea>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 form-group">
                                <label for="archivo-retroalimentacio" class="form-label">Archivo de retroalimentación</label>
                                <input type="file" class="form-control d-none fuenteNormal" id="archivo-retroalimentacion" />
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn segundo-color-letra segundo-color-fondo" data-bs-dismiss="modal">❌ Cancelar</button>
                    <button type="submit" class="btn tercer-color-letra tercer-color-fondo" id="crear-retroalimentacion">✅ Crear tarea pendiente</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detalle Retroalimentacion -->
<div class="modal fade text-center" id="detalle-retroalimentacion-modal" tabindex="-1" role="dialog" aria-labelledby="titulo-modal-detalle-retroalimentacion" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content primer-color-letra primer-color-fondo">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-modal-detalle-retroalimentacion">Detalle de la retroalimentación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid g-5">
                
                    <div class="row mt-2">
                        <div class="col-md-12 form-group">
                            <label for="nombre-detalle-retroalimentacion" class="form-label">Nombre</label>
                            <input type="text" class="form-control fuenteNormal tercer-color-fondo tercer-color-letra" name="nombre-detalle-retroalimentacion" id="nombre-detalle-retroalimentacion" readonly>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 form-group">
                            <label for="descripcion-detalle-retroalimentacion" class="form-label">Descripción</label>
                            <textarea class="form-control fuenteNormal primer-color-fondo primer-color-letra" name="descripcion-detalle-retroalimentacion" cols="30" rows="10" id="descripcion-detalle-retroalimentacion" readonly></textarea>
                        </div>
                    </div>
                    

                    <div class="row mt-4">
                        <div class="col-md-12 form-group">
                            <label for="archivo-detalle-retroalimentacion" class="form-label">Archivo de retroalimentación</label>
                            <input type="text" class="form-control fuenteNormal tercer-color-fondo tercer-color-letra" name="archivo-detalle-retroalimentacion" id="archivo-detalle-retroalimentacion" readonly>
                            <a href="" id="descargar-archivo-detalle-retroalimentacion" target="_blank" class="segundo-color-fondo segundo-color-letra">
                                <i class="fa-solid fa-file-arrow-down"></i>&nbsp;Descargar archivo
                            </a>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 form-group">
                            <label for="fecha-registro-detalle-retroalimentacion" class="form-label">Creada el</label>
                            <input class="fuenteNormal form-control tercer-color-fondo tercer-color-letra" type="datetime" name="fecha-registro-detalle-retroalimentacion" id="fecha-registro-detalle-retroalimentacion" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn segundo-color-letra segundo-color-fondo" data-bs-dismiss="modal">❌ Cerrar</button>
            </div>
        </div>
    </div>
</div>


@stop

@push('scripts')
<script type="module" src=" {{asset('js/tareas/detalletareaprofesor.js')}}"></script>
@endpush
