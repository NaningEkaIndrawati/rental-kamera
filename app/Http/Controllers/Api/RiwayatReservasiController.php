<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatReservasiController extends Controller
{
    public function index() {

        $user = auth()->user();

        $data = Payment::with(['penyewa','orderApi','orderApi.alat'])->where('penyewa_id', $user->id)->orderBy('id','DESC')->get();

        return response()->json($data);
    }
}
