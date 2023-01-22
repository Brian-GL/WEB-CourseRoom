@extends('layouts.home')

@section('title', 'Inicio')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/inicio/inicio.min.css')}}">
@endpush


@section('content')

<div class="col-md-12">
    <div class="container">
        <div class="row">
            @if(!is_null($DatosUsuario))
                <h2 class="display-5 text-center primer-color-letra" id="titulo-inicio">¡Bienvenid@! {{$DatosUsuario->nombre}}</h2>
            @else
                <h2 class="display-5 text-center primer-color-letra" id="titulo-inicio">¡Bienvenid@! </h2>
            @endif
            <div class="text-center">
                <img id="imagen-meme" class="img-fluid shadow-lg" alt="Meme image">
            </div>
        </div>
    </div>
</div>
@stop

@push('scripts')
<script type="module" src="{{ asset ('assets/js/inicio/inicio.min.js')}}"></script>
@endpush
