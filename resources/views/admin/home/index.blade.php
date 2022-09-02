@extends('layout.master')

@section('contents')
@component('flash')
@endcomponent
<div class="row">
    <x-card.highlight title="Total Product" value="{{$totalProduct}}" />
    <x-card.highlight varian="success" title="Total User" value="{{$totalUser}}" />
    <x-card.highlight varian="info" title="Total Admin" value="{{$totalAdmin}}" />
</div>
<div class="row">

</div>
@endsection
