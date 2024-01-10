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
        $validated = $request->validate([
            'name' => 'required|max:255', 
            'no telephone' => 'required|min:12|max:255', 
            'tanggal_pengambilan' => 'required', 
            'nama alat' => 'required',
            'harga' => 'required', 
            'tanggal reservasi' => 'required',
        ]);
        

        $validated['name'] = Hash::make($validated['name']);
        $user = User::create($validated);

        return response()->json([
            'message' => 'Reservasi Berhasil, Silakan cek direservasi anda',
        ]);
    }
}
