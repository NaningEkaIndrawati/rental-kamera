<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penyewa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index() {
        return response()->json([
            'message' => 'Welcome new users'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:255',
            'telepon' => 'required',
            'alamat' => 'required|min:5|max:255',
            'ktp' => 'required|image',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated["ktp"] = $request->file("ktp")->store("foto_ktp");
        $penyewa = Penyewa::create($validated);

        return response()->json([
            'message' => 'Registrasi Berhasil, Silakan login untuk mulai menyewa',
            'user' => $penyewa
        ]);
    }
}
