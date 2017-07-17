@extends('layouts.app')

@section('content')
    <div id="dop-nav" class="col-md-2">
        @include('dop-nav.api')
    </div>
    <div id="content" class="col-md-8">
        {!! $RequestStat->render() !!}
        <hr>
        {!! $MethodTop->render() !!}
    </div>
    <link href="{{ asset('css/api.css') }}" rel="stylesheet">
    {!! Charts::assets() !!}
@endsection
