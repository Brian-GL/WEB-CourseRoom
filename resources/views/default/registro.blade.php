@php
    use Carbon\Carbon;

    $max_date = Carbon::now()->addYears(-14)->format('Y-m-d');
    $min_date = Carbon::now()->addYears(-128)->format('Y-m-d');

@endphp

@extends('layouts.core')

@section('title', 'Registro')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/default/registro.min.css')}}">
@endpush

@section('content')

<div class="col-md-12">
    <div class="container shadow-lg rounded-4">
        <div class="row">
            <div class="col-md-12 px-5 py-2 position-relative" id="register">

                <a class="position-absolute top-0 start-0 px-1 fuenteNormal" href=" {{route('inicio.acceso')}}">
                    <i class="fa-regular fa-circle-left fa-4x pt-3 ps-2"></i>
                </a>

                <div class="row justify-content-center px-3 mb-3">
                    <img id="logo" class="img-fluid" src="{{asset('assets/templates/Course_Room_Brand.png')}}">
                </div>

                <h3 class="my-4 text-center heading display-6">Formulario De Registro</h3>

                <form id="form-registro" method="HEAD">
                    @csrf

                    <div class="row g-3 mt-2">
                        <div class="col">
                            <label for="nombre" class="form-label fuente">Nombre(s)*</label>
                            <input type="text" class="form-control alphabetic fuenteNormal" id="nombre" placeholder="Ingresa tu nombre aquí" required minlength="3" maxlength="50">
                        </div>

                        <div class="col">
                            <label for="paterno" class="form-label fuente">Apellido Paterno*</label>
                            <input type="text" class="form-control alphabetic fuenteNormal" id="paterno" placeholder="Ingresa tu apellido paterno aquí" required minlength="3" maxlength="50">
                        </div>

                        <div class="col">
                            <label for="materno" class="form-label fuente">Apellido Materno</label>
                            <input type="text" class="form-control alphabetic fuenteNormal" id="materno" placeholder="Ingresa tu apellido materno aquí" maxlength="50">
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col">
                            <label for="genero" class="form-label fuente">Género</label>
                            <input type="text" class="form-control alphabetic fuenteNormal" id="genero" placeholder="Ingresa tu género aquí" maxlength="50">
                        </div>

                        <div class="col">
                            <label for="fecha-nacimiento" class="form-label fuente">Fecha de nacimiento</label>
                            <input type="date" class="form-control fuenteNormal" id="fecha-nacimiento" min="{{$min_date}}" max="{{$max_date}}">
                        </div>

                        <div class="col">
                            <label for="localidad" class="form-label fuente">Localidad</label>
                            <input class="form-control alphabetic fuenteNormal" list="localidades" id="localidad" placeholder="Seleccione una localidad">
                            <datalist id="localidades">
                                <option label="" value="Prefiero no decirlo">0</option>
                                @foreach ($localidades as $localidad)
                                    <option label="{{$localidad->estado}}" value="{{$localidad->localidad}}">{{$localidad->idLocalidad}}</option>
                                @endforeach
                            </datalist>
                        </div>

                    </div>

                    <div class="row g-3 mt-2">

                        <div class="col">
                            <label for="correo-electronico" class="form-label fuente">Correo Electrónico*</label>
                            <input type="email" class="form-control replacing fuenteNormal" id="correo-electronico" placeholder="Ingresa tu correo electrónico aquí" required maxlength="150">
                        </div>

                        <div class="col">
                            <label for="contrasena" class="form-label fuente">Contraseña*</label>
                            <input type="password" class="form-control fuenteNormal" id="contrasena" minlength="8" maxlength="30" required placeholder="Ingresa aquí tu contraseña">
                        </div>

                    </div>

                    <div class="row g-3 mt-2">

                        <div class="col">
                            <label for="tipo-usuario" class="form-label fuente">Tipo de usuario*</label>
                            <input class="form-control alphabetic fuenteNormal" list="tipos-usuario" id="tipo-usuario" placeholder="Eres estudiante o profesor?" required>
                            <datalist id="tipos-usuario">
                                @foreach ($tipos_usuario as $tipo_usuario)
                                    <option label="" value="{{$tipo_usuario->tipoUsuario}}">{{tipo_usuario->idTipoUsuario}}</option>
                                @endforeach
                            </datalist>
                        </div>

                        <div class="col">
                            <label for="repetir-contrasena" class="form-label fuente">Repetir Contraseña*</label>
                            <input type="password" class="form-control fuenteNormal" id="repetir-contrasena" minlength="8" maxlength="30" required placeholder="Repite tu contraseña">
                        </div>

                    </div>

                    <div class="row g-3 mt-2">

                        <div class="col">
                            <label for="descripcion" class="form-label fuente">Descripción</label>
                            <textarea class="form-control fuenteNormal" name="descripcion" id="descripcion" placeholder="Ingresa una descripción de tu persona"></textarea>
                        </div>

                        <div class="col">
                            <div class="d-flex justify-content-center mb-4" id="seleccionar-imagen">
                                <img id="imagen-seleccionada" src="https://mdbootstrap.com/img/Photos/Others/placeholder-avatar.jpg" class="rounded img-fluid" alt="Imagen de perfil"/>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="btn btn-primary btn-rounded">
                                    <label class="form-label text-white m-1" for="imagen">Seleccionar imagen</label>
                                    <input type="file" class="form-control d-none" id="imagen" accept="image/png, imagejpg, image/jpeg"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-auto my-3">
                        <div class="col text-center">
                            <button class="btn btn-primary btn-lg" type="submit" id="registrar">Crear cuenta</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>


@stop

@push('scripts')
<script type="module" src="{{ asset ('assets/js/default/registro.js')}}"></script>
@endpush
