<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_bayar');
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran', 'id_daftar')
                  ->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('jumlah_bayar', 15, 2);
            $table->string('bukti_transfer', 255);
            $table->dateTime('tgl_bayar');
            $table->enum('status_verifikasi', ['Belum', 'Sudah', 'Ditolak'])
                  ->default('Belum');
            $table->date('periode');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
