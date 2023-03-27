@extends('layouts.core')

@section('title', 'Recuperación de credenciales')

@push('styles')
<link rel="stylesheet" href="{{ asset ('css/default/recuperacion.min.css')}}">
@endpush

@section('content')

<div class="col-md-12">
    <div class="container shadow-lg rounded-4">
        <div class="row">
            <div class="col-md-12 px-5 py-2 position-relative" id="recovering">

                <a class="position-absolute top-0 start-0 px-1 fuenteNormal" href=" {{route('inicio.acceso')}}">
                    <i class="fa-regular fa-circle-left fa-3x pt-3 ps-2"></i>
                </a>

                <div class="row justify-content-center px-3 mb-3">
                    <img id="logo" class="img-fluid" src="{{asset('build/assets/Course_Room_Brand.9000409b.png')}}">
                </div>

                <h3 class="mb-1 text-center heading display-6">¡Recupera Tu Credenciales!</h3>

                <div class="row my-3 text-center">
                    <span class="text-light fuente">¿Hás Olvidado Tu Contraseña?</span>
                    <span class="text-light fuenteNormal">No te preocupes. Solamente te pediremos que ingreses el correo electrónico que registraste en tu cuenta. Te mandaremos tu contraseña de inmediato.</span>
                </div>

                <form id="form-recuperacion" method="HEAD">
                    @csrf
                    <div class="form-group">
                        <input class="form-control fuenteNormal emailing" type="email" id="correo-electronico" name="correo-electronico" placeholder="Correo electrónico de recuperación" maxlength="150" required>
                    </div>

                    <div class="form-group text-center">
                        <button class="btn-block btn-color fuente px-5" type="submit" id="recuperar-credenciales">Recuperar Credenciales</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@stop

@push('scripts')
<script type="module" src="{{ asset ( 'js/default/recuperacion.min.js')}}"></script>
@endpush
