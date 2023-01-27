@extends('layouts.home')

@section('title', 'Conversacion')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/chats/detallechat.css')}}">
@endpush

@section('content')

<input type="hidden" value="{{ asset('usuarios/')}}" id="assets"/>

<div class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-2">
                        
                    </div>
                    <div class="col-md-10">

                    </div>
                </div>

                <div class="row">
                    
                </div>

                <div class="row">
                    
                </div>

            </div>


        </div>
    </div>
</div>


@stop


@push('scripts')
<script type="module" src=" {{asset('assets/js/chats/detallechat.js')}}"></script>
@endpush
