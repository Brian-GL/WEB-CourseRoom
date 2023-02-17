@extends('layouts.home')

@section('title', 'Cursos')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/cursos/cursos.css')}}">
@endpush

@section('content')

<input type="hidden" value="{{ asset('cursos/')}}" id="assets-cursos"/>
<input type="hidden" value="{{ asset('usuarios/')}}" id="assets-usuarios"/>
<input type="hidden" value="{{$IdTipoUsuario}}" id="id-tipo-usuario"/>


<div class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2 class="my-3 display-5 text-start fw-bolder primer-color-letra">Cursos</h2>

                @if ($IdTipoUsuario == 1)
                    <div class="row">
                        <ul class="nav nav-tabs my-0-5" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fuenteNormal primer-color-letra primer-color-fondo" id="cursos-actuales-tab" data-bs-toggle="tab" data-bs-target="#cursos-actuales" type="button" role="tab" aria-controls="cursos-actuales" aria-selected="true">Cursos actuales</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="cursos-finalizados-tab" data-bs-toggle="tab" data-bs-target="#cursos-finalizados" type="button" role="tab" aria-controls="cursos-finalizados" aria-selected="false">cursos finalizados</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="buscar-cursos-tab" data-bs-toggle="tab" data-bs-target="#buscar-cursos-finalizados" type="button" role="tab" aria-controls="cursos-finalizados" aria-selected="false">Buscar cursos</button>
                            </li>
                        </ul>
                    </div>
                @else

                <div class="row">
                    <div class="col-md-10">
                        <ul class="nav nav-tabs my-0-5" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fuenteNormal primer-color-letra primer-color-fondo" id="cursos-actuales-tab" data-bs-toggle="tab" data-bs-target="#cursos-actuales" type="button" role="tab" aria-controls="cursos-actuales" aria-selected="true">Cursos actuales</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="cursos-finalizados-tab" data-bs-toggle="tab" data-bs-target="#cursos-finalizados" type="button" role="tab" aria-controls="cursos-finalizados" aria-selected="false">cursos finalizados</button>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-2 d-flex justify-content-end">
                        <button class="btn fuenteNormal my-1 text-wrap border border-2 tercer-color-letra tercer-color-fondo" type="button" id="agregar-curso" >
                            <i class="fa-solid fa-plus"></i> Agregar Curso
                        </button>
                    </div>
                </div>
                @endif

                <div class="box row pt-1">

                    <div class="tab-content">

                        @if ($IdTipoUsuario == 1)

                            <div class="tab-pane fade show active" id="cursos-actuales" role="tabpanel" aria-labelledby="cursos-actuales-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped display order-column hover nowrap" id="table-cursos-actuales"> </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="cursos-finaizados" role="tabpanel" aria-labelledby="cursos-finaizados-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped display order-column hover nowrap" id="table-cursos-finaizados"> </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="buscar-cursos" role="tabpanel" aria-labelledby="buscar-cursos-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped display order-column hover nowrap" id="table-buscar-cursos"> </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="tab-pane fade show active" id="cursos-actuales" role="tabpanel" aria-labelledby="cursos-actuales-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped display order-column hover nowrap" id="table-cursos-actuales"> </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="cursos-finaizados" role="tabpanel" aria-labelledby="cursos-finaizados-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped display order-column hover nowrap" id="table-cursos-finaizados"> </table>
                                        </div>
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
<script type="module" src=" {{asset('assets/js/cursos/cursos.js')}}"></script>

@endpush
