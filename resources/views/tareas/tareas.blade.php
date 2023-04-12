@extends('layouts.home')

@section('title', 'Tareas')

@push('styles')
<link rel="stylesheet" href="{{ asset ('css/tareas/tareas.css')}}">
@endpush

@section('content')

<input type="hidden" value="{{$IdTipoUsuario}}" id="id-tipo-usuario"/>

<div class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2 class="my-3 display-5 text-start fw-bolder primer-color-letra">Tareas</h2>

                <div class="row">
                    <ul class="nav nav-tabs my-0-5" role="tablist">

                        @if ($IdTipoUsuario == 1)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fuenteNormal primer-color-letra primer-color-fondo" id="mis-tareas-tab" data-bs-toggle="tab" data-bs-target="#mis-tareas" type="button" role="tab" aria-controls="mis-tareas" aria-selected="true">Mis tareas</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="tareas-mes-tab" data-bs-toggle="tab" data-bs-target="#tareas-mes" type="button" role="tab" aria-controls="tareas-mes" aria-selected="false">Tareas del mes</button>
                            </li>
                        @else
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="tareas-calificar-tab" data-bs-toggle="tab" data-bs-target="#tareas-calificar" type="button" role="tab" aria-controls="tareas-calificar" aria-selected="false">Tareas por calificar</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fuenteNormal primer-color-letra primer-color-fondo" id="mis-tareas-creadas-tab" data-bs-toggle="tab" data-bs-target="#mis-tareas-creadas" type="button" role="tab" aria-controls="mis-tareas-creadas" aria-selected="true">Tareas creadas</button>
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="box row pt-1">

                    <div class="tab-content">

                        @if ($IdTipoUsuario == 1)

                            <div class="tab-pane fade show active" id="mis-tareas" role="tabpanel" aria-labelledby="mis-tareas-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped display order-column hover nowrap" id="table-mis-tareas"> </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tareas-mes" role="tabpanel" aria-labelledby="tareas-mes-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="tareas-calendario" class="mt-3 mx-2"></div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="tab-pane fade show active" id="tareas-calificar" role="tabpanel" aria-labelledby="tareas-calificar-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped display order-column hover nowrap" id="table-tareas-calificar"> </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="mis-tareas-creadas" role="tabpanel" aria-labelledby="mis-tareas-creadas-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped display order-column hover nowrap" id="table-mis-tareas-creadas"> </table>
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
<script type="module" src=" {{asset('js/tareas/tareas.js')}}"></script>
@endpush
