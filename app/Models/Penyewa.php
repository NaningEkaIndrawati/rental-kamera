<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'email',
        'password',
        'telepon',
        'alamat',
        'ktp',
    ];
    public function payment() {
        return $this->hasMany(Payment::class,'penyewa_id','id');
    }
    public function cart() {
        return $this->hasMany(Carts::class, 'penyewa_id', 'id');
    }

    public function reservasi() {
        return $this->hasMany(Order::class, 'penyewa_id', 'id');
    }

   
}
