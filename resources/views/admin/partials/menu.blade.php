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

<li class="nav-item dropdown">
    <a class="dropdown-toggle sidebar-link
       {{ Str::startsWith($route, ADMIN . '.categories') || Str::startsWith($route, ADMIN . '.home_categories')
        || Str::startsWith($route, ADMIN . '.dash') ?
        'actived c-blue-500' : '' }}"
       href="javascript:void(0);">
        <span class="icon-holder">
            <i class="ti-layers-alt"></i>
        </span>
        <span class="title">Categories</span>
        <span class="arrow"><i class="ti-angle-right"></i></span></a>
    <ul class="dropdown-menu">
        <li>
            <a class="{{ Str::startsWith($route, ADMIN . '.categories') ? 'actived c-blue-500' : '' }}"
               href="{{ route(ADMIN . '.categories.index') }}">
                List
            </a>
        </li>
        <li>
            <a class="{{ Str::startsWith($route, ADMIN . '.home_categories') || Str::startsWith($route, ADMIN . '.dash') ?
                        'actived c-blue-500' : '' }}"
               href="{{ route(ADMIN . '.home_categories.index') }}">
                Home Categories
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a class="sidebar-link {{ Str::startsWith($route, ADMIN . '.business') ? 'actived c-blue-500' : '' }}"
       href="{{ route(ADMIN . '.business.index') }}">
        <span class="icon-holder">
            <i class="ti-briefcase"></i>
        </span>
        <span class="title">Business</span>
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
    <a class="sidebar-link {{ Str::startsWith($route, ADMIN . '.countries') ? 'actived c-blue-500' : '' }}"
       href="{{ route(ADMIN . '.countries.index') }}">
        <span class="icon-holder">
            <i class="ti-world"></i>
        </span>
        <span class="title">Countries</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link {{ Str::startsWith($route, ADMIN . '.cities') ? 'actived c-blue-500' : '' }}"
       href="{{ route(ADMIN . '.cities.index') }}">
        <span class="icon-holder">
            <i class="ti-flag-alt"></i>
        </span>
        <span class="title">Cities</span>
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
