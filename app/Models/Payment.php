<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function penyewa() {
        return $this->belongsTo(Penyewa::class, 'penyewa_id');
    }

    public function order() {
        return $this->hasMany(Order::class, 'payment_id', 'id');
    }

    public function orderApi() {
        return $this->hasOne(Order::class, 'payment_id', 'id');
    }
}
