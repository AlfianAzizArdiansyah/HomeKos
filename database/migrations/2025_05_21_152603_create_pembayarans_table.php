<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penghuni_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_bayar')->nullable();
            $table->integer('jumlah');
            $table->date('jatuh_tempo')->nullable();
            $table->enum('status', ['Lunas', 'Proses','Belum Lunas']);
            $table->string('bukti_bayar')->nullable();
            $table->timestamps();
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
