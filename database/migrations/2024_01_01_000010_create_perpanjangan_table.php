<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('perpanjangan', function (Blueprint $table) {
        $table->id('id_perpanjangan');
        $table->foreignId('penempatan_id')->constrained('penempatan', 'id_penempatan')->cascadeOnUpdate()->restrictOnDelete();
        $table->foreignId('mahasiswa_id')->constrained('mahasiswa', 'id_mahasiswa')->cascadeOnUpdate()->restrictOnDelete();
        
        // Biarkan jadi integer biasa tanpa default, batasan 3-11 bulan diatur di Controller
        $table->integer('durasi_bulan'); 
        
        $table->dateTime('tgl_ajuan');
        $table->date('tgl_keluar_baru'); 
        $table->enum('status', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('perpanjangan');
    }
};
