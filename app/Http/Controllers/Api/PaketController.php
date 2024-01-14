<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = Alat::with('category')->where('kategori_id', 4)->get();
        return response()->json(['data' => $pakets, 'message' => 'Data Camera retrieved successfully']);
    }
}

