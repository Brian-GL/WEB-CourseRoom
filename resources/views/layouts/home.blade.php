@php
    use Carbon\Carbon;
    $year = Carbon::now()->format('Y');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="min-vh-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" >

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('build/assets/home.4f4cda2b.css')}}">
    @stack('styles')

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
    @vite(['resources/js/app.js'])

</head>
<body class="min-vh-100" id="fondo">

    <input type="hidden" id="happy-owl" value="{{ asset ('build/assets/HappyOwl.747ca1f1.png')}}">
    <input type="hidden" id="indifferent-owl" value="{{ asset ('build/assets/IndiferentOwl.f926f13c.png')}}">
    <input type="hidden" id="sad-owl" value="{{ asset ('build/assets/SadOwl.1c6ceeff.png')}}">

    <div id="preloader"></div>

    <div id="inicio-offcanvas" class="offcanvas offcanvas-start shadow-lg rounded-end" data-bs-scroll="true" tabindex="-1" aria-labelledby="inicio-offcanvas-label">

        <div class="offcanvas-header">
            <img id="offcanvas-logo" class="img-fluid" src="https://raw.githubusercontent.com/Brian-GL/CourseRoom/main/src/recursos/imagenes/Course_Room_Brand_Readme.png" />
            <span class="offcanvas-title primer-color-letra">CourseRoom</span>
            <button type="button" class="btn segundo-color-letra segundo-color-fondo" data-bs-dismiss="offcanvas" aria-label="Close" id="cerrar-offcanvas">
                <i class="fa fa-bars fa-xl"></i>
            </button>
        </div>

        <div class="offcanvas-body">

            <div class="row mb-3">
                <div class="col centrado">
                    <!--Imagen del usuario-->
                    @if(!is_null($DatosCuenta) && !is_null($DatosCuenta->imagen))
                        <img id="imagen-usuario" class="img-fluid rounded-circle mb-4 shadow-lg" alt="Imagen del usuario" src="{{ asset('usuarios/'.$DatosCuenta->imagen)}}" crossorigin="anonymous"/>
                    @else
                        <img id="imagen-usuario" class="img-fluid rounded-circle mb-4 shadow-lg" alt="Imagen del usuario" crossorigin="anonymous"/>
                    @endif
                    <!--Nombre del usuario-->
                    @if(!is_null($DatosUsuario))
                        <h5 id="nombre-usuario" class="text-center text-truncated h5 segundo-color-letra">{{$DatosUsuario->nombre.' '.$DatosUsuario->paterno.' '.$DatosUsuario->materno}}</h5>
                        <h6 id="tipo-usuario" class="text-center segundo-color-letra">{{$DatosUsuario->tipoUsuario}}</h6>
                    @else
                        <h5 id="nombre-usuario" class="text-center text-truncated h5 segundo-color-letra">Usuario desconocido</h5>
                        <h6 id="tipo-usuario" class="text-center segundo-color-letra">Tipo de usuario desconocido</h6>
                    @endif

                </div>
            </div>
            <div class="components my-2">
                <div class="row justify-content-center">

                    <div class="col-5">
                        <a type="button" class="btn btn-lg segundo-color-letra" href="{{route('cursos.inicio')}}" title="Ir a mis cursos">
                            <i class="fa-solid fa-chalkboard-user"></i> Cursos
                        </a>
                    </div>

                    <div class="col-5">
                        @if ($IdTipoUsuario == 1)
                            <a type="button" class="btn btn-lg segundo-color-letra" href="{{route('grupos.inicio')}}" title="Ir a mis grupos">
                                <i class="fa-solid fa-users-rectangle"></i> Grupos
                            </a>
                        @endif
                    </div>

                </div>

                <div class="row justify-content-center">

                    <div class="col-5">
                        <a type="button" class="btn btn-lg segundo-color-letra" href="{{route('tareas.inicio')}}" title="Ir a mis tareas">
                            <i class="fa-solid fa-house-laptop"></i> Tareas
                        </a>
                    </div>

                    <div class="col-5">
                        <a type="button" class="btn btn-lg segundo-color-letra" href="{{route('chats.inicio')}}" title="Ir a mis chats">
                            <i class="fa-solid fa-comments"></i> Chats
                        </a>
                    </div>

                </div>

                <div class="row justify-content-center">

                    <div class="col-5">
                        <a type="button" class="btn btn-lg tercer-color-letra" href="{{route('herramientas.musica')}}" title="Ir a mi reproductor de música">
                            <i class="fa-solid fa-compact-disc"></i> Música
                        </a>
                    </div>

                    <div class="col-5">
                        <a type="button" class="btn btn-lg tercer-color-letra" href="{{route('herramientas.matematicas')}}" title="Ir al resolvedor matemático">
                            <i class="fa-solid fa-square-root-variable"></i> Maths
                        </a>
                    </div>

                </div>

                <div class="row justify-content-center">

                    <div class="col-5">
                        <a type="button" class="btn btn-lg tercer-color-letra" href="{{route('preguntasrespuestas.inicio')}}" title="Buscar/realizar preguntas">
                            <i class="fa-solid fa-person-circle-question"></i> Q&A
                        </a>
                    </div>

                    <div class="col-5">
                        <a type="button" class="btn btn-lg tercer-color-letra" href="{{route('inicio.acerca')}}" title="Acerca de CourseRoom">
                            <i class="fa-solid fa-circle-info"></i> Acerca
                        </a>
                    </div>

                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 text-center d-flex align-items-center justify-content-center">
                    <span class="lead tercer-color-letra">
                        CourseRoom &copy; {{$year}}.
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid min-vh-100">
        <nav class="navbar shadow mt-2 mb-3 mx-3 rounded navbar-expand-md segundo-color-fondo">
            <div class="container-fluid">
                <div class="row d-flex w-100">
                    <div class="col justify-content-start">
                        <button class="btn primer-color-letra primer-color-fondo" type="button" data-bs-toggle="offcanvas" data-bs-target="#inicio-offcanvas" aria-controls="inicio-offcanvas-label">
                            <i class="fa fa-bars fa-xl"></i>
                        </button>
                    </div>
                    <div class="col justify-content-center text-center">
                        <span class="fuenteMediana segundo-color-letra" id="reloj"></span>
                    </div>
                    <div class="col d-flex justify-content-md-end">
                        <div class="dropdown dropstart justify-content-md-end">
                            <button class="btn dropdown-toggle primer-color-letra primer-color-fondo" type="button" id="boton-perfil" data-bs-toggle="dropdown" aria-expanded="false">
                                <!-- Nombre usuario -->
                                @if(!is_null($DatosUsuario))
                                    {{$DatosUsuario->nombre.' '.$DatosUsuario->paterno}}
                                @else
                                    Más
                                @endif
                            </button>
                            <ul class="dropdown-menu primer-color-letra primer-color-fondo" aria-labelledby="boton-perfil">
                                <li><a id="boton-notificaciones" class=" fuenteNormal dropdown-item primer-color-letra" type="button" title="Notificaciones" href="{{route('avisos.inicio')}}"><i class="fa-solid fa-envelope-open" id="icono-notificaciones"></i>&nbsp;Notificaciones</a></li>
                                <li><a class="dropdown-item primer-color-letra fuenteNormal" href="{{route('usuarios.perfil')}}"><i class="fa-solid fa-user"></i>&nbsp;&nbsp;Perfil</a></li>
                                <li><a class="dropdown-item primer-color-letra fuenteNormal" href="{{route('usuarios.sesiones')}}"><i class="fa-solid fa-desktop"></i>&nbsp;&nbsp;Sesiones</a></li>
                                @if ($IdTipoUsuario == 1)
                                    <li><a class="dropdown-item primer-color-letra fuenteNormal" href="{{route('usuarios.midesempeno')}}"><i class="fa-solid fa-graduation-cap"></i>&nbsp;&nbsp;Desempeño</a></li>
                                @endif
                                <li><hr class="dropdown-divider primer-color-letra"></li>
                                <li><a class="dropdown-item primer-color-letra fuenteNormal" id="cerrar-sesion"><i class="fa-solid fa-person-walking-arrow-right"></i>&nbsp;&nbsp;Cerrar sesión</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
              
                
                
            </div>
        </nav>
        <div class="row">
            @yield('content')
        </div>
    </div>

    <script type="module" src="{{ asset('build/assets/home.91311917.js')}}"></script>
    @stack('scripts')

</body>
</html>
