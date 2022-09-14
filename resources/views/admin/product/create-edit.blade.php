@extends('layout.master')

@section('contents')
    <x-card.layout title="{{ request()->routeIs('admin.product.create') ? 'Create Product' : 'Update Update Product' }}">
        <form id="form"
            action="{{ request()->routeIs('admin.product.create') ? route('admin.product.store') : route('admin.product.update', @$product->id) }}"
            method="post">
            @csrf
            <x-forms.put-method />
            <x-forms.input type="text" name="name" label="Product Name" :value="@$product->name" />
            <x-forms.input type="text" name="brand" label="Product Brand" :value="@$product->brand" />
            <x-forms.input type="text" name="series" label="Product Series" :value="@$product->series" />
            <x-forms.input type="text" name="type" label="Product Type" :value="@$product->type" />
            <div class="form-group mb-2">
                <label class="col-form-label" class="form-label" for="selectkondisi">Select Condition</label>
                <select name="condition" id="selectkondisi" class="custom-select">
                    <option value="BAIK" {{ @$product->condition == 'BAIK' ? 'selected' : '' }}>Baik</option>
                    <option value="RUSAK" {{ @$product->condition == 'RUSAK' ? 'selected' : '' }}>Rusak</option>
                    <option value="MAINTENANCE" {{ @$product->condition == 'MAINTENANCE' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>
            {{-- <x-forms.input type="text" name="condition" label="Product Condition" :value="@$product->condition" /> --}}
            <x-forms.input type="number" name="year" label="Year" :value="@$product->year" />
            <x-forms.select label="Product Category" :items="@$category" name="product_category_id" :value="@$product->product_category_id" />
            {{-- <x-forms.input type="number" name="quantity" label="Product Quantity" :value="@$product->quantity" /> --}}
        </form>
        <button form="form" class="btn btn-primary btn-pill">Submit</button>
        <x-action.cancel />
    </x-card.layout>
@endsection
