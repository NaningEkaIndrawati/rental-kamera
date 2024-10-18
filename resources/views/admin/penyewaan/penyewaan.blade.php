@extends('admin.main')
@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="card shadow">
                <div class="card-body" style="overflow: auto">
                    <table id="dataTable">
                        <thead>
                            <tr>
                                <th>No. Invoice</th>
                                <th>Tanggal Reservasi</th>
                                <th>Penyewa</th>
                                <th>Total</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penyewaan as $item)
                            {{-- <p>{{$item->order->first->status->status}}</p> --}}
                                <tr>
                                    <td> {{ $item->no_invoice }}
                                        @if ($item->order->first->status == "1")
                                            <span class="badge bg-warning">Sedang Disewa</span>
                                        @elseif ($item->order->first->status == "2")
                                            <span class="badge bg-info">Selesai Disewa</span>
                                        @endif
                                    </td>
                                    <td>{{ date('D, d M Y H:i', strtotime($item->created_at)) }}</td>
                                    <td><b>{{ $item->penyewa->nama }}</b> ({{ $item->penyewa->telepon }})</td>
                                    <td>@money($item->total) &nbsp; <span class="badge bg-secondary">{{ $item->order->count() }} Alat</span></td>
                                    <td>
                                        <a href="{{ route('penyewaan.detail',['id' => $item->id]) }}" class="btn btn-outline-primary position-relative">
                                            Detail
                                            @if ($item->bukti != null && $item->status != 4 && $item->status != 3)
                                            <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                                <span class="visually-hidden">bukti bayar</span>
                                            </span>
                                            @endif
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-body">
                    @include('partials.kalender')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
