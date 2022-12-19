@extends('layouts.app')

@section('title', 'Inicio')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/inicio/inicio.css')}}">
@endpush


@section('content')

<div class="vh-100" id="fondo">

    <div class="container h-100">

        <div class="row d-flex justify-content-center align-items-center h-100">

            <div class="col col-lg-12">

                <div class="row rounded h-100">
                    <div class="w-100 d-flex align-items-stretch">
       
                                <div class="offcanvas offcanvas-start shadow-lg rounded-end bg-dark" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
                                    <div class="offcanvas-header">
                                        <img style="max-height: 30px;" class="img-fluid" src="https://raw.githubusercontent.com/Brian-GL/CourseRoom/main/src/recursos/imagenes/Course_Room_Brand_Readme.png" />
                                        <span class="offcanvas-title text-white">CourseRoom</span>
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="offcanvas" aria-label="Close">
                                            <i class="fa fa-bars"></i>
                                        </button>
                                    </div>
                                     
                                    <div class="offcanvas-body">
                                        <div class="p-4 pt-2">
                                            <div class="row mb-3">
                                                <div class="col-10 m-auto">
                                                    <!--Imagen del usuario-->
                                                    <img id="imagen-usuario" class="img-fluid rounded-circle mb-3" src="https://colorlib.com/etc/bootstrap-sidebar/sidebar-01/images/logo.jpg" />
                                                    <!--Nombre del usuario-->
                                                    <h5 id="nombre-usuario" class="text-center text-truncated h5 text-white">Susana Alegria</h5>
                                                    <h6 id="tipo-usuario" class="text-center text-white">Estudiante</h6>
                                                </div>
                                            </div>
                                            <ul class="list-unstyled components mb-5">
                                                <li>
                                                    <div class="accordion accordion-flush" id="accordion-cursos">s
                                                        <div class="accordion-item">
                                                          <h2 class="accordion-header" id="headingThree-cursos">
                                                            <button class="accordion-button collapsed bg-transparent"  data-bs-toggle="collapse" data-bs-target="#collapseThree-cursos" aria-expanded="false" aria-controls="collapseThree-cursos">
                                                              Cursos
                                                            </button>
                                                          </h2>
                                                          <div id="collapseThree-cursos" class="accordion-collapse collapse" aria-labelledby="headingThree-cursos" data-bs-parent="#accordion-cursos">
                                                            <div class="accordion-body">
                                                             
                                                            </div>
                                                          </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <a href="#">About</a>
                                                </li>
                                                <li>
                                                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
                                                    <ul class="collapse list-unstyled" id="pageSubmenu">
                                                        <li>
                                                            <a href="#">Page 1</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a href="#">Portfolio</a>
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
                                  </div>
                                <div id="content" class="p-4 p-md-5">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                <div class="container-fluid">
                                    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                                        <i class="fa fa-bars"></i>
                                    </button>
                                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                        <i class="fa fa-bars"></i>
                                    </button>
                                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                        <ul class="nav navbar-nav ml-auto">
                                            <li class="nav-item active">
                                                <a class="nav-link" href="#">Home</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">About</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <h2 class="mb-4">Sidebar #01</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@stop

@push('scripts')
<script type="module" src="{{ asset ('assets/js/inicio/inicio.js')}}"></script>
@endpush
