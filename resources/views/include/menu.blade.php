<ul class="nav" id="sidebar">
    <div class="brand">Service-Voice</div>

    <li {{ (Request::is('dashboard') ? 'class=active' : '') }}>
        <a href="{{ route('dashboard') }}">
            <i class="glyphicon glyphicon-dashboard"></i>
            <span class="collapse in">Центр упарвления</span>
        </a>
    </li>
    <li {{ (Request::is('teamspeak3-server') ? 'class=active' : '') }}>
        <a href="{{ route('teamspeak3-server') }}">
            <i class="fa fa-server" aria-hidden="true"></i>
            <span class="collapse in">TeamSpeak3 сервера</span>
        </a>
    </li>
    <li {{ (Request::is('teamspeak3/dns*') ? 'class=active' : '') }}>
        <a href="{{ route('teamspeak3-dns') }}">
            <i class="fa fa-globe" aria-hidden="true"></i>
            <span class="collapse in">TeamSpeak3 домены</span>
        </a>
    </li>
    <li {{ (Request::is('monitoring') ? 'class=active' : '') }}>
        <a href="{{ route('monitoring') }}">
            <i class="glyphicon glyphicon-dashboard"></i>
            <span class="collapse in">Мониторинг</span>
        </a>
    </li>
    <li {{ (Request::is('api-*') ? 'class=active' : '') }}>
        <a href="{{ route('api-app') }}">
            <i class="fa fa-cog align-middle" aria-hidden="true"></i>
            <span class="collapse in">API</span>
        </a>
    </li>
    <li>
        <a href="{{ route('docs') }}">
            <i class="fa fa-book align-middle" aria-hidden="true"></i>
            <span class="collapse in">Документация API</span>
        </a>
    </li>
</ul>

<a data-toggle="offcanvas" class="toggleMenu text-center">
    <div ><i id="sidebar-button" class="fa fa-chevron-left" aria-hidden="true"></i></div>

</a>