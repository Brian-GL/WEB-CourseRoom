@extends('layouts.home')

@section('title', 'Grupos')

@push('styles')
<link rel="stylesheet" href="{{ asset ('build/assets/grupos.581234ad.css')}}">
@endpush

@section('content')

<input type="hidden" value="{{ asset('grupos/')}}" id="assets-grupos"/>
<input type="hidden" value="{{ asset('cursos/')}}" id="assets-cursos"/>

<div class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2 class="my-3 display-5 text-start fw-bolder primer-color-letra">Grupos</h2>
                <div class="box row pt-1">
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

@stop

@push('scripts')
<script type="module" src=" {{asset('build/assets/grupos.92e5b2a7.js')}}"></script>
@endpush
