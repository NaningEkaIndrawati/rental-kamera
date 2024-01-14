<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKamera extends Model
{
    protected $table = 'datakameras';
    protected $fillable = [
        'id',
        'kategori_id',
        'nama_alat',
        'harga24',
        'harga12',
        'harga6'
    ];

    // public function getStatusKetersediaanAttribute($value)
    // {
    //     $statusKetersediaan = [
    //         1 => 'tersedia',
    //         0 => 'tidak tersedia',
    //     ];

    //     return isset($statusKetersediaan[$value]) ? $statusKetersediaan[$value] : null;
    // }

    // // Method mutator untuk mengonversi nilai string menjadi nilai integer
    // public function setStatusKetersediaanAttribute($value)
    // {
    //     $statusKetersediaan = [
    //         'tersedia' => 1,
    //         'tidak tersedia' => 0,
    //     ];

    //     $this->attributes['status_ketersediaan'] = isset($statusKetersediaan[$value]) ? $statusKetersediaan[$value] : null;
    // }
}
