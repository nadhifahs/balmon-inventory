<x-sidebar.header href="" icon="" />

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">
<x-sidebar.single icon="fas fa-home" activate="{{Request::is('admin/home') || Request::is('/')  ? 'active' : ''}}" href="{{Auth::guard('web')->check() ? route('home.index') : route('admin.home.index')}}" title="Dashboard" />
@if (Auth::guard('web')->check())
    <x-sidebar.single icon="" href="/" title="RENT" />
    <x-sidebar.single icon="" href="/" title="RETURN" />
@else
    <x-sidebar.single activate="{{Request::is('admin/product*') && !Request::is('admin/product/category*')  ? 'active' : ''}}" icon="fas fa-archive" href="{{route('admin.product.index')}}" title="Product" />
    <x-sidebar.single activate="{{Request::is('admin/product/category*')  ? 'active' : ''}}" icon="fas fa-cogs" href="{{route('admin.category.index')}}" title="Product Category" />
@endif
<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
