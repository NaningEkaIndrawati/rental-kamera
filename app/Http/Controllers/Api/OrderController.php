<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request){

        $request->validate([
            "id_alat" => "required",
            "waktu_sewa" => "required",
            "start_date" => "required",
            "start_time" => "required",
        ]);

        $alat = Alat::where('id', $request->id_alat)->first();

        if(!$alat){
            return response()->json(["message" => "Alat Tidak Ditemukan"]);
        }

        if($request->waktu_sewa == "6"){
            $harga = $alat->harga6;
        }else if($request->waktu_sewa == "12"){
            $harga = $alat->harga12;
        }else{
            $harga = $alat->harga24;
        }

        $pembayaran = new Payment();

        $pembayaran->no_invoice = Auth::id()."/".Carbon::now()->timestamp;
        $pembayaran->penyewa_id = Auth::id();
        $pembayaran->total = $harga;
        $pembayaran->save();

        $order = Order::create([
                'alat_id' => $alat->id,
                'penyewa_id' => Auth::id(),
                'payment_id' => $pembayaran->id,
                'durasi' => $request->waktu_sewa,
                'starts' => date('Y-m-d H:i', strtotime($request['start_date'].$request['start_time'])),
                'ends' => date('Y-m-d H:i', strtotime($request['start_date'].$request['start_time']."+" . $request->waktu_sewa ." hours")),
                'harga' => $harga,
        ]);

        return response()->json(["message" => "Berhasil Reservasi","Order" => $order]);
    }
}
