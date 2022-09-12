@extends('layout.master')

@section('contents')
<div class="row">
    <x-card.highlight title="Total Product" value="{{$totalProduct}}" />
    <x-card.highlight varian="success" title="Rent Product" value="{{$rentProduct}}" />
    <x-card.highlight varian="info" title="Available Product" value="{{$availableProduct}}" />
    <x-card.highlight varian="info" title="Good Product" value="{{$goodProduct}}" />
    <x-card.highlight varian="info" title="Bad Product" value="{{$badProduct}}" />
    <x-card.highlight varian="info" title="Maintenace Product" value="{{$maintenanceProduct}}" />
</div>
<div class="row">

</div>
@endsection
