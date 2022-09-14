@extends('layout.master')

@section('header-script')
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css' ) }}" rel="stylesheet" type="text/css">
@endsection

@section('contents')
<div class="row">
    @if (in_array($cart->status, ['READY TO PICKUP', 'RENT']))
    <div class="col-lg-6 col-12">
        <x-card.layout title="Barcode To Identify">
            <div class="text-center">
                {!! QrCode::size(200)->generate(json_encode(['user_id' => Auth::user()->id, 'rent_code' => $cart->rent_code])) !!}
                <p class="notify">Waiting for scanning</p>
            </div>
        </x-card.layout>
    </div>
    @endif
    <div class="col-lg-6 col-12">
        <x-card.layout title="Detail Rent Transaction">
            <div class="card table-responsive">
                <table class="table table-striped">
                    <thead>
                        <th>Parameter</th>
                        <th>Value</th>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td>{{$cart->name}}</td>
                        </tr>
                        <tr>
                            <th>Ref Code</th>
                            <td>{{$cart->ref_code}}</td>
                        </tr>
                        <tr>
                            <th>Ref File</th>
                            <td><a href="{{ asset($cart->ref_file) }}" target="_blank" class="btn btn-info">Attachment File</a></td>
                        </tr>
                        <tr>
                            <th>Rent Time</th>
                            <td>{{\Carbon\Carbon::parse($cart->rent_time)->format('d F Y')}}</td>
                        </tr>
                        <tr>
                            <th>Return Time</th>
                            <td>{{\Carbon\Carbon::parse($cart->return_time)->format('d F Y')}}</td>
                        </tr>
                        <tr>
                            <th>Verified by Admin</th>
                            <td class="text-danger"><strong>{{$cart->admin->name ?? 'Belum ter-Verifikasi'}}</strong></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td class="text-{{$colorStatus}}"><strong>{{$cart->status}}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-card.layout>
    </div>
</div>
<div class="col-12">
    <x-card.layout title="Detail Rent Transaction">
        <div class="card table-responsive">
            <table class="table table-striped">
                <thead>
                    <th>Product Name</th>
                    <th>Quantity</th>
                </thead>
                <tbody>
                    @foreach ($cart->cart_detail as $each)
                    <tr>
                        <td>{{$each->product->name ?? 'Product Dihapus' }}</td>
                        <td>{{$each->quantity}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card.layout>
</div>

@endsection

@section('footer-script')

@endsection
