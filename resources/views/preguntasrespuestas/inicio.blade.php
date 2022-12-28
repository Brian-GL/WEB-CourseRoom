@extends('layouts.home')

@section('title', 'Preguntas & Respuestas')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/preguntasrespuestas/inicio.css')}}">
@endpush

@section('content')

<div class="container-fluid h-100 mt-1" id="contenedor">
    <div class="row h-100">

        <div class="col-md-12">

            <h2 class="mt-5 mb-2 display-5 text-start fw-bolder" id="titulo-inicio">Preguntas & Respuestas </h2>

            <div class="table-responsive">
                <table class="table table-striped display order-column hover nowrap" id="table-mis-preguntas"> </table>
            </div>

        </div>

       
    </div>
</div>

@stop


@push('scripts')
<script type="module" src=" {{asset('assets/js/preguntasrespuestas/inicio.js')}}"></script>
@endpush
