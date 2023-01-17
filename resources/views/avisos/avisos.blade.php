@extends('layouts.home')

@section('title', 'Avisos')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/avisos/avisos.css')}}">
@endpush

@section('content')

<div class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2 class="my-3 display-5 text-start fw-bolder primer-color-letra">Avisos</h2>

                <div class="box row pt-1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive mt-3">
                                    <table class="table display order-column hover nowrap" id="table-avisos"> </table>
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
<script type="module" src="{{asset('assets/js/avisos/avisos.js')}}"></script>
@endpush
