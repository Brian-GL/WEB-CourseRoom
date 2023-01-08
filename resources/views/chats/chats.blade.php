@extends('layouts.home')

@section('title', 'Chats')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/chats/chats.css')}}">
@endpush

@section('content')

<div class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2 class="my-3 display-5 text-start fw-bolder primer-color-letra">Chats </h2>

                <div class="row">
                    <div class="col-md-10">
                    </div>
                    <div class="col-md-2 d-flex justify-content-end">
                        <button class="btn fuenteNormal my-1 text-wrap border border-2 tercer-color-letra tercer-color-fondo" type="button" id="agregar-chat" >
                            <i class="fa-solid fa-plus"></i> Agregar chat
                        </button>
                    </div>
                </div>

                <div class="box row pt-1">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive mt-3">
                                <table class="table table-striped display order-column hover nowrap" id="table-mis-chats"> </table>
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
<script type="module" src=" {{asset('assets/js/chats/chats.js')}}"></script>
@endpush
