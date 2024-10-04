@extends('admin.main')
@section('content')
<main>
    <div class="container-fluid px-4">
        <div class="row mt-4">
            <div class="col">
                <div class="card mb-4">
                    <div class="card-header">
                        <a class="link-dark" href="{{ route('alat.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a> | Detail untuk Alat "{{ $alat->nama_alat }}"
                    </div>
                    <div class="card-body">
                        <form action="{{ route('alat.update',['id' => $alat->id]) }}" method="POST" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <input class="form-control form-control-lg mb-4" type="text" name="nama" value="{{ $alat->nama_alat }}" required>
                            @error('nama')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <select name="kategori" class="form-select mb-4">
                                @foreach ($kategori as $cat)
                                <option value="{{ $cat->id }}"
                                    @if ($cat->id == $alat->category->id)
                                        selected="selected"
                                    @endif>{{ $cat->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <select name="status" class="form-select mb-4" required>
                                <option value="tersedia" {{ $alat->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="habis" {{ $alat->status == 'habis' ? 'selected' : '' }}>Habis</option>
                            </select>
                            @error('status')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <div class="mb-3">
                                <textarea class="form-control" name="deskripsi" placeholder="Deskripsi singkat" rows="3">{{ $alat->deskripsi }}</textarea>
                            </div>
                            @error('deskripsi')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <div class="mb-3">
                                <span class="form-text mb-2">Harga ditulis angka saja, tidak perlu tanda titik</span>
                                <div class="row d-flex w-100 justify-content-start">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" value="{{ $alat->harga24 }}" name="harga24" class="form-control" placeholder="Harga 24jam" required>
                                        <span class="input-group-text"><b>/24jam</b></span>
                                    </div>
                                    @error('harga24')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" value="{{ $alat->harga12 }}" name="harga12" class="form-control" placeholder="Harga 24jam" required>
                                        <span class="input-group-text"><b>/12jam</b></span>
                                    </div>
                                    @error('harga12')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" value="{{ $alat->harga6 }}" name="harga6" class="form-control" placeholder="Harga 24jam" required>
                                        <span class="input-group-text"><b>/6jam</b></span>
                                    </div>
                                </div>
                                @error('harga6')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                                <div class="mt-3">
                                    <span class="form-text">Upload Gambar Alat</span>
                                    <input type="file" name="gambar" class="form-control">
                                </div>
                                @error('gambar')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                                <div class="row mt-4">
                                    <div class="col-lg-8"></div>
                                    <div class="col-lg-4"><button class="btn btn-success" type="submit" style="float: right">Simpan Perubahan</button></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('alat.destroy',['id'=>$alat->id]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <div class="alert alert-danger">
                                <b>Danger Zone: menghapus alat akan mempengaruhi transaksi yang telah dibuat</b>   <button class="btn btn-danger" onclick="javascript: return confirm('Anda yakin akan menghapus alat ini?');" type="submit">Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
