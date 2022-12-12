@extends('layouts.app')

@section('title', 'Recuperación de credenciales')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/inicio/recuperacion.css')}}">
@endpush


@section('content')

<div class="vh-100" id="fondo">

    <div class="container h-100">

        <div class="row d-flex justify-content-center align-items-center h-100">

            <div class="col col-lg-12">

                <div class="row rounded h-100">

                    <div class="container px-4 py-5 mx-auto">
                        <div class="card rounded-3 card0" id="contenedor">
                            <div class="d-flex flex-lg-row flex-column-reverse">
                                <div class="card card1">
                                    <div class="row justify-content-center my-auto">
                                        <div class="col-md-11 col-11 my-3">

                                            <div class="row justify-content-center px-3 mb-3">
                                                <img id="logo" class="img-fluid" src="{{asset('assets/templates/Course_Room_Brand.png')}}">
                                            </div>

                                            <h3 class="mb-1 text-center heading display-6">¡Recupera Tu Credenciales!</h3>

                                            <div class="row justify-content-center py-2 text-center">
                                                <span class="text-muted">
                                                    <span class="text-muted fuente">¿Hás Olvidado Tu Contraseña?</span>
                                                    <span class="text-muted fuenteNormal">No te preocupes. Solamente te pediremos que ingreses el correo electrónico que registraste en tu cuenta. Te mandaremos tu contraseña de inmediato.</span>
                                                </span>
                                            </div>

                                            <div class="form-group pt-4 pb-3">
                                                <label class="form-control-label text-black fuenteNormal">Correo Electrónico De Recuperación</label>
                                                <input class="form-control email fuenteNormal" type="email" id="CorreoElectronico" name="CorreoElectronico" placeholder="Correo electrónico de recuperación" maxlength="150" required>
                                            </div>


                                            <div class="row justify-content-center py-1 px-2">
                                                <button class="btn-block btn-color fuente" type="submit" id="recuperarCredenciales">Recuperar Credenciales</button>
                                            </div>

                                            <a class="position-absolute top-0 start-0 px-1 fuenteNormal" href=" {{url('/')}}">
                                                <i class="fa-regular fa-circle-left fa-4x pt-3 ps-2"></i>
                                            </a>

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

</div>

@stop

@push('scripts')
<script type="module" src="{{ asset ('assets/js/inicio/recuperacion.js')}}"></script>
@endpush
