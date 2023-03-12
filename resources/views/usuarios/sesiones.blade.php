@extends('layouts.home')

@section('title', 'Sesiones')

@push('styles')
<link rel="stylesheet" href="{{ asset ('build/assets/sesiones.63892b4b.css')}}">
@endpush

@section('content')

<div class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2 class="my-3 display-5 text-start fw-bolder primer-color-letra">Sesiones</h2>

                <div class="box row pt-1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive mt-3">
                                    <table class="table display order-column hover nowrap" id="table-sesiones"> </table>
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
<script type="module" src=" {{asset('build/assets/sesiones.74794391.js')}}"></script>
@endpush
