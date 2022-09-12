@extends('layout.master')

@section('contents')
@component('flash')
@endcomponent
<div class="row">
    <x-card.highlight title="Total Product" value="{{$totalProduct}}" />
    <x-card.highlight varian="success" title="Total User" value="{{$totalUser}}" />
    <x-card.highlight varian="info" title="Total Admin" value="{{$totalAdmin}}" />
    <x-card.highlight varian="success" title="Rent Product" value="{{$rentProduct}}" />
    <x-card.highlight varian="danger" title="Available Product" value="{{$availableProduct}}" />
    <x-card.highlight varian="secondary" title="Good Product" value="{{$goodProduct}}" />
    <x-card.highlight varian="warning" title="Bad Product" value="{{$badProduct}}" />
    <x-card.highlight varian="danger" title="Maintenace Product" value="{{$maintenanceProduct}}" />
</div>
<div class="row">

</div>
@endsection
