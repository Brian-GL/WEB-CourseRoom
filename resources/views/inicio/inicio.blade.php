@extends('layouts.home')

@section('title', 'Inicio')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/inicio/inicio.css')}}">
@endpush


@section('content')

<div class="vh-100" id="fondo-inicio">
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="m-auto">
                <h2 class="mt-5 display-5 text-center" id="titulo-inicio">¡Bienvenido! </h2>
                <div class="text-center">
                    <img id="imagen-meme" class="img-fluid" alt="Meme image">
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@push('scripts')
<script type="module" src="{{ asset ('assets/js/inicio/inicio.js')}}"></script>
@endpush
