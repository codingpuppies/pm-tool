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
    <a class="sidebar-link {{ starts_with($route, ADMIN . '.projects') ? 'active' : '' }}" href="{{ route(ADMIN . '.projects.index') }}">
        <span class="icon-holder">
            <i class="c-orange-500 ti-server"></i>
        </span>
        <span class="title">Projects</span>
    </a>
</li>
<ul>

</ul>
<li class="nav-item">
    <a class="sidebar-link {{ starts_with($route, ADMIN . '.projectdevelopers') ? 'active' : '' }}" href="{{ route(ADMIN . '.projectdevelopers.index') }}">
        <span class="icon-holder">
            <i class="c-purple-500 fa fa-users"></i>
        </span>
        <span class="title">Project Developers</span>
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link {{ starts_with($route, ADMIN . '.developers') ? 'active' : '' }}" href="{{ route(ADMIN . '.developers.index') }}">
        <span class="icon-holder">
            <i class="c-green-500 fa fa-user-circle"></i>
        </span>
        <span class="title">Developers</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link {{ starts_with($route, ADMIN . '.management') ? 'active' : '' }}" href="{{ route(ADMIN . '.management.index') }}">
        <span class="icon-holder">
            <i class="c-amber-700 ti-crown"></i>
        </span>
        <span class="title">Management</span>
    </a>
</li>
<hr>

<li class="nav-item">
    <a class="sidebar-link {{ starts_with($route, ADMIN . '.fixedcosts') ? 'active' : '' }}" href="{{ route(ADMIN . '.fixedcosts.index') }}">
        <span class="icon-holder">
            <i class="c-amber-500 fa fa-money"></i>
        </span>
        <span class="title">Fixed Costs</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link {{ starts_with($route, ADMIN . '.variablecost') ? 'active' : '' }}" href="{{ route(ADMIN . '.variablecost.index') }}">
        <span class="icon-holder">
            <i class="c-indigo-500 ti-pulse"></i>
        </span>
        <span class="title">Variable Costs</span>
    </a>
</li><li class="nav-item">
    <a class="sidebar-link {{ starts_with($route, ADMIN . '.othercosts') ? 'active' : '' }}" href="{{ route(ADMIN . '.othercosts.index') }}">
        <span class="icon-holder">
            <i class="c-yellow-900 ti-face-smile"></i>
        </span>
        <span class="title">Others</span>
    </a>
</li>
<hr>
<li class="nav-item">
    <a class="sidebar-link {{ starts_with($route, ADMIN . '.users') ? 'active' : '' }}" href="{{ route(ADMIN . '.users.index') }}">
        <span class="icon-holder">
            <i class="c-red-500 fa fa-key"></i>
        </span>
        <span class="title">Users</span>
    </a>
</li>

