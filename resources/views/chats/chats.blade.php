@extends('layouts.home')

@section('title', 'Chats')

@push('styles')
<link rel="stylesheet" href="{{ asset ('build/assets/chats.f35a67cb.css')}}">
@endpush

@section('content')

<div class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2 class="my-3 display-5 text-start fw-bolder primer-color-letra">Chats</h2>

                <div class="row">
                    <ul class="nav nav-tabs my-0-5" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fuenteNormal primer-color-letra primer-color-fondo" id="mis-chats-tab" data-bs-toggle="tab" data-bs-target="#mis-chats" type="button" role="tab" aria-controls="mis-chats" aria-selected="true">Mis chats</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fuenteNormal tercer-color-letra tercer-color-fondo" id="buscar-usuarios-tab" data-bs-toggle="tab" data-bs-target="#buscar-usuarios" type="button" role="tab" aria-controls="buscar-usuarios" aria-selected="false">Chatear con</button>
                        </li>
                    </ul>
                </div>

                <div class="box row pt-1">

                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="mis-chats" role="tabpanel" aria-labelledby="mis-chats-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-mis-chats"> </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="buscar-usuarios" role="tabpanel" aria-labelledby="buscar-usuarios-tab">
                            <div class="row">
                                <div class="col-md-12">
                                   
                                    <div class="row mt-4 mb-2">
                                        <div class="col-md-3">
                                            <input type="text" class="alphabetic form-control tercer-color-letra tercer-color-fondo" name="input-nombre-usuario" id="input-nombre-usuario" placeholder="Nombre(s)" maxlength="50">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="alphabetic form-control tercer-color-letra tercer-color-fondo" name="input-paterno-usuario" id="input-paterno-usuario" placeholder="Apellido paterno" maxlength="50">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="alphabetic form-control tercer-color-letra tercer-color-fondo" name="input-materno-usuario" id="input-materno-usuario" placeholder="Apellido materno" maxlength="50">
                                        </div>
                                        <div class="col-md-3 d-flex justify-content-center">
                                            <button type="submit" class="w-100 btn primer-color-letra primer-color-fondo rounded-pill" id="button-buscar-usuarios">
                                                <i class="fa-solid fa-magnifying-glass"></i>&nbsp;Filtrar
                                            </button>
                                        </div>
                                    </div>

                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-buscar-usuarios"> </table>
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
<script type="module" src=" {{asset('build/assets/chats.22e9a2d5.js')}}"></script>
@endpush
