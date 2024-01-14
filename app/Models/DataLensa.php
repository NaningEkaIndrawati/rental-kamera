<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataLensa extends Model
{
    protected $table = 'datalensas';
    protected $fillable = [
        'id',
        'kategori_id',
        'nama_alat',
        'harga24',
        'harga12',
        'harga6'
    ];

}
