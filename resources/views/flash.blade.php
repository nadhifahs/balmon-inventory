{{-- Success Alert --}}
@if(session('status'))
<div class="alert alert-success alert-dismissible fade show">
    {{session('status')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
</div>

@endif

{{-- Error Alert --}}
@if(session('error'))
<div class="alert alert-danger alert-dismissible show fade">
    {{session('error')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
</div>
@endif


@if ($errors->any())
<div class="alert alert-danger alert-dismissible show fade">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
