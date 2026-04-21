<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pindah_kamar', function (Blueprint $table) {
            $table->id('id_pindah');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa', 'id_mahasiswa')
                  ->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('kamar_asal_id')->constrained('kamar', 'id_kamar')
                  ->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('kamar_tujuan_id')->constrained('kamar', 'id_kamar')
                  ->cascadeOnUpdate()->restrictOnDelete();
            $table->text('alasan');
            $table->enum('status_approval', ['Pending', 'Disetujui', 'Ditolak'])
                  ->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pindah_kamar');
    }
};
