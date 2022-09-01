@extends('layout.master')

@section('header-script')
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css' ) }}" rel="stylesheet" type="text/css">
@endsection

@section('contents')
<x-card.layout title="Product" href="{{route('admin.user.create')}}">
    <div class="table-responsive">
        <table class="table datatables-target-exec table-striped">
            <thead>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Username</th>
                <th>Action</th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</x-card.layout>
@endsection

@section('footer-script')
<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(() => {
        var table = $('.datatables-target-exec').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.user.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },{
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    })
</script>
@endsection
