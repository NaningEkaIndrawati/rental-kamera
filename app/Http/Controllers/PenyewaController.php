<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenyewaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penyewa = Penyewa::all();
        return view('penyewa.index', compact('penyewa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penyewa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:penyewas,email',
            'password' => 'required|string|min:8',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
            'ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048', // File KTP harus berupa gambar
        ]);

        // Simpan file gambar
        $path = $request->file('ktp')->store('upload_ktp');
        // File akan disimpan di storage/app/public/ktp

        // Simpan data penyewa
        Penyewa::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'ktp' => $path, // Simpan path file
        ]);

        return redirect()->route('penyewa.index')->with('success', 'Data penyewa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penyewa $penyewa)
    {
        return view('penyewa.show', compact('penyewa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penyewa $penyewa)
    {
        return view('penyewa.edit', compact('penyewa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penyewa $penyewa)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:penyewas,email,' . $penyewa->id,
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
            'ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // File KTP opsional saat update
        ]);

        // Perbarui file gambar jika diunggah
        if ($request->hasFile('ktp')) {
            // Hapus file lama
            if ($penyewa->ktp && Storage::exists($penyewa->ktp)) {
                Storage::delete($penyewa->ktp);
            }

            // Simpan file baru
            $path = $request->file('ktp')->store('public/ktp');
            $penyewa->ktp = $path;
        }

        // Perbarui data penyewa
        $penyewa->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('penyewa.index')->with('success', 'Data penyewa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penyewa $penyewa)
    {
        // Hapus file KTP jika ada
        if ($penyewa->ktp && Storage::exists($penyewa->ktp)) {
            Storage::delete($penyewa->ktp);
        }

        $penyewa->delete();

        return redirect()->route('penyewa.index')->with('success', 'Data penyewa berhasil dihapus.');
    }

    /**
     * Get the file URL for displaying on the web.
     */
    public function showFile(Penyewa $penyewa)
    {
        if ($penyewa->ktp && Storage::exists($penyewa->ktp)) {
            return response()->file(storage_path('app/' . $penyewa->ktp));
        }

        abort(404, 'File not found.');
    }
}
