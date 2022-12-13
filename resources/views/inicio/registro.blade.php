@php
    use Carbon\Carbon;

    $max_date = Carbon::now()->addYears(-14)->format('Y-m-d');
    $min_date = Carbon::now()->addYears(-128)->format('Y-m-d');

@endphp

@extends('layouts.app')

@section('title', 'Registro')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/inicio/registro.css')}}">
@endpush

@section('content')

<div class="vh-100" id="registro">

    <div class="container h-100">

        <div class="row d-flex justify-content-center align-items-center h-100">

            <div class="col col-lg-12">

                <div class="row rounded h-100">

                    <div class="container px-4 py-5 mx-auto">
                        <div class="card rounded-3 card0" id="contenedor">
                            <div class="d-flex flex-lg-row flex-column-reverse">
                                <div class="card card2">
                                    <span class="text-capitalize text-center fuente bg-black text-white w-50 position-absolute bottom-0 end-50 opacity-75"> Powered By <a href="https://www.unsplash.com" target="_blank" class="text-white stretched-link">Unsplash</a></span>
                                </div>
                                <div class="card card1">
                                    <div class="py-3 text-center">
                                        <img id="logo" class="img-fluid" src="{{asset('assets/templates/Course_Room_Brand.png')}}">
                                        <h2 class="display-4 pt-2">Formulario de registro</h2>
                                        <p class="lead py-3">Completa los campos para poder generar tu cuenta y seas capaz de aprender/enseñar de forma divertida y eficaz</p>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">

                                            <form id="form-registro">

                                                <div class="row">

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="nombre" class="form-label">Nombre(s)*</label>
                                                            <input type="text" class="form-control" id="nombre" placeholder="Ingresa tu nombre aquí" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="paterno" class="form-label">Apellido Paterno*</label>
                                                            <input type="text" class="form-control" id="paterno" placeholder="Ingresa tu apellido paterno aquí" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="materno" class="form-label">Apellido Materno</label>
                                                            <input type="text" class="form-control" id="materno" placeholder="Ingresa tu apellido materno aquí">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row pt-2">

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="genero" class="form-label">Género</label>
                                                            <input type="text" class="form-control" id="genero" placeholder="Ingresa tu género aquí">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="fecha-nacimiento" class="form-label">Fecha de nacimiento</label>
                                                            <input type="date" class="form-control" id="fecha-nacimiento" min="{{$min_date}}" max="{{$max_date}}">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="localidad" class="form-label">Localidad</label>
                                                            <input class="form-control" list="localidades" id="localidad" placeholder="Seleccione una localidad">
                                                            <datalist id="localidades">
                                                                <option value="Privado">Prefiero no decirlo</option>
                                                            </datalist>
                                                        </div>
                                                    </div>

                                                </div>

                                                <hr class="my-4">

                                                <div class="row pt-2">

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="correo-electronico" class="form-label">Correo Electrónico*</label>
                                                            <input type="email" class="form-control" id="correo-electronico" placeholder="Ingresa tu correo electrónico aquí" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="tipo-usuario" class="form-label">Tipo de usuario*</label>
                                                            <input class="form-control" list="tipos-usuario" id="tipo-usuario" placeholder="Eres estudiante o profesor?">
                                                            <datalist id="tipos-usuario">
                                                                <option value="Estudiante">Soy un estudiante</option>
                                                                <option value="Profesor">Soy un profesor</option>
                                                            </datalist>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row pt-2">

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="contrasena" class="form-label">Contraseña*</label>
                                                            <i class="fa-solid fa-eye"></i>
                                                            <input type="password" class="form-control" id="contrasena" minlength="8" maxlength="30" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="repetir-contrasena" class="form-label">Repetir Contraseña*</label>
                                                            <i class="fa-regular fa-eye-slash"></i>
                                                            <input type="password" class="form-control" id="repetir-contrasena" minlength="8" maxlength="30" required>
                                                        </div>
                                                    </div>

                                                </div>

                                                <hr class="my-4">

                                                <div class="row pt-2">

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="descripcion" class="form-label">Descripción</label>
                                                            <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="14"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="seleccionar-imagen" class="form-label">Imagen</label>
                                                            <div class="d-flex justify-content-center mb-4" id="seleccionar-imagen">
                                                                <img src="https://mdbootstrap.com/img/Photos/Others/placeholder-avatar.jpg" class="rounded-circle img-fluid" alt="Imagen de perfil" style="width: 250px;" />
                                                            </div>
                                                            <div class="d-flex justify-content-center">
                                                                <div class="btn btn-primary btn-rounded">
                                                                    <label class="form-label text-white m-1" for="customFile2">Seleccionar archivo</label>
                                                                    <input type="file" class="form-control d-none" id="seleccionar-imagen" accept="image/png, imagejpg, image/jpeg"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <hr class="my-4">

                                                <div class="row py-3">
                                                    <div class="col-10 mx-auto">
                                                        <button class="w-100 btn btn-primary btn-lg" type="submit" id="registrar">Crear cuenta</button>
                                                    </div>
                                                </div>

                                            </form>
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
<script type="module" src="{{ asset ('assets/js/inicio/registro.js')}}"></script>
@endpush
