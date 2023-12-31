<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;

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
        ]);
    }

    public function destroy($id) {
        $payment = Payment::find($id);

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
