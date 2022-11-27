@extends('layouts.app')

@section('title', 'Reproductor de música')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/herramientas/musica.css')}}">
@endpush

@section('content')

<div class="vh-100" id="reproductor-musica">

    <input type="file" id="fileUpload" name="fileUpload" accept="audio/mp3, audio/flac" multiple hidden />

    <div class="container h-100">

        <div class="row h-100">

            <div class="col col-lg-12">

                <div class="row h-100">

                    <div class="col-md-6 m-auto padding" id="caja-cancion">

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <img id="caratula" class="img-fluid text-center" crossorigin="anonymous" />
                                </div>
                            </div>
                        </div>

                        <div class="row py-1">
                            <div class="col-12">
                                <div class="form-group">
                                    <span id="informacion-cancion" class="col-12 text-center pt-1 text-capitalize fuente">Título</span>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center py-1">

                            <div class="col-3">
                                <div class="form-group">
                                    <span class="tiempo" id="progreso">00:00</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <input class="tiempo form-range" type="range" value="0" id="slider" />
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group">
                                    <span class="tiempo text-center" id="duracion">00:00</span>
                                </div>
                            </div>

                        </div>

                        <div class="row py-1">
                            <div class="col-2 text-center">
                                <div class="form-group">
                                    <i class="icon-fa fa fa-folder fa-2x icono-reproductor" title="Abrir archivos" id="open-files"></i>
                                </div>
                            </div>

                            <div class="col-2 text-center">
                                <div class="form-group">
                                    <i class="icon-fa fa fa-step-backward fa-2x icono-reproductor" title="Pista anterior" id="anterior"></i>
                                </div>
                            </div>

                            <div class="col-4 text-center">
                                <div class="form-group">
                                    <i class="icon-fa fa fa-2x fa-play-circle icono-reproductor" title="Reproducir/Pausar" id="play-pause"></i>
                                </div>
                            </div>

                            <div class="col-2 text-center">
                                <div class="form-group">
                                    <i class="icon-fa fa fa-step-forward fa-2x icono-reproductor" title="Pista siguiente" id="siguiente"></i>
                                </div>
                            </div>

                            <div class="col-2 text-center">
                                <div class="form-group">
                                    <a href="https://www.deezer.com" target="_blank" id="deezer" title="Escuchar en deezer">
                                        <img src="{{asset('assets/templates/deezer_22419.png')}}" alt="deezer icon" />
                                    </a>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-1 m-auto padding"></div>

                    <div class="col-md-5 m-auto padding" id="caja-artista">

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <img id="imagen-artista" class="img-fluid text-center" crossorigin="anonymous" />
                                </div>
                            </div>
                        </div>

                        <div class="row py-1">

                            <div class="col-12">
                                <div class="form-group">
                                    <span id="nombre-artista" class="text-center pt-1 text-capitalize fuente">Artista</span>
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

<script type="text/javascript" src=" {{asset('assets/js/color-thief.min.js')}}"></script>
<script type="text/javascript" src=" {{asset('assets/js/herramientas/musica.js')}}"></script>

@endpush
