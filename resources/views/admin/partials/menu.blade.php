@php
    $r = \Route::current()->getAction();
    $route = (isset($r['as'])) ? $r['as'] : '';
@endphp


<li class="nav-item mT-30">
    <a class="sidebar-link {{ starts_with($route, ADMIN . '.dash') ? 'active' : '' }}" href="{{ route(ADMIN . '.dash') }}">
        <span class="icon-holder">
            <i class="c-blue-500 ti-home"></i>
        </span>
        <span class="title">Dashboard</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link {{ starts_with($route, ADMIN . '.users') ? 'active' : '' }}" href="{{ route(ADMIN . '.users.index') }}">
        <span class="icon-holder">
            <i class="c-brown-500 ti-user"></i>
        </span>
        <span class="title">Users</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link {{ starts_with($route, ADMIN . '.developers') ? 'active' : '' }}" href="{{ route(ADMIN . '.developers.index') }}">
        <span class="icon-holder">
            <i class="c-brown-500 ti-wand"></i>
        </span>
        <span class="title">Developers</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link {{ starts_with($route, ADMIN . '.projects') ? 'active' : '' }}" href="{{ route(ADMIN . '.projects.index') }}">
        <span class="icon-holder">
            <i class="c-brown-500 ti-server"></i>
        </span>
        <span class="title">Projects</span>
    </a>
</li>
