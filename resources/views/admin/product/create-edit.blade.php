@extends('layout.master')

@section('contents')
    <x-card.layout title="{{ request()->routeIs('admin.product.create') ? 'Create Product' : 'Update Update Product' }}">
        <form id="form" action="{{ request()->routeIs('admin.product.create') ? route('admin.product.store') : route('admin.product.update', @$product->id) }}" method="post">
            @csrf
            <x-forms.put-method />
            <x-forms.input type="text" name="name" label="Product Name" :value="@$product->name" />
            <x-forms.select label="Product Category" :items="@$category" name="product_category_id" :value="@$product->product_category_id" />
            <x-forms.input type="number" name="quantity" label="Product Quantity" :value="@$product->quantity" />
        </form>
        <button form="form" class="btn btn-primary btn-pill">Submit</button>
        <x-action.cancel />
    </x-card.layout>
@endsection
