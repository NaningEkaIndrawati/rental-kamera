<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use GuzzleHttp\Client;

class RentController extends Controller
{
    public function index() {
        $data = Payment::with(['penyewa','order'])->where('status', 1)->orderBy('id','DESC')->get();
        // dd($data);
        return view('admin.penyewaan.penyewaan',[
            'penyewaan' => $data,
        ]);
    }

    public function detail($id) {
        $detail = Order::with(['penyewa','payment','alat'])->where('payment_id', $id)->get();
        $payment = Payment::find($id);

        return view('admin.penyewaan.detail',[
            'detail' => $detail,
            'total' => $payment->total,
            'status' => $payment->status,
            'metode_pembayaran' => $payment->metode_pembayaran,
            'payment' => $payment
        ]);
    }

    public function destroy($id) {

    $payment = Payment::find($id);

    $noUser = $payment->penyewa->telepon;

    $client = new Client();

    $response = $client->request('POST', 'https://api.fonnte.com/send', [
    'form_params' => [
        'target' => $noUser,
        'message' => 'Reservasi Anda Dibatalkan hehe',
        'countryCode' => '62', //optional
    ],
    'headers' => [
        'Authorization' => 'vGSwXaF8K#TSBieycJGj',
    ],
        ]);

        $payment->delete();

        return redirect(route('penyewaan.index'));
    }

    public function riwayat() {
        $data = Payment::with(['penyewa','order'])->where('status', 2)->orderBy('id','DESC')->get();
        // dd($data);
        return view('admin.penyewaan.riwayat',[
            'penyewaan' => $data
        ]);
    }
}
