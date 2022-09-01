@extends('layout.master')

@section('contents')
    <x-card.layout title="{{ request()->routeIs('admin.user.create') ? 'Create User' : 'Update User' }}">
        <form id="form" action="{{ request()->routeIs('admin.user.create') ? route('admin.user.store') : route('admin.user.update', @$user->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @isset($user->avatar)
            <x-forms.view-image label="Avatar" src="{{ asset($user->avatar) }}" />
            @endisset
            <x-forms.file label="Pilih Photo Profil" name="avatar" id="gallery-photo-add" />
            <div class="gallery row row-cols-lg-4 row-cols-md-8 row-cols-sm-12 justify-content-center" id="isi-gallery"></div>
            <x-forms.put-method />
            <x-forms.input type="text" name="name" label="Name" :value="@$user->name" />
            <x-forms.input type="email" name="email" label="Email" :value="@$user->email" />
            <x-forms.input type="text" name="username" label="Username" :value="@$user->username" />
            <x-forms.text type="password" name="password" label="Password" value="" />
        </form>
        <button form="form" class="btn btn-primary btn-pill">Submit</button>
        <x-action.cancel />
    </x-card.layout>
@endsection
