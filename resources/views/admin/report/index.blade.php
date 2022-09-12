@extends('layout.master')

@section('header-script')
<link href="{{asset('assets/css/datepicker.css')}}" rel="stylesheet">
@endsection

@section('contents')
    <x-card.layout title="Report By Month">
        <form action="{{route('admin.rent.report.export')}}" method="post">
            @csrf
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                  </div>
                <input type="text" name="month" id="datepicker">
            </div>
            <button class="btn btn-primary" type="submit">Export</button>
        </form>
    </x-card.layout>
    <x-card.layout title="Report ALl">
        <form action="{{route('admin.rent.report.export')}}" method="post">
            @csrf
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                  </div>
                <input type="text" name="month" id="datepicker">
            </div>
            <button class="btn btn-primary" type="submit">Export</button>
        </form>
    </x-card.layout>
@endsection

@section('footer-script')
<script src="{{asset('assets/js/bootstrap-datepicker.js')}}"></script>
<script>
    $(document).ready(() => {
        $("#datepicker").datepicker( {
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });
    })
</script>
@endsection
