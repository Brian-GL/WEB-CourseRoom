@extends('layouts.core')

@section('title', 'Acceso')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/default/acceso.css')}}">
@endpush

@section('content')

<div class="col-md-12">

    <div class="container shadow-lg rounded-4">
        <div class="row">
            <div class="col-md-7 p-5" id="login">
                <div class="row justify-content-center px-3 mb-3">
                    <img id="logo" class="img-fluid" src="{{ asset("assets/templates/Course_Room_Brand.png")}}">
                </div>

                <form id="form-acceso" method="HEAD">
                    @csrf
                    <div class="form-group py-1">
                        <label class="form-control-label text-black fuenteNormal" for="correo-electronico">Correo Electrónico</label>
                        <input class="form-control email fuenteNormal replacing" type="email" id="correo-electronico" name="correo-electronico" placeholder="Correo electrónico" maxlength="150" required autocomplete="username">
                    </div>

                    <div class="form-group py-1">
                        <label class="form-control-label text-black fuenteNormal" for="contrasena">Contraseña</label>
                        <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña" class="form-control fuenteNormal" required minlength="8" maxlength="30" autocomplete="current-password">
                    </div>

                    <div class="row justify-content-center py-2 px-2">
                        <button class="btn-block btn-color fuente my-2" type="submit" id="iniciar-sesion">Iniciar Sesión</button>
                    </div>
                </form>

                <div class="row justify-content-center py-2 text-center">
                    <span class="text-light fuenteNormal">
                        ¿Hás Olvidado Tu Contraseña?
                        <a href="{{route('inicio.recuperacion')}}"><strong class="text-light fuente">Recuperar Credenciales</strong></a>
                    </span>
                </div>

                <div class="row justify-content-center py-1 text-center">
                    <span class="text-light fuenteNormal">
                        ¿No Tienes Cuenta?
                        <a href="{{route('inicio.registro')}}"><strong class="text-light fuente">Crear Una Nueva Cuenta</strong></a>
                    </span>
                </div>
            </div>
            <div class="col-md-5 h-auto" id="presentation-image" title="Powered By Lorem Picsum"></div>
        </div>

    </div>


</div>

@stop


@push('scripts')
<script type="module" src="{{ asset ('assets/js/default/acceso.js')}}"></script>
@endpush
