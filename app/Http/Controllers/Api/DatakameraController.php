<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alat;
// use App\Models\
use Illuminate\Http\Request;

class DatakameraController extends Controller
{
    public function index()
    {
        $dataKameras = Alat::with('category')->where('kategori_id', 1)->get();
        return response()->json(['data' => $dataKameras, 'message' => 'Data Camera retrieved successfully']);
    }

}

