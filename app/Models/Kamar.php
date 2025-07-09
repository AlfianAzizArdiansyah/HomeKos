<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;
    protected $fillable = ['nama_kamar', 'status', 'harga', 'fasilitas'];
    protected $casts = ['fasilitas' => 'array'];

    public function penghuni()
    {
        return $this->hasOne(Penghuni::class);
    }
}
