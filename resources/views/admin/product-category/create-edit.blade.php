@extends('layout.master')

@section('contents')
    <x-card.layout title="{{ request()->routeIs('admin.category.create') ? 'Create Category' : 'Update Category' }}">
        <form id="form" action="{{ request()->routeIs('admin.category.create') ? route('admin.category.store') : route('admin.category.update', @$productCategory->id) }}" method="post">
            @csrf
            <x-forms.put-method />
            <x-forms.input type="text" name="name" label="Category Name" :value="@$productCategory->name" />
        </form>
        <button form="form" class="btn btn-primary btn-pill">Submit</button>
        <x-action.cancel />
    </x-card.layout>
@endsection
