@extends('layouts.home')

@section('title', 'Inicio')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/inicio/inicio.css')}}">
@endpush


@section('content')

<div class="p-4" id="fondo-inicio">
    <h2 class="mb-2 display-5 text-center text-white">¡Bienvenido! </h2>
    <div class="text-center">
        <img id="imagen-meme" class="img-fluid" alt="Meme image">
    </div>
</div>

@stop

@push('scripts')
<script type="module" src="{{ asset ('assets/js/inicio/inicio.js')}}"></script>
@endpush
