@extends('layouts.home')

@section('title', 'Desempeño del usuario')

@push('styles')
<link rel="stylesheet" href="{{ asset ('build/assets/desempeno.51006de4.css')}}">
@endpush

@section('content')

<div class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2 class="my-3 display-5 text-start fw-bolder primer-color-letra">Información de desempeño</h2>

                <div class="row">
                    <ul class="nav nav-tabs my-0-5" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fuenteNormal primer-color-letra primer-color-fondo" id="mi-desempeno-tab" data-bs-toggle="tab" data-bs-target="#mi-desempeno" type="button" role="tab" aria-controls="mi-desempeno" aria-selected="true">Mi desempeño</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="grafica-desempeno-tab" data-bs-toggle="tab" data-bs-target="#grafica-desempeno" type="button" role="tab" aria-controls="grafica-desempeno" aria-selected="false">Gráfica</button>
                        </li>
                    </ul>
                </div>

                <div class="box row pt-1">

                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="mi-desempeno" role="tabpanel" aria-labelledby="mi-desempeno-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-mi-desempeno"> </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="grafica-desempeno" role="tabpanel" aria-labelledby="grafica-desempeno-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <canvas id="canvas-desempeno"></canvas>
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
<script type="module" src=" {{asset('build/assets/desempeno.bed4f270.js')}}"></script>
@endpush
