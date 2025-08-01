<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $fillable = ['penghuni_id', 'tanggal_bayar', 'jatuh_tempo', 'jumlah', 'status', 'bukti_bayar'];

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class);
    }

    public function kamar()
    {
        return $this->hasOneThrough(Kamar::class, Penghuni::class, 'id', 'id', 'penghuni_id', 'kamar_id');
    }
}
