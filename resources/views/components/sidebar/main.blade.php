<x-sidebar.header href="{{ Auth::guard('web')->check() ? route('home.index') : route('admin.home.index') }}"
    icon="fas fa-warehouse" />

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">
<x-sidebar.single icon="fas fa-home" activate="{{ Request::is('admin/home') || Request::is('/') ? 'active' : '' }}"
    href="{{ Auth::guard('web')->check() ? route('home.index') : route('admin.home.index') }}" title="Dashboard" />
<hr class="sidebar-divider d-none d-md-block">
@if (Auth::guard('web')->check())
    <x-sidebar.single activate="{{ Request::is('cart*') ? 'active' : '' }}" icon="fas fa-shopping-cart"
        href="{{ route('cart.index') }}" title="CART" />
    <hr class="sidebar-divider d-none d-md-block">
    <x-sidebar.parent collapse="{{ Request::is('rent/pickup*') ? 'show' : '' }}"
        activate="{{ Request::is('rent*') ? 'active' : '' }}" icon="fas fa-pen-square" href="{{ route('rent.index') }}"
        title="Rent Action">
        <x-sidebar.child activate="{{ Request::is('rent*') && !Request::is('rent/pickup*') ? 'active' : '' }}"
            text="Request" href="{{ route('rent.index') }}" />
        <x-sidebar.child activate="{{ Request::is('rent/detail*') ? 'active' : '' }}" text="Detail"
            href="{{ route('rent.detail') }}" />
    </x-sidebar.parent>
    <x-sidebar.single activate="{{ Request::is('return*') ? 'active' : '' }}" icon="fas fa-box-open"
        href="{{ route('return.index') }}" title="RETURN" />
@else
    <x-sidebar.single
        activate="{{ Request::is('admin/product*') && !Request::is('admin/product/category*') ? 'active' : '' }}"
        icon="fas fa-archive" href="{{ route('admin.product.index') }}" title="Product" />
    <x-sidebar.single activate="{{ Request::is('admin/product/category*') ? 'active' : '' }}" icon="fas fa-vote-yea"
        href="{{ route('admin.category.index') }}" title="Product Category" />
    <x-sidebar.single activate="{{ Request::is('admin/user*') ? 'active' : '' }}" icon="fas fa-user"
        href="{{ route('admin.user.index') }}" title="User" />
    <x-sidebar.single activate="{{ Request::is('admin/admin*') ? 'active' : '' }}" icon="fas fa-user-shield"
        href="{{ route('admin.admin.index') }}" title="Admin" />
    <hr class="sidebar-divider d-none d-md-block">
    <x-sidebar.single activate="{{ Request::is('admin/scan*') ? 'active' : '' }}" icon="fas fa-cogs"
    href="{{ route('admin.scan.index') }}" title="Scan" />
    <x-sidebar.single activate="{{ Request::is('admin/confirm*') ? 'active' : '' }}" icon="fas fa-cogs"
        href="{{ route('admin.confirm.index') }}" title="Transaction" />
    <x-sidebar.single activate="{{ Request::is('admin/report*') ? 'active' : '' }}" icon="fas fa-cogs"
        href="{{ route('admin.rent.report') }}" title="Report" />
@endif
<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
