@extends('layouts.home')

@section('title', 'Reproductor de música')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/herramientas/musica.css')}}">
@endpush

@section('content')

<div style="position: fixed; z-index: -99; width: 100%; height: 100%; filter: brightness(60%);">

    <iframe id="video-frame"
      frameborder="0"
      height="100%"
      width="100%"
      src=""
    >
    </iframe>
</div>

<div class="vh-100" id="reproductor-musica">

    <input type="file" id="fileUpload" name="fileUpload" accept="audio/mp3, audio/flac" multiple hidden />

    <div class="container h-100">
        <div class="row h-100">

            <div class="m-auto col-6 col-md-4 bg-dark bg-opacity-25" id="caja-cancion">

                <div class="row">
                    <div class="col-12 p-1">
                        <div class="form-group">
                            <img id="caratula" class="img-fluid text-center"/>
                        </div>
                    </div>
                </div>

                <div class="row py-1">
                    <div class="col-12">
                        <div class="form-group text-center">
                            <span id="informacion-cancion" class="pt-1 text-capitalize fuente text-white">Título</span>
                        </div>
                        <div class="form-group text-center py-1">
                            <span id="nombre-artista" class="pt-1 text-capitalize fuente text-white">Artista</span>
                        </div>
                    </div>
                </div>

                <div class="row text-center py-1">

                    <div class="col-3">
                        <div class="form-group">
                            <span class="tiempo text-white text-center" id="progreso">00:00</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input class="tiempo form-range text-white" type="range" value="0" id="slider" />
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <span class="tiempo text-center text-white" id="duracion">00:00</span>
                        </div>
                    </div>

                </div>

                <div class="row py-1">
                    <div class="col-2 text-center">
                        <div class="form-group">
                            <i class="icon-fa fa fa-folder fa-2x icono-reproductor text-white" title="Abrir archivos" id="open-files"></i>
                        </div>
                    </div>

                    <div class="col-2 text-center">
                        <div class="form-group">
                            <i class="icon-fa fa fa-step-backward fa-2x icono-reproductor text-white" title="Pista anterior" id="anterior"></i>
                        </div>
                    </div>

                    <div class="col-4 text-center">
                        <div class="form-group">
                            <i class="icon-fa fa fa-2x fa-play-circle icono-reproductor text-white" title="Reproducir/Pausar" id="play-pause"></i>
                        </div>
                    </div>

                    <div class="col-2 text-center">
                        <div class="form-group">
                            <i class="icon-fa fa fa-step-forward fa-2x icono-reproductor text-white" title="Pista siguiente" id="siguiente"></i>
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

            <div class="col-md-8"></div>

        </div>


    </div>

</div>

@stop


@push('scripts')

<script type="module" src=" {{asset('assets/js/herramientas/musica.js')}}"></script>

@endpush
