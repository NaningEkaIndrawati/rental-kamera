<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function penyewa() {
        return $this->belongsTo(Penyewa::class,'penyewa_id');
    }

    public function alat() {
        return $this->belongsTo(Alat::class,'alat_id');
    }

    public function payment() {
        return $this->belongsTo(Payment::class,'payment_id');
    }
    public function notifikasi() {
        return $this->hasMany(Notifications::class, 'order_id', 'id');
    }
}
