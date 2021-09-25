@php
    $r = \Route::current()->getAction();
    $route = (isset($r['as'])) ? $r['as'] : '';
@endphp

{{--<li class="nav-item mT-30">--}}
{{--    <a class="sidebar-link {{ Str::startsWith($route, ADMIN . '.dash') ? 'actived  c-blue-500' : '' }}"--}}
{{--       href="{{ route(ADMIN . '.dash') }}">--}}
{{--        <span class="icon-holder">--}}
{{--            <i class="ti-home"></i>--}}
{{--        </span>--}}
{{--        <span class="title">Dashboard</span>--}}
{{--    </a>--}}
{{--</li>--}}

<li class="nav-item">
    <a class="sidebar-link {{ Str::startsWith($route, ADMIN . '.items') ? 'actived c-blue-500' : '' }}"
       href="{{ route(ADMIN . '.items.index') }}">
        <span class="icon-holder">
            <i class="ti-package"></i>
        </span>
        <span class="title">Productos</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link {{ Str::startsWith($route, ADMIN . '.users') ? 'actived c-blue-500' : '' }}"
       href="{{ route(ADMIN . '.users.index') }}">
        <span class="icon-holder">
            <i class="ti-user"></i>
        </span>
        <span class="title">Users</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link {{ Str::startsWith($route, ADMIN . '.carousel') ? 'actived c-blue-500' : '' }}"
       href="{{ route(ADMIN . '.carousel.index') }}">
        <span class="icon-holder">
            <i class="ti-gallery"></i>
        </span>
        <span class="title">Carousel</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link {{ Str::startsWith($route, ADMIN . '.notifications') ? 'actived c-blue-500' : '' }}"
       href="{{ route(ADMIN . '.notifications.index') }}">
        <span class="icon-holder">
            <i class="ti-bell"></i>
        </span>
        <span class="title">Notifications</span>
    </a>
</li>
