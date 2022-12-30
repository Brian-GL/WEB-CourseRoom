@extends('layouts.home')

@section('title', 'Inicio')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/inicio/inicio.css')}}">
@endpush


@section('content')

<div class="col-md-12">
    <div class="container">
        <div class="row">
            <h2 class="display-5 text-center" id="titulo-inicio">¡Bienvenido! {{$nombre}}</h2>
            <div class="text-center">
                <img id="imagen-meme" class="img-fluid" alt="Meme image">
            </div>
        </div>
    </div>
</div>
@stop

@push('scripts')
<script type="module" src="{{ asset ('assets/js/inicio/inicio.js')}}"></script>
@endpush
