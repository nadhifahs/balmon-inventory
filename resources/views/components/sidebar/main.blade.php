<x-sidebar.header href="" icon="" />

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

@if (Auth::guard('web')->check())
    <x-sidebar.single icon="" href="/" title="RENT" />
    <x-sidebar.single icon="" href="/" title="RETURN" />
@else
    <x-sidebar.single activate="{{Request::is('admin/*') && !Request::is('admin/category*')  ? 'active' : ''}}" icon="fas fa-archive" href="{{route('admin.product.index')}}" title="Product" />
@endif
<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
