@extends('layout.master')

@section('header-script')
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('contents')
    <div class="row">
        @if ($cart->status !== 'RETURN')
        <div class="col-lg-6 col-12">
            <x-card.layout title="Status Confirm">
                {{-- @dd($cart->cart_detail->where('status', 'RENT')->count()) --}}
                <button class="btn btn-primary" {{$cart->cart_detail->where('status', 'RENT')->count() > 0 ? 'disabled' : ''}} form="idPinjam">{{ $cartStatus }}</button>
                <form id="idPinjam" action="{{ route('admin.scan.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="rent_code" value="{{ $cart->rent_code }}">
                </form>
            </x-card.layout>
        </div>
        @endif
        @if ($cart->status == 'RETURN')
        <div class="col-lg-6 col-12">
            <x-card.layout title="Status Confirm">
                {{-- @dd($cart->cart_detail->where('status', 'RENT')->count()) --}}
                <button class="btn btn-primary" form="idPinjam">Print</button>
                <form id="idPinjam" action="{{ route('admin.print.post', $cart->rent_code) }}" method="POST">
                    @csrf
                </form>
            </x-card.layout>
        </div>
        @endif
        <div class="col-lg-6 col-12">
            <x-card.layout title="Rent Transaction Detail">
                <div class="card table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <th>Parameter</th>
                            <th>Value</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $cart->name }}</td>
                            </tr>
                            <tr>
                                <th>Ref Code</th>
                                <td>{{ $cart->ref_code }}</td>
                            </tr>
                            <tr>
                                <th>Ref File</th>
                                <td><a href="{{ asset($cart->ref_file) }}" target="_blank" class="btn btn-info">Attachment
                                        File</a></td>
                            </tr>
                            <tr>
                                <th>Rent Time</th>
                                <td>{{ \Carbon\Carbon::parse($cart->rent_time)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Return Time</th>
                                <td>{{ \Carbon\Carbon::parse($cart->return_time)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Verified by Admin</th>
                                <td class="text-danger"><strong>{{ $cart->admin->name ?? 'Belum ter-Verifikasi' }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </x-card.layout>
        </div>
    </div>
    <div class="col-12">
        <x-card.layout title="Rent Transaction Detail">
            <div class="card table-responsive">
                <table class="table table-striped">
                    <thead>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        @if ($cart->status == 'RENT')
                            <th>Condition Before</th>
                            <th>Action</th>
                        @endif
                    </thead>
                    <tbody>
                        @foreach ($cart->cart_detail as $each)
                            <tr>
                                <td>{{ $each->product->name }}</td>
                                <td>{{ $each->quantity }}</td>
                                <td>{{ $each->status == 'RENT' ? 'MASIH DIPINJAM' : 'SUDAH DITERIMA' }}</td>
                                @if ($cart->status == 'RENT')
                                    <td>
                                        {{ $each->product->condition }}
                                    </td>
                                    <td>
                                        @if ($each->status !== 'RETURN')
                                        <form action="{{ route('admin.confirm.return', $each->id) }}" method="POST">
                                            @csrf
                                            <div class="form-row align-items-center">
                                                <div class="col-auto">
                                                    <label class="sr-only" for="inlineFormInput">Kondisi</label>
                                                    <select name="condition" class="custom-select">
                                                        <option value="BAIK">Baik</option>
                                                        <option value="RUSAK">Rusak</option>
                                                    </select>
                                                </div>
                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-outline-primary mb-2">Kembalikan</button>
                                                </div>
                                            </div>
                                        </form>
                                        @endif
                                    </td>
                                @endif
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
