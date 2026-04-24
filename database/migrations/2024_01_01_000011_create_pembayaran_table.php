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
            $table->foreignId('pendaftaran_id')->nullable()->constrained('pendaftaran', 'id_daftar')
                  ->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('perpanjangan_id')->nullable()->constrained('perpanjangan', 'id_perpanjangan')
                  ->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('jenis_pembayaran', ['Awal', 'Sewa Lanjutan'])->default('Awal');
            $table->decimal('jumlah_bayar', 15, 2);
            // DIBIKIN NULLABLE: Biar sistem bisa buatin tagihannya dulu sebelum dibayar
            $table->string('bukti_transfer', 255)->nullable();
            $table->dateTime('tgl_bayar')->nullable();
            $table->enum('status_verifikasi', ['Belum Bayar', 'Menunggu', 'Sudah', 'Ditolak'])
                  ->default('Belum Bayar');
            $table->date('periode_mulai');
            $table->date('periode_selesai');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

        });
    }

    public function down(): void
    {

        Schema::dropIfExists('pembayaran');
    }
};
