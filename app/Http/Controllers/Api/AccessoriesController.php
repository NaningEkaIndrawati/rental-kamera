<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use Illuminate\Http\Request;

class AccessoriesController extends Controller
{
    public function index()
    {
        $accessoriess = Alat::with('category')->where('kategori_id', 3)->get();
        return response()->json(['data' => $accessoriess, 'message' => 'Data Camera retrieved successfully']);
    }
}
