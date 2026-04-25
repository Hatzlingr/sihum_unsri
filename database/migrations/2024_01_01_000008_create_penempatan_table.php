<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            // Tambahan ini buat tracking riwayat kalau dia pindah kamar atau udah lulus/keluar
            $table->enum('status', ['Aktif', 'Pindah', 'Selesai', 'Keluar'])->default('Aktif');
            $table->timestamps();

            $table->index(['kamar_id', 'status']);
            $table->index(['status', 'tgl_masuk']);
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE penempatan ADD CONSTRAINT chk_penempatan_tanggal CHECK (tgl_keluar >= tgl_masuk)");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('penempatan');
    }
};
