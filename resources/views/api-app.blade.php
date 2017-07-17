@extends('layouts.app')

@section('content')
    <div id="dop-nav" class="col-md-2">
        @include('dop-nav.api')
    </div>
    <div id="content">

    </div>
    <link href="{{ asset('css/api.css') }}" rel="stylesheet">
@endsection
