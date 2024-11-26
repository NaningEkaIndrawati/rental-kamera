@extends('admin.main')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-12">
                <button type="button" class="btn btn-success mt-4" data-bs-toggle="modal" data-bs-target="#addNewUser">Tambah Penyewa</button>
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
                                        <td>{{ $item->nama }} <span class="badge bg-secondary">{{ $item->payment->count() }} Transaksi</span></td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>{{ $item->telepon }}</td>
                                        <td>
                                            <a class="btn btn-success" href="{{ route('admin.buatreservasi', ['penyewaId' => $item->id]) }}">Buat Reservasi</a>
                                            <a href="{{ route('admin.penyewa.detail', ['id' => $item->id]) }}" class="btn btn-warning text-white">Detail</a>
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

    <!-- Modal untuk menambahkan penyewa -->
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

                        <!-- Tampilkan pesan kesalahan secara umum -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" required minlength="3" maxlength="30" pattern="[A-Za-z\s]+" title="Nama hanya boleh terdiri dari huruf dan spasi.">
                        </div>

                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input type="text" class="form-control" name="telepon" id="telepon" required minlength="12" maxlength="12" pattern="\d+" title="Telepon harus berupa angka dan panjang 12 digit.">
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" name="alamat" id="alamat" required>
                        </div>

                        <div class="form-group">
                            <label for="gambar-ktp">Gambar KTP</label>
                            <input type="file" class="form-control" name="gambar-ktp" id="gambar-ktp" required accept="image/jpeg, image/png, image/jpg, image/gif">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-4">Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        let valid = true;

        // Validasi Nama
        const nama = document.getElementById('nama');
        if (!nama.value.match(/^[a-zA-Z\s]+$/)) {
            alert('Nama hanya boleh huruf dan spasi');
            valid = false;
        }

        // Validasi Telepon
        const telepon = document.getElementById('telepon');
        if (!telepon.value.match(/^\d{12}$/)) {
            alert('Telepon harus berupa angka dan panjang 12 digit');
            valid = false;
        }

        // Cegah submit jika validasi gagal
        if (!valid) {
            event.preventDefault();
        }
    });
</script>
@endsection
