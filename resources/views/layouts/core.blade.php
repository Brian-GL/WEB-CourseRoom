<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="min-vh-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('build/assets/core.db3e91cd.css') }}">
    @stack('styles')

    <!-- Scripts -->
    @vite(['resources/js/app.js'])

</head>
<body class="min-vh-100" id="fondo">

    <input type="hidden" id="happy-owl" value="{{ asset ('build/assets/HappyOwl.747ca1f1.png')}}">
    <input type="hidden" id="indifferent-owl" value="{{ asset ('build/assets/IndiferentOwl.f926f13c.png')}}">
    <input type="hidden" id="sad-owl" value="{{ asset ('build/assets/SadOwl.1c6ceeff.png')}}">

    <div id="preloader"></div>

    <div class="container-fluid min-vh-100">
        <div class="row min-vh-100 d-flex align-items-center">
            @yield('content')
        </div>
    </div>

    <script type="module" src="{{ asset ('build/assets/core.2a1dee95.js')}}"></script>
    @stack('scripts')
</body>
</html>
