    <ul class="dop-nav">
        <li {{ (Request::is('api-app') ? 'class=active' : '') }}><a href="{{route('api-app')}}">Приложения</a></li>
        <li {{ (Request::is('api-log') ? 'class=active' : '') }}><a href="{{route('api-log')}}">История запросов</a></li>
        <li {{ (Request::is('api-stat') ? 'class=active' : '') }}><a href="{{route('api-stat')}}">Статистика запросов</a></li>
    </ul>
