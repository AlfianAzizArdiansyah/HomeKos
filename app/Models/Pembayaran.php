<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'nomor_kamar', 'penyewa_id', 'tanggal_bayar', 'jatuh_tempo', 'jumlah', 'status'];

    public function penyewa()
    {
        return $this->belongsTo(Penghuni::class);
    }
}
