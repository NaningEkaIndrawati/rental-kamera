<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    use HasFactory;

    public function penyewa() {
        return $this->belongsTo(Penyewa::class, 'penyewa_id');
    }

    public function alat() {
        return $this->belongsTo(Alat::class, 'alat_id');
    }
}
