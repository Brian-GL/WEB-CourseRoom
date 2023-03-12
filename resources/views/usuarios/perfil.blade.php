@php
    use Carbon\Carbon;
    $max_date = Carbon::now()->addYears(-14)->format('Y-m-d');
    $min_date = Carbon::now()->addYears(-128)->format('Y-m-d');
    $fechaCarbon = new Carbon($DatosUsuario->fechaNacimiento);
    $fecha = $fechaCarbon->format('Y-m-d');

    $nombreLocalidad = '';

    if(!is_null($DatosUsuario)){
        foreach ($localidades as $localidad) {
            if($localidad->idLocalidad == $DatosUsuario->idLocalidad){
                $nombreLocalidad = $localidad->localidad;
                break;
            }
        }
    }

    $imagenAnterior = '';
    if(!is_null($DatosCuenta)){
        $imagenAnterior = $DatosCuenta->imagen;
    }

@endphp

@extends('layouts.home')

@section('title', 'Perfil')

@push('styles')
<link rel="stylesheet" href="{{ asset ('build/assets/perfil.min.f58ea1e3.css')}}">
@endpush

@section('content')

<input type="hidden" value="{{$imagenAnterior}}" id="imagen-anterior">

<div class="col-md-12">
    <div class="container">
        <div class="row mt-4">

            <div class="col-md-6">
                <div class="form-group">
                    <div class="d-flex justify-content-center mb-4" id="seleccionar-imagen">
                        @if(!is_null($DatosCuenta) && !is_null($DatosCuenta->imagen))
                        <img id="imagen-seleccionada" class="img-fluid shadow-lg" src="{{ asset('usuarios/'.$DatosCuenta->imagen)}}" class="rounded img-fluid" alt="Imagen de perfil"/>
                        @else
                        <img id="imagen-seleccionada" class="img-fluid shadow-lg" src="https://storage.needpix.com/thumbs/blank-profile-picture-973460_1280.png" class="rounded img-fluid" alt="Imagen de perfil"/>
                        @endif
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="btn btn-rounded tercer-color-letra tercer-color-fondo">
                            <label class="form-label m-1 fuenteNormal" for="imagen">Cambiar imagen</label>
                            <input type="file" class="form-control d-none fuenteNormal" id="imagen" accept="image/png, imagejpg, image/jpeg"/>
                        </div>
                    </div>
                </div>

                <div class="mt-3 form-group text-center tercer-color-letra">
                    @if(!is_null($DatosUsuario))
                        <span title="Tu descripción" id="descripcion" class="fuenteNormal" contenteditable="true">{{$DatosUsuario->descripcion}}</span>
                    @else
                        <span title="Tu descripción" id="descripcion" class="fuenteNormal" contenteditable="true">Ingresa aquí tu descripción</span>
                    @endif
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
            </div>

            <div class="col-md-6 pt-3">

                <form id="form-actualizar" method="HEAD">

                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nombre" class="form-label fuente primer-color-letra">Nombre(s)*</label>
                                @if(!is_null($DatosUsuario))
                                    <input type="text" class="form-control fuenteNormal alphabetic segundo-color-letra segundo-color-fondo" id="nombre" placeholder="Ingresa tu nombre aquí" required minlength="3" value="{{$DatosUsuario->nombre}}">
                                @else
                                    <input type="text" class="form-control fuenteNormal alphabetic segundo-color-letra segundo-color-fondo" id="nombre" placeholder="Ingresa tu nombre aquí" required minlength="3">
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="paterno" class="form-label fuente primer-color-letra">Apellido Paterno*</label>
                                @if(!is_null($DatosUsuario))
                                    <input type="text" class="form-control fuenteNormal alphabetic segundo-color-letra segundo-color-fondo" id="paterno" placeholder="Ingresa tu apellido paterno aquí" required minlength="3" value="{{$DatosUsuario->paterno}}">
                                @else
                                    <input type="text" class="form-control fuenteNormal alphabetic segundo-color-letra segundo-color-fondo" id="paterno" placeholder="Ingresa tu apellido paterno aquí" required minlength="3">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row pt-2">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="materno" class="form-label fuente primer-color-letra">Apellido Materno</label>
                                @if(!is_null($DatosUsuario))
                                    <input type="text" class="form-control alphabetic fuenteNormal segundo-color-letra segundo-color-fondo" id="materno" placeholder="Ingresa tu apellido materno aquí" value="{{$DatosUsuario->materno}}">
                                @else
                                    <input type="text" class="form-control alphabetic fuenteNormal segundo-color-letra segundo-color-fondo" id="materno" placeholder="Ingresa tu apellido materno aquí">
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="genero" class="form-label fuente primer-color-letra">Género</label>
                                @if(!is_null($DatosUsuario))
                                    <input type="text" class="form-control alphabetic tercer-color-letra tercer-color-fondo fuenteNormal" id="genero" placeholder="Ingresa tu género aquí" value="{{$DatosUsuario->genero}}">
                                @else
                                <input type="text" class="form-control alphabetic tercer-color-letra tercer-color-fondo fuenteNormal" id="genero" placeholder="Ingresa tu género aquí">
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="row pt-2">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="fecha-nacimiento" class="form-label fuente segundo-color-letra">Fecha de nacimiento</label>
                                @if(!is_null($DatosUsuario))
                                    <input type="date" class="form-control tercer-color-letra tercer-color-fondo fuenteNormal" id="fecha-nacimiento" min="{{$min_date}}" max="{{$max_date}}" value="{{$fecha}}" required>
                                @else
                                    <input type="date" class="form-control tercer-color-letra tercer-color-fondo fuenteNormal" id="fecha-nacimiento" min="{{$min_date}}" max="{{$max_date}}" required>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="localidad" class="form-label fuente segundo-color-letra">Localidad</label>
                                <input class="form-control alphabetic tercer-color-letra tercer-color-fondo fuenteNormal" list="localidades" id="localidad" placeholder="Seleccione una localidad" value="{{$nombreLocalidad}}">
                                <datalist id="localidades">
                                    @foreach ($localidades as $localidad)
                                        <option label="{{$localidad->estado}}" value="{{$localidad->localidad}}">{{$localidad->idLocalidad}}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                    </div>

                    <div class="row my-2">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="correo-electronico" class="form-label fuente segundo-color-letra">Correo Electrónico*</label>
                                @if(!is_null($DatosCuenta))
                                    <input type="email" class="form-control primer-color-letra primer-color-fondo fuenteNormal" id="correo-electronico" placeholder="Ingresa tu correo electrónico aquí" required minlength="5" value="{{$DatosCuenta->correoElectronico}}">
                                @else
                                    <input type="email" class="form-control primer-color-letra primer-color-fondo fuenteNormal" id="correo-electronico" placeholder="Ingresa tu correo electrónico aquí" required minlength="5">
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="contrasena" class="form-label fuente segundo-color-letra">Contraseña*</label>
                                @if(!is_null($DatosCuenta))
                                    <input type="password" class="form-control primer-color-letra primer-color-fondo fuenteNormal" id="contrasena" minlength="8" maxlength="30" required placeholder="Ingresa aquí tu contraseña" value="{{base64_decode($DatosCuenta->contrasena)}}">
                                @else
                                    <input type="password" class="form-control primer-color-letra primer-color-fondo fuenteNormal" id="contrasena" minlength="8" maxlength="30" required placeholder="Ingresa aquí tu contraseña">
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="row my-2">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="repetir-contrasena" class="form-label fuente tercer-color-letra">Repetir Contraseña*</label>
                                @if(!is_null($DatosCuenta))
                                    <input type="password" class="form-control primer-color-letra primer-color-fondo fuenteNormal" id="repetir-contrasena" minlength="8" maxlength="30" required placeholder="Repite tu contraseña" value="{{base64_decode($DatosCuenta->contrasena)}}">
                                @else
                                    <input type="password" class="form-control primer-color-letra primer-color-fondo fuenteNormal" id="repetir-contrasena" minlength="8" maxlength="30" required placeholder="Repite tu contraseña">
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-check text-center mt-3">
                                <div class="form-check form-switch">
                                    @if(!is_null($DatosCuenta) && $DatosCuenta->chatsConmigo)
                                        <input class="form-check-input fuenteNormal segundo-color-letra segundo-color-fondo" type="checkbox" role="switch" id="chats-conmigo" checked>    
                                    @else
                                        <input class="form-check-input fuenteNormal segundo-color-letra segundo-color-fondo" type="checkbox" role="switch" id="chats-conmigo">
                                    @endif
                                    <label class="form-check-label fuente tercer-color-letra" for="chats-conmigo">¿Permitir Chats Conmigo?</label>
                                </div>
                                <div class="form-check form-switch">
                                    @if(!is_null($DatosCuenta) && $DatosCuenta->chatsConmigo)
                                        <input class="form-check-input fuenteNormal segundo-color-letra segundo-color-fondo" type="checkbox" role="switch" id="avisos-activo" checked>
                                    @else
                                    <input class="form-check-input fuenteNormal segundo-color-letra segundo-color-fondo" type="checkbox" role="switch" id="avisos-activo">
                                    @endif
                                    <label class="form-check-label fuente tercer-color-letra" for="avisos-activo">¿Mostrar Avisos?</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row mt-5 d-flex align-items-center justify-content-center">
                        <div class="col-sm-6">
                            <div class="form-group text-center">
                                <button class="btn primer-color-letra btn-lg primer-color-fondo" type="submit" id="actualizar">Actualizar información</button>
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
<script type="module" src="{{ asset ('build/assets/perfil.1ab441a7.js')}}"></script>
@endpush
