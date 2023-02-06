@extends('layouts.home')

@section('title', 'Grupos')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/grupos/grupos.css')}}">
@endpush

@section('content')

<input type="hidden" value="{{ asset('grupos/')}}" id="assets-grupos"/>
<input type="hidden" value="{{ asset('cursos/')}}" id="assets-cursos"/>

<div class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2 class="my-3 display-5 text-start fw-bolder primer-color-letra">Grupos</h2>

                <div class="row">
                    <ul class="nav nav-tabs my-0-5" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fuenteNormal primer-color-letra primer-color-fondo" id="mis-grupos-tab" data-bs-toggle="tab" data-bs-target="#mis-grupos" type="button" role="tab" aria-controls="mis-grupos" aria-selected="true">Mis grupos</button>
                        </li>
                    </ul>
                </div>

                <div class="box row pt-1">

                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="mis-grupos" role="tabpanel" aria-labelledby="mis-grupos-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive mt-3">
                                        <table class="table table-striped display order-column hover nowrap" id="table-mis-grupos"> </table>
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
<script type="module" src=" {{asset('assets/js/grupos/grupos.js')}}"></script>
@endpush
