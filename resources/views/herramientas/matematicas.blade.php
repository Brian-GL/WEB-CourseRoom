@extends('layouts.home')

@section('title', 'Resolvedor matemático')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/herramientas/matematicas.css')}}">
@endpush

@section('content')

<div class="col-md-12">
    <div class="container">
        <div class="row m-auto">
            <div class="col-md-12 m-auto p-5" id="cuerpo">
                <div class="row text-center py-1">
                    <div class="col">
                        <div class="form-group">
                            <span class="titulo">M &nbsp; A &nbsp; T &nbsp; H</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <span class="titulo">S &nbsp; O &nbsp; L &nbsp; V &nbsp; E &nbsp; R &nbsp;</span>
                        </div>
                    </div>
                </div>
                <div class="row text-center py-3">
                    <div class="form-group">
                        <span class="frase fuente">Powered By
                            <a href="https://newton.vercel.app/" target="_blank" class="link-primary">
                                <strong>Newton API</strong>
                            </a>
                        </span>
                    </div>
                </div>
                <div class="row py-3">
                    <div class="col-sm-5">
                        <div class="form-group text-start">
                            <input id="expresion" class="form-control" placeholder="Ingrese su operación del tipo x^2 - 1" type="text">
                        </div>
                    </div>
                    <div class="col padding">
                        <div class="form-group text-end">
                            <select class="form-select" id="tipo-operaciones">

                                <option hidden selected>Seleccione una opción</option>

                                @foreach ($operaciones as $operacion)
                                    <option value="{{$operacion->clave}}">{{$operacion->nombre}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col padding">
                        <div class="form-group text-center">
                            <button class="btn btn-dark" id="solucionar">Solucionar</button>
                        </div>
                    </div>
                </div>

                <div class="row text-center py-3">
                    <div class="form-group">
                        <textarea id="resultado" class="form-control" disabled cols="3" rows="5"></textarea>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@stop


@push('scripts')
<script type="module" src=" {{asset('assets/js/herramientas/matematicas.js')}}"></script>
@endpush
