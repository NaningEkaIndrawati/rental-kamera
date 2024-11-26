<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'penyewa_id',
        'alat_id',
        'payment_id',
        'durasi',
        'starts',
        'ends',
        'harga',
        'is_denda',
        'jumlah_denda',
        'tanggal_denda',
        'status_denda',
        'status', // Tambahkan ini jika kolom `status` memang ada
    ];

    public function penyewa() {
        return $this->belongsTo(Penyewa::class, 'penyewa_id');
    }

    public function alat() {
        return $this->belongsTo(Alat::class, 'alat_id');
    }

    public function payment() {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function notifikasi() {
        return $this->hasMany(Notifications::class, 'order_id', 'id');
    }
}
