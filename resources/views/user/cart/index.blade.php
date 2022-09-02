@extends('layout.master')

@section('header-script')
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('contents')
    @if (!is_null($cart->name) &&
        !is_null($cart->ref_code) &&
        !is_null($cart->ref_file) &&
        !is_null($cart->rent_time) &&
        !is_null($cart->return_time))
        <div class="col-12 d-flex mb-2 flex-row-reverse">
            <input form="formCheckout" type="submit" value="Check Out" class="btn btn-sm btn-danger">
            <form id="formCheckout" action="{{ route('cart.checkout') }}" method="post">
                @csrf
            </form>
        </div>
    @endif
    <x-card.layout title="Update Dokumen Peminjaman">
        <form id="form" action="{{ route('cart.update', $cart->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <x-forms.put-method />
            <x-forms.input type="text" name="name" label="Name" :value="@$cart->name" />
            <x-forms.input type="text" name="ref_code" label="Document Code" :value="@$cart->ref_code" />
            @if (isset($cart->ref_file))
                <a href="{{ asset($cart->ref_file) }}" target="_blank" class="btn btn-info">Attachment File</a>
            @endif
            <x-forms.input type="file" name="ref_file" label="Document" :value="@$cart->ref_file" />
            <x-forms.input type="date" name="rent_time" label="Rent Time" :value="@$cart->rent_time" />
            <x-forms.input type="date" name="return_time" label="Return Time" :value="@$cart->return_time" />
        </form>
        <button form="form" class="btn btn-primary btn-pill">Submit</button>
        <x-action.cancel />
    </x-card.layout>
    <x-card.layout title="Cart" href="{{ route('rent.index') }}">
        <div class="table-responsive">
            <table class="table datatables-target-exec table-striped">
                <thead>
                    <th>No</th>
                    <th>Product</th>
                    <th>Update Quantity</th>
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
                ajax: "{{ route('cart.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        sortable: false,
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'product.name',
                        name: 'product.name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'delete',
                        name: 'delete',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        })
    </script>
@endsection
