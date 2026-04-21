<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penempatan', function (Blueprint $table) {
            $table->id('id_penempatan');
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran', 'id_daftar')
                  ->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('kamar_id')->constrained('kamar', 'id_kamar')
                  ->cascadeOnUpdate()->restrictOnDelete();
            $table->date('tgl_masuk');
            $table->date('tgl_keluar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penempatan');
    }
};
