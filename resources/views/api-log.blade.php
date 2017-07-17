@extends('layouts.app')

@section('content')
    <div id="dop-nav" class="col-md-2">
        @include('dop-nav.api')
    </div>
    <div id="content" class="col-md-8">
        <table id="log" class="table table-hover">
            <thead>
            <tr>
                <th>Используемый токен</th>
                <th>Запрашиваемый метод</th>
                <th>Время выполнения запроса</th>
                <th>Запрос был выполнен с IP</th>
                <th>Дата выполнения запроса</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($logs as $log)
                <tr>
                    <th>{{ $log->token }}</th>
                    <th>{{ $log->method }}</th>
                    <th>{{ number_format($log->execute_time,4) }} сек.</th>
                    <th>{{ $log->client_ip }}</th>
                    <th>{{ $log->created_at }}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $logs->links() }}
    </div>

    <link href="{{ asset('css/api.css') }}" rel="stylesheet">
@endsection
