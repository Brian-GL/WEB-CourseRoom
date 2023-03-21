@extends('layouts.home')

@section('title', 'Preguntas & Respuestas')

@push('styles')
<link rel="stylesheet" href="{{ asset ('css/preguntas/preguntas.min.css')}}">
@endpush

@section('content')

<div class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2 class="my-3 display-5 text-start fw-bolder primer-color-letra">Preguntas & Respuestas </h2>

                <div class="row">
                    <div class="col-md-10">
                        <ul class="nav nav-tabs my-0-5" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fuenteNormal primer-color-letra primer-color-fondo" id="mis-preguntas-tab" data-bs-toggle="tab" data-bs-target="#mis-preguntas" type="button" role="tab" aria-controls="mis-preguntas" aria-selected="true">Mis preguntas</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="buscar-preguntas-tab" data-bs-toggle="tab" data-bs-target="#buscar-preguntas" type="button" role="tab" aria-controls="buscar-preguntas" aria-selected="false">Buscar preguntas</button>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-2 d-flex justify-content-end">
                        <button class="btn fuenteNormal my-1 text-wrap border border-2 tercer-color-letra tercer-color-fondo" type="button" id="agregar-pregunta" >
                            <i class="fa-solid fa-plus"></i> Agregar Pregunta
                        </button>
                    </div>
                </div>

                <div class="box row pt-1">

                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="mis-preguntas" role="tabpanel" aria-labelledby="mis-preguntas-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-mis-preguntas"> </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="buscar-preguntas" role="tabpanel" aria-labelledby="buscar-preguntas-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="form-buscar-preguntas" method="HEAD" class="mt-4 mb-2">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <input type="text" class="form-control primer-color-letra primer-color-fondo" name="input-buscar-preguntas" id="input-buscar-preguntas" placeholder="Buscar preguntas" maxlength="150" required>
                                            </div>
                                            <div class="col-md-2 d-flex justify-content-center">
                                                <button type="submit" class="w-100 btn tercer-color-letra tercer-color-fondo" id="buscar-preguntas">
                                                    <i class="fa-solid fa-magnifying-glass"></i>&nbsp;Filtrar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-buscar-preguntas"> </table>
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
<script type="module" src=" {{asset('js/preguntas/preguntas.js')}}"></script>
@endpush
