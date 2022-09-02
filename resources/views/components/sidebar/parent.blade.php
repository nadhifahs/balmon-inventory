<li class="nav-item {{$activate}}">
    <a class="nav-link" href="{{$href}}" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true"
        aria-controls="collapseUtilities">
        <i class="{{ $icon }}"></i>
        <span>{{ $title }}</span>
    </a>
    <div id="collapseUtilities" class="collapse {{$collapse}}" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            {{ $slot }}
        </div>
    </div>
</li>
