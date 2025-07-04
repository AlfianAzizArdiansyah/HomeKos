<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    use HasFactory;
     protected $fillable = ['nama', 'no_hp', 'nik', 'foto_ktp', 'kamar_id', 'status'];

    public function kamar() {
        return $this->belongsTo(Kamar::class);
    }

    public function pembayarans() {
        return $this->hasMany(Pembayaran::class);
    }
}
