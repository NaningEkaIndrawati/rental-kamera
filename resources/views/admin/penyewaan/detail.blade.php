@extends('admin.main')
@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('penyewaan.index') }}"><i class="fas fa-arrow-left"></i></a> Detail
                            @if ($status == 1)
                                <span class="badge bg-warning">Sedang Disewa</span>
                            @elseif ($status == 2)
                                <span class="badge bg-success">Sudah Dikembalikan</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body" style="overflow: auto">
                        <table class="table table-success w-100">
                            <tbody>
                                <tr>
                                    <th>No. Invoice</th>
                                    <td>{{ $detail->first()->payment->no_invoice }}</td>
                                </tr>
                                <tr>
                                    <th>Penyewa</th>
                                    <td><b>{{ $detail->first()->penyewa->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td>{{ $detail->first()->penyewa->telepon }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pengambilan</th>
                                    <td>
                                        {{ date('d M Y H:i', strtotime($detail->first()->starts)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($status == 1)
                                            <span>Sedang Disewa</span>
                                        @elseif ($status == 2)
                                            <span>Sudah Dikembalikan</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Alat</th>
                                    <th>Pengembalian</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <form action="{{ route('acc',['paymentId' => $detail->first()->payment->id]) }}" method="POST">
                            @method('PATCH')
                            @csrf --}}
                                @foreach ($detail as $item)
                                    <tr class="{{ $item->status == 3 ? 'table-danger' : '' }}">
                                        <td>
                                            {{ $loop->iteration }}
                                            {{-- @if ($status == 1)
                                        <input type="checkbox" name="order[]" class="form-check-input" value="{{ $item->id }}">
                                    @endif --}}
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between"></div>
                                            <a class="link-dark" href="{{ route('home.detail', ['id' => $item->alat->id]) }}"
                                                class="link">{{ $item->alat->nama_alat }}</a>
                                            <span class="badge bg-warning">{{ $item->alat->category->nama_kategori }}</span>
                                            <span class="badge bg-secondary">{{ $item->durasi }} Jam</span>
                                            @if ($item->status === 3)
                                                <span class="badge bg-danger">Ditolak</span>
                                            @elseif ($item->status === 2)
                                                <span class="badge bg-success">ACC</span>
                                            @endif
                                        </td>
                                        <td>{{ date('d M Y H:i', strtotime($item->ends)) }}</td>
                                        <td style="text-align: right"><b>@money($item->harga)</b></td>
                                    </tr>
                                @endforeach
                                <tr>

                                    <td></td>
                                    <td style="text-align: right"><b>Total</b></td>
                                    <td style="text-align: right"><b>@money($total)</b></td>
                                </tr>
                                {{-- </form> --}}
                            </tbody>
                        </table>
                        @if ($status == 1)
                            <form action="{{ route('admin.penyewaan.cancel', ['id' => $detail->first()->payment->id]) }}"
                                method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit"
                                    onclick="javascript: return confirm('Anda yakin akan membatalkan reservasi?');"
                                    class="btn btn-danger mb-3">Cancel Reservasi</button>
                            </form>
                            <form action="{{ route('selesai', ['id' => $detail->first()->payment->id]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success mb-4"
                                    onclick="javascript: return confirm('Pastikan alat sudah dikembalikan semua, jika yakin lanjutkan');">Sudah
                                    dikembalikan</button>
                            </form>
                        @endif



                    </div>
                    <div class="card-footer">
                        <div class="d-grid gap-2 d-md-block">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
