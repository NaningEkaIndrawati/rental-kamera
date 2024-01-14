<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use Illuminate\Http\Request;

class DatalensaController extends Controller
{
    public function index()
    {
        $dataLensas = Alat::with('category')->where('kategori_id', 2)->get();
        return response()->json(['data' => $dataLensas, 'message' => 'Data Lensa retrieved successfully']);
    }
}
