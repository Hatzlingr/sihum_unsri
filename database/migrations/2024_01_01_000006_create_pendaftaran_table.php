<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id('id_daftar');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa', 'id_mahasiswa')
                  ->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('hunian_id')->constrained('hunian', 'id_hunian')
                  ->cascadeOnUpdate()->restrictOnDelete();
            $table->dateTime('tgl_pengajuan');
            $table->enum('status_seleksi', ['Pending', 'Disetujui', 'Ditolak'])
                  ->default('Pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
