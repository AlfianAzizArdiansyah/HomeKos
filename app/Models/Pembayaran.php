<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'nomor_kamar', 'penghuni_id', 'tanggal_bayar', 'jatuh_tempo', 'jumlah', 'status'];

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class);
    }

    public function details()
    {
        return $this->hasMany(PembayaranDetail::class, 'pembayaran_id');
    }

}
