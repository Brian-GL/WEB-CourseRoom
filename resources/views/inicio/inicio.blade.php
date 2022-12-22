@extends('layouts.home')

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
       
                               

                                <div id="content" class="p-4 p-md-5">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                <div class="container-fluid">
                                    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#inicio-offcanvas" aria-controls="inicio-offcanvas-label">
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
