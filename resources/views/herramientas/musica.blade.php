@extends('layouts.home')

@section('title', 'Reproductor de música')

@push('styles')
<link rel="stylesheet" href="{{ asset ('css/herramientas/musica.min.css')}}">
@endpush

@section('content')

<div class="col-md-12">
    <div class="container-fluid mx-3">
        <div class="row g-5 mx-1">

            <div class="col-md-4 m-auto justify-content-center align-items-center">

                <div class="row">
                    <div class="col-12 p-1">
                        <div class="form-group">
                            <img id="caratula" class="img-fluid text-center pt-5" crossorigin="anonymous"/>
                        </div>
                    </div>
                </div>

                <div class="row py-1">
                    <div class="col-12">
                        <div class="form-group text-center">
                            <span id="informacion-cancion" class="pt-1 text-capitalize fuente tercer-color-letra">Título</span>
                        </div>
                        <div class="form-group text-center py-1">
                            <span id="nombre-artista" class="pt-1 text-capitalize fuente tercer-color-letra">Artista</span>
                        </div>
                    </div>
                </div>

                <div class="row text-center py-1">

                    <div class="col-3">
                        <div class="form-group">
                            <span class="tercer-color-letra text-center" id="progreso">00:00</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input class="form-range tercer-color-letra" type="range" value="0" id="slider" />
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <span class="text-center tercer-color-letra" id="duracion">00:00</span>
                        </div>
                    </div>

                </div>

                <div class="row py-1">
                    <div class="col-2 text-center">
                        <div class="form-group">
                            <i class="icon-fa fa fa-folder fa-2x icono-reproductor tercer-color-letra" title="Abrir archivos" id="open-files"></i>
                            <input type="file" id="fileUpload" name="fileUpload" accept="audio/mp3, audio/flac" multiple hidden />
                        </div>
                    </div>

                    <div class="col-2 text-center">
                        <div class="form-group">
                            <i class="icon-fa fa fa-step-backward fa-2x icono-reproductor tercer-color-letra" title="Pista anterior" id="anterior"></i>
                        </div>
                    </div>

                    <div class="col-4 text-center">
                        <div class="form-group">
                            <i class="icon-fa fa fa-2x fa-play-circle icono-reproductor tercer-color-letra" title="Reproducir/Pausar" id="play-pause"></i>
                        </div>
                    </div>

                    <div class="col-2 text-center">
                        <div class="form-group">
                            <i class="icon-fa fa fa-step-forward fa-2x icono-reproductor tercer-color-letra" title="Pista siguiente" id="siguiente"></i>
                        </div>
                    </div>

                    <div class="col-2 text-center">
                        <div class="form-group">
                            <a href="https://www.deezer.com" target="_blank" id="deezer" title="Escuchar en deezer">
                                <img src="{{asset('build/assets/deezer_22419.e214c2c0.png')}}" alt="deezer icon" />
                            </a>
                        </div>
                    </div>

                </div>

            </div>

            <div class="col-md-8" style="filter: brightness(85%);">
                <div class="row h-100 m-auto">
                    <iframe id="video-frame" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@push('scripts')
<script type="module" src=" {{asset('js/herramientas/musica.min.js')}}"></script>
@endpush
