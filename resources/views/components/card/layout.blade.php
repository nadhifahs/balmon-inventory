<div class="col-12">
    @component('flash')
    @endcomponent
    <div class="card shadow mb-4">
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{$title}}</h6>
            @if (isset($href))
            <a href="{{$href ?? ''}}" class="btn btn-primary btn-sm">Buat</a>
            @endif
        </div>
        <!-- Card Body -->
        <div class="card-body">
            {{$slot}}
        </div>
    </div>
</div>
