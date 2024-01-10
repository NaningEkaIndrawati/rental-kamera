<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all(); 

        return response()->json([
            'categories' => $categories]);
    }
    public function store(Request $request) {
        $this->validate($request, [
            'nama' => 'required'
        ]);

        $kategori = new Category();
        $kategori->nama_kategori = $request['nama'];
        $kategori->save();
        return response()->json([
            'message' => 'Kategori berhasil ditambah!'
        ]);
    }

}    