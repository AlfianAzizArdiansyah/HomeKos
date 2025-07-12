<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayaran_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembayaran_id')->constrained()->onDelete('cascade');
            $table->string('bulan'); // contoh: "Juli 2025"
            $table->date('tanggal_bayar');
            $table->integer('jumlah');
            $table->string('bukti_bayar')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_details');
    }
};
