@php
    use Carbon\Carbon;

    $max_date = Carbon::now()->addYears(-14)->format('Y-m-d');
    $min_date = Carbon::now()->addYears(-128)->format('Y-m-d');

@endphp

@extends('layouts.home')

@section('title', 'Perfil')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/usuarios/perfil.css')}}">
@endpush

@section('content')

<div class="col-md-12">
    <div class="container">
        <div class="row m-auto">

            <div class="col-md-6">
                <div class="form-group">
                    <div class="d-flex justify-content-center mb-4" id="seleccionar-imagen">
                        <img id="imagen-seleccionada" class="img-fluid" src="https://mdbootstrap.com/img/Photos/Others/placeholder-avatar.jpg" class="rounded img-fluid" alt="Imagen de perfil"/>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="btn btn-rounded tercer-color-letra tercer-color-boton">
                            <label class="form-label m-1" for="imagen">Cambiar imagen</label>
                            <input type="file" class="form-control d-none" id="imagen" accept="image/png, imagejpg, image/jpeg"/>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="form-group text-center">
                    <span id="descripcion" class="tercer-color-letra" contenteditable="true">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facilis officia voluptatibus fugiat laudantium ullam illo tempora error ut sunt esse aut at, odio nihil sit ad aperiam placeat debitis facere.</span>
                </div>
            </div>

            <div class="col-md-6 pt-3 tercer-color-letra">

                <form id="form-registro">

                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nombre" class="form-label fw-bolder primer-color-letra">Nombre(s)*</label>
                                <input type="text" class="form-control alphabetic primer-color-letra" id="nombre" placeholder="Ingresa tu nombre aquí" required minlength="3">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="paterno" class="form-label fw-bolder primer-color-letra">Apellido Paterno*</label>
                                <input type="text" class="form-control alphabetic primer-color-letra" id="paterno" placeholder="Ingresa tu apellido paterno aquí" required minlength="3">
                            </div>
                        </div>
                    </div>

                    <div class="row pt-2">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="materno" class="form-label fw-bolder primer-color-letra">Apellido Materno</label>
                                <input type="text" class="form-control alphabetic primer-color-letra" id="materno" placeholder="Ingresa tu apellido materno aquí">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="genero" class="form-label fw-bolder primer-color-letra">Género</label>
                                <input type="text" class="form-control alphabetic primer-color-letra" id="genero" placeholder="Ingresa tu género aquí">
                            </div>
                        </div>

                    </div>

                    <div class="row pt-2">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="fecha-nacimiento" class="form-label fw-bolder primer-color-letra">Fecha de nacimiento</label>
                                <input type="date" class="form-control primer-color-letra" id="fecha-nacimiento" min="{{$min_date}}" max="{{$max_date}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="localidad" class="form-label fw-bolder primer-color-letra">Localidad</label>
                                <input class="form-control alphabetic primer-color-letra" list="localidades" id="localidad" placeholder="Seleccione una localidad">
                                <datalist id="localidades">
                                    <option label="" value="Prefiero no decirlo">0</option>
                                    @foreach ($localidades as $localidad)
                                        <option label="{{$localidad->estado}}" value="{{$localidad->localidad}}">{{$localidad->idLocalidad}}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 tercer-color-letra">

                    <div class="row pt-2">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="correo-electronico" class="form-label fw-bolder tercer-color-letra">Correo Electrónico*</label>
                                <input type="email" class="form-control tercer-color-letra" id="correo-electronico" placeholder="Ingresa tu correo electrónico aquí" required minlength="5">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="contrasena" class="form-label fw-bolder tercer-color-letra">Contraseña*</label>
                                <input type="password" class="form-control tercer-color-letra" id="contrasena" minlength="8" maxlength="30" required>
                            </div>
                        </div>

                    </div>

                    <div class="row pt-2">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="repetir-contrasena" class="form-label fw-bolder tercer-color-letra">Repetir Contraseña*</label>
                                <input type="password" class="form-control tercer-color-letra" id="repetir-contrasena" minlength="8" maxlength="30" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group text-center">
                                <button class="btn tercer-color-letra btn-lg tercer-color-boton" type="submit" id="actualizar">Actualizar información</button>
                            </div>
                        </div>

                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

@stop

@push('scripts')
<script type="module" src="{{ asset ('assets/js/usuarios/perfil.js')}}"></script>
@endpush
