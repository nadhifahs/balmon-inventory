@extends('layout.master')

@section('header-script')
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css' ) }}" rel="stylesheet" type="text/css">
@endsection

@section('contents')
<x-card.layout title="Peminjaman">
    <div class="table-responsive">
        <table class="table datatables-target-exec table-striped">
            <thead>
                <th>No</th>
                <th>Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Action</th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</x-card.layout>
@endsection

@section('footer-script')
<script>
    $(document).ready(() => {
        var table = $('.datatables-target-exec').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('rent.index') }}",
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
                    data: 'product_category.name',
                    name: 'product_category.name'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
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
