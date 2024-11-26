@extends('admin.main')
@section('content')
<div class="container">
    <div class="row justify-content-center mt-4 mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Identitas Penyewa</div>

                <div class="card-body">
                    <p><strong>Nama:</strong> {{ $penyewa->nama }}</p>
                    <p><strong>Email:</strong> {{ $penyewa->email }}</p>
                    <p><strong>Alamat:</strong> {{ $penyewa->alamat }}</p>
                    <p><strong>Telepon:</strong> {{ $penyewa->telepon }}</p>

                    <hr>

                    <h5>Dokumen Jaminan</h5>
                    <img src="{{ asset('storage\app\public\public\gambar_ktp' . $penyewa->ktp) }}" alt="Dokumen Jaminan" class="img-fluid">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
