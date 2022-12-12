@extends('layouts.app')

@section('title', 'Acceso')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/inicio/login.css')}}">
@endpush

@section('content')

<div class="vh-100" id="login">

    <div class="container h-100">

        <div class="row d-flex justify-content-center align-items-center h-100">

            <div class="col col-lg-12">

                <div class="row rounded h-100">

                    <div class="container px-4 py-5 mx-auto">
                        <div class="card rounded-3" id="contenedor">
                            <div class="d-flex flex-lg-row flex-column-reverse">
                                <div class="card card1">
                                    <div class="row justify-content-center my-auto">
                                        <div class="col-md-11 col-11 my-3">
                                            <div class="row justify-content-center px-3 mb-3">
                                                <img id="logo" class="img-fluid" src="{{ asset("assets/templates/Course_Room_Brand.png")}}">
                                            </div>
                                            <h3 class="mb-1 text-center heading display-6">Bienvenido A CourseRoom</h3>


                                            <div class="form-group py-1">
                                                <label class="form-control-label text-black fuenteNormal">Correo Electrónico</label>
                                                <input class="form-control email fuenteNormal" type="email" id="CorreoElectronico" name="CorreoElectronico" placeholder="Correo electrónico" maxlength="150" required>
                                            </div>

                                            <div class="form-group py-1">
                                                <label class="form-control-label text-black fuenteNormal">Contraseña</label>
                                                <input type="password" id="Password" name="Password" placeholder="Contraseña" class="form-control fuenteNormal" required>
                                            </div>

                                            <div class="row justify-content-center py-2 px-2">
                                                <button class="btn-block btn-color fuente my-2" type="submit" id="iniciarSesion">Iniciar Sesión</button>
                                            </div>

                                            <div class="row justify-content-center py-2 text-center">
                                                <span class="text-muted fuenteNormal">
                                                    ¿Hás Olvidado Tu Contraseña?
                                                    <a href="{{url('/recuperacion')}}"><strong class="text-muted fuente">Recuperar Credenciales</strong></a>
                                                </span>
                                            </div>

                                            <div class="row justify-content-center py-1 text-center">
                                                <span class="text-muted fuenteNormal">
                                                    ¿No Tienes Cuenta?
                                                    <a href=""><strong class="text-muted fuente">Crear Una Nueva Cuenta</strong></a>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card card2">
                                    <span class="text-capitalize text-center fuente bg-black text-white w-50 position-absolute bottom-0 end-50 opacity-75"> Powered By <a href="https://picsum.photos/" target="_blank" class="text-white stretched-link">Lorem Picsum</a></span>
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
<script type="module" src="{{ asset ('assets/js/inicio/login.js')}}"></script>
@endpush
