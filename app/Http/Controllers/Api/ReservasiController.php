<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ReservasiController extends Controller
{
    public function index() {
        return response()->json([
            'message' => 'Reservasi Berhasil'
        ]);
    }

    public function store(Request $request)
    {
        // $validated =


        // $cart = Carts::where('user_id', Auth::id())->get();
        // $pembayaran = new Payment();

        // $pembayaran->no_invoice = Auth::id()."/".Carbon::now()->timestamp;
        // $pembayaran->user_id = Auth::id();
        // $pembayaran->total = $cart->sum('harga');
        // $pembayaran->save();

        // foreach($cart as $c) {
        //     Order::create([
        //         'alat_id' => $c->alat_id,
        //         'user_id' => $c->user_id,
        //         'payment_id' => Payment::where('user_id',Auth::id())->orderBy('id','desc')->first()->id,
        //         'durasi' => $c->durasi,
        //         'starts' => date('Y-m-d H:i', strtotime($request['start_date'].$request['start_time'])),
        //         'ends' => date('Y-m-d H:i', strtotime($request['start_date'].$request['start_time']."+".$c->durasi." hours")),
        //         'harga' => $c->harga,
        //     ]);
        //     $c->delete();
        // }

        // return response()->json([
        //     'message' => 'Reservasi Berhasil, Silakan cek direservasi anda',
        // ]);
    }
}
