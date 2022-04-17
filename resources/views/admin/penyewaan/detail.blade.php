@extends('admin.main')
@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12 mt-4">
            <form action="{{ route('acc',['paymentId' => $detail->first()->payment->id]) }}" method="POST">
                @method('PATCH')
                @csrf
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('penyewaan.index') }}"><i class="fas fa-arrow-left"></i></a> Detail
                        @if ($status == 1)
                            <span class="badge bg-warning">Perlu Ditinjau</span>
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
                                <td><b>{{ $detail->first()->user->name }}</b> ({{ $detail->first()->user->email }})</td>
                            </tr>
                            <tr>
                                <th>Telepon</th>
                                <td>{{ $detail->first()->user->telepon }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pengambilan</th>
                                <td>{{ date('d M Y H:i', strtotime($detail->first()->starts)) }}</td>
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
                            @foreach($detail as $item)
                            <tr>
                                <td>{{ $loop->iteration }} <input type="checkbox" name="order[]" class="form-check-input" value="{{ $item->id }}"></td>
                                <td>
                                    <div class="d-flex justify-content-between"></div>
                                    {{ $item->alat->nama_alat }}
                                    <span class="badge bg-warning">{{ $item->alat->category->nama_kategori }}</span>
                                    <span class="badge bg-secondary">{{ $item->durasi }} Jam</span>
                                </td>
                                <td>{{ date('d M Y H:i', strtotime($item->ends)) }}</td>
                                <td style="text-align: right"><b>@money($item->harga)</b></td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="2"></td>
                                <td style="text-align: right"><b>Total</b></td>
                                <td style="text-align: right"><b>@money($total)</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="d-grid gap-2 d-md-block">
                        <button type="submit" class="btn btn-success">Acc</a>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
