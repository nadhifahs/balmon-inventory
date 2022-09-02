@extends('layout.master')

@section('header-script')
@endsection

@section('contents')
    <x-card.layout title="Scan QR">
        <div id="reader" width="600px"></div>
    </x-card.layout>
@endsection

@section('footer-script')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        // This method will trigger user permissions
        Html5Qrcode.getCameras().then(devices => {
            /**
             * devices would be an array of objects of type:
             * { id: "id", label: "label" }
             */
            if (devices && devices.length) {
                var cameraId = devices[0].id;
                const html5QrCode = new Html5Qrcode( /* element id */ "reader");
                html5QrCode.start(
                        cameraId, {
                            fps: 10, // Optional, frame per seconds for qr code scanning
                            qrbox: {
                                width: 250,
                                height: 250
                            } // Optional, if you want bounded box UI
                        },
                        (decodedText, decodedResult) => {
                            console.log(decodedText);
                            let response = JSON.parse(decodedText);
                            window.location.href= '{{url('/')}}/admin/confirm/' + response.rent_code;
                        },
                        (errorMessage) => {
                            // parse error, ignore it.
                        })
                    .catch((err) => {
                        // Start failed, handle it.
                    });
            }
        }).catch(err => {
            // handle err
        });
    </script>
@endsection
