<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Notifications extends Model
{
    use HasFactory;
    protected $fillable = [
        'notification_id',
        'penyewa_id',
        'order_id',
        'title',
        'message',
        'status',
    ];
    public function penyewa() {
        return $this->belongsTo(Penyewa::class,'penyewa_id');
    }
    public function order() {
        return $this->belongsTo(Order::class,'order_id');
    }
}
