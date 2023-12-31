@extends('admin.main')
@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-12">
                <button type="button" class="btn btn-success mt-4" data-bs-toggle="modal" data-bs-target="#addNewUser">Tambah
                    Penyewa</button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow mt-4">
                    <div class="card-header"><b>Penyewa</b></div>
                    <div class="card-body">
                        <table id="dataTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penyewa as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }} <span
                                                class="badge bg-secondary">{{ $item->payment->count() }} Transaksi</span>
                                        </td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>{{ $item->telepon }}</td>
                                        <td>
                                            <a class="btn btn-success"
                                                href="{{ route('admin.buatreservasi', ['penyewaId' => $item->id]) }}">Buat
                                                Reservasi</a>
                                            <!-- Tambahkan atribut data-bs-toggle dan data-bs-target pada tombol "Dokumen Jaminan" -->
                                            <a href="{{route('admin.penyewa.detail',['id'=>$item->id])}}" class="btn btn-warning text-white">
                                                Detail 
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addNewUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Penyewa Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.new') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-floating mb-2">
                            <input type="text" name="nama" class="form-control" id="floatingName" placeholder="Nama"
                                required>
                            <label for="floatingName">Nama Lengkap</label>
                        </div>
                        <div class="form-floating mb-2">
                            <input type="text" name="alamat" class="form-control" id="floatingInput"
                                placeholder="Alamat Lengkap" required>
                            <label for="floatingInput">Alamat Lengkap</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" name="telepon" class="form-control" id="floatingtelp"
                                placeholder="Nomor Telepon" required>
                            <label for="floatingtelp">No Telepon</label>
                        </div>
                        <div class="form-group mb-3">
                            <label for="gambar">Unggah Gambar KTP</label>
                            <input type="file" class="form-control-file" id="gambar" name="gambar-ktp">
                        </div>

                        <button type="submit" class="btn btn-success w-100 mt-4">Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan ini setelah modal addNewUser -->
@endsection
