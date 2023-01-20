@extends('layouts.home')

@section('title', 'Chats')

@push('styles')
<link rel="stylesheet" href="{{ asset ('assets/css/chats/chats.css')}}">
@endpush

@section('content')


@stop


@push('scripts')
<script type="module" src=" {{asset('assets/js/chats/chats.js')}}"></script>
@endpush
