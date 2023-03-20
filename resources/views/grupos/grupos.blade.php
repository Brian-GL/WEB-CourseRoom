@extends('layouts.home')

@section('title', 'Grupos')

@push('styles')
<link rel="stylesheet" href="{{ asset ('build/assets/grupos.581234ad.css')}}">
@endpush

@section('content')

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
<script type="module" src=" {{asset('build/assets/grupos.a4a23f48.js')}}"></script>
@endpush
