<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @if (Auth::check())
        <script>
            window.API_URL = '{{env('API_URL')}}';
            window.API_TOKEN = '{{Auth::user()->FirstCreatedToken()->token}}';
        </script>
    @else

    @endif

    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
<div id="app" class="wrapper container">
    <div class="row">
        <div>
            <aside id="sidenav" class="col-md-2">@include('include.menu')</aside>
        </div>
        <header>@include('include.user-bar')</header>
        <section class="col-md-10" id="app-content">@yield('content')</section>
        <footer>@include('include.foother')</footer>
    </div>
</div>
</div>
</body>
</html>
