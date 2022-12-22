<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('assets/css/core.css')}}">
    @stack('styles')

    <!-- Scripts -->
    @vite(['resources/js/app.js'])

</head>
<body>

    <div id="preloader"></div>

    <div class="offcanvas offcanvas-start shadow-lg rounded-end bg-dark" data-bs-scroll="true" tabindex="-1" id="inicio-offcanvas" aria-labelledby="inicio-offcanvas-label">

        <div class="offcanvas-header">
            <img style="max-height: 30px;" class="img-fluid" src="https://raw.githubusercontent.com/Brian-GL/CourseRoom/main/src/recursos/imagenes/Course_Room_Brand_Readme.png" />
            <span class="offcanvas-title text-white">CourseRoom</span>
            <button type="button" class="btn btn-primary" data-bs-dismiss="offcanvas" aria-label="Close" id="cerrar-offcanvas">
                <i class="fa fa-bars"></i>
            </button>
        </div>

        <div class="offcanvas-body">

            <div class="row mb-3">
                <div class="col-10 m-auto">
                    <!--Imagen del usuario-->
                    <img id="imagen-usuario" class="img-fluid rounded-circle mb-4" src="https://colorlib.com/etc/bootstrap-sidebar/sidebar-01/images/logo.jpg" />
                    <!--Nombre del usuario-->
                    <h5 id="nombre-usuario" class="text-center text-truncated h5 text-white">Susana Alegria</h5>
                    <h6 id="tipo-usuario" class="text-center text-white">Estudiante</h6>
                </div>
            </div>
            <ul class="list-unstyled components mb-5">
                <div class="row ustify-content-center">

                    <div class="col-5">
                        <button class="btn btn-dark text-white">
                            <i class="fa-solid fa-chalkboard-user"></i> Cursos
                        </button>
                    </div>

                    <div class="col-5">
                        <button class="btn btn-dark text-white">
                            <i class="fa-solid fa-users-rectangle"></i> Grupos
                        </button>
                    </div>

                </div>

                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
            </ul>
            <div class="footer">
                <p>
                Copyright &copy;
                <script>document.write(new Date().getFullYear());</script>. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <div id="contenido">
        @yield('content')
     </div>

    @stack('scripts')
    <script type="module" src="{{ asset ('assets/js/core.js')}}"></script>
</body>
</html>
