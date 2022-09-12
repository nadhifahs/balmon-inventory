<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
    <p class="text-center">Rent Transaction Report</p>
    <div class="container">
        <div class="mx-auto">
            <div class="table-responsive">
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
            <p class="text-center">Detail Product Rented</p>
            <div class="mt-3 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Condition</th>
                    </thead>
                    <tbody>
                        @foreach ($cart->cart_detail as $each)
                            <tr>
                                <td>{{ $each->product->name }}</td>
                                <td>{{ $each->quantity }}</td>
                                <td>{{ $each->status == 'RENT' ? 'MASIH DIPINJAM' : 'SUDAH DITERIMA' }}</td>
                                <td>
                                    {{ $each->product->condition }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>
</body>

</html>
