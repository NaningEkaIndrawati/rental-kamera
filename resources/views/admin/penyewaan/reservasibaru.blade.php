<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <title>Reservasi Baru</title>
        <style>
            .error-message {
                color: #dc3545; /* Warna merah khas Bootstrap */
                font-size: 0.9em;
                font-weight: bold;
                margin-top: 10px;
                padding: 10px;
                border: 1px solid #dc3545;
                border-radius: 5px;
                background-color: #f8d7da; /* Latar belakang merah muda */
                display: none;
            }
        </style>

    </head>
    <body>
        <div class="container-fluid px-4">
            <!-- Tombol Kembali -->
            <div class="row mt-4">
                <div class="col-12">
                    <a href="{{ route('admin.user') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>

            <!-- Judul -->
            <div class="row mb-4 mt-2">
                <div class="col-12">
                    <h4>Buat Reservasi untuk <b>{{ $penyewa->nama }}</b></h4>
                </div>
            </div>

            <!-- Konten Utama -->
            <div class="row">
                <!-- Daftar Kamera -->
                <div class="col col-md-8 col-sm-12">
                    <div class="card shadow h-100" style="max-height: 100%; overflow:auto">
                        <div class="card-header">
                            <small class="text-muted">klik nama alat untuk melihat detail</small>
                        </div>
                        <div class="card-body">
                            <div class="row row-cols-sm-2 row-cols-lg-4 g-2">
                                @foreach ($alat as $item)
                                <div class="col">
                                    <div class="card h-100">
                                        <img src="{{ url('') }}/images/{{ $item->gambar }}" style="height: 100px; object-fit: cover; filter: brightness(40%);" alt="">
                                        <div class="card-body">
                                            <span class="badge bg-warning">{{ $item->category->nama_kategori }}</span><br>
                                            <b><a class="link-dark" href="{{ route('home.detail', ['id' => $item->id]) }}">{{ $item->nama_alat }}</b></a>
                                            <span @if($item->status == 'tersedia') class="badge bg-primary" @else class="badge bg-danger" @endif>
                                                {{ strtoupper($item->status) }}
                                            </span>
                                            <small>{{ $item->deskripsi }}</small>
                                        </div>
                                        @if ($item->status == "tersedia")
                                        <div class="card-footer">
                                            <form action="{{ route('cart.store', ['id' => $item->id, 'penyewaId' => $penyewa->id]) }}" method="POST">
                                                @csrf
                                                <div class="d-block">
                                                    <button type="submit" class="btn btn-success w-100 mt-2" name="btn" value="24">
                                                        <i class="fas fa-shopping-cart"></i> @money($item->harga24) <b>24jam</b>
                                                    </button>
                                                    <button type="submit" class="btn btn-success w-100 mt-2" name="btn" value="12">
                                                        <i class="fas fa-shopping-cart"></i> @money($item->harga12) <b>12jam</b>
                                                    </button>
                                                    <button type="submit" class="btn btn-success w-100 mt-2" name="btn" value="6">
                                                        <i class="fas fa-shopping-cart"></i> @money($item->harga6) <b>6jam</b>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        @else
                                        <div>
                                            <p class="text-center text-danger fs-2">habis</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keranjang -->
                <div class="col col-md-4 col-sm-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <b>Keranjang</b> <span class="badge bg-secondary">{{ $penyewa->cart->count() }}</span>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                @foreach ($cart as $item)
                                <div class="list-group-item list-group-item-action" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $item->alat->nama_alat }}</h6>
                                        <b>@money($item->harga)</b>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">{{ $item->durasi }} Jam</p>
                                        <form action="{{ route('cart.destroy', ['id' => $item->id]) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button style="background: none" type="submit">
                                                <i class="fas fa-trash" style="color: gray"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex w-100 justify-content-between mb-2">
                                <b>Total</b>
                                <b>@money($total)</b>
                            </div>
                            <small>Tanggal Ambil</small>
                            <form id="checkoutForm" action="{{ route('admin.createorder', ['penyewaId' => $penyewa->id]) }}" method="POST">
                                @csrf
                                <div class="d-flex w-100 justify-content-center mb-4">
                                    <input type="date" name="start_date" class="form-control" required>
                                    <input type="time" name="start_time" class="form-control" required>
                                </div>
                                <button id="checkoutButton" type="submit" style="width: 100%" class="btn btn-success">Checkout</button>
                                <p id="error-message" class="error-message">
                                    Keranjang Anda masih kosong. Silakan pilih barang terlebih dahulu sebelum melanjutkan checkout!
                                </p>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById("checkoutForm").addEventListener("submit", function(event) {
    const cartItems = document.querySelectorAll('.list-group-item'); // Menghitung jumlah item di keranjang
    const errorMessage = document.getElementById("error-message");

    if (cartItems.length === 0) {
        // Jika keranjang kosong, tampilkan pesan error dan hentikan submit
        errorMessage.style.display = "block";
        event.preventDefault();
    } else {
        // Jika keranjang tidak kosong, sembunyikan pesan error
        errorMessage.style.display = "none";
    }
});

        </script>
    </body>
</html>
