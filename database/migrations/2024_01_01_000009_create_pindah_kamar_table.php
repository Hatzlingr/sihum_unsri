<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pindah_kamar', function (Blueprint $table) {
            $table->id('id_pindah');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa', 'id_mahasiswa');

            // Tambahan untuk fitur tukar kamar
            $table->enum('jenis_pindah', ['Reguler', 'Tukar'])->default('Reguler');
            $table->foreignId('partner_tukar_id')->nullable()->constrained('mahasiswa', 'id_mahasiswa');
            $table->enum('status_partner', ['Menunggu', 'Setuju', 'Ditolak'])->nullable();

            $table->foreignId('kamar_asal_id')->constrained('kamar', 'id_kamar');
            $table->foreignId('kamar_tujuan_id')->constrained('kamar', 'id_kamar');
            $table->text('alasan');
            $table->enum('status_approval', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');
            $table->timestamps();
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE pindah_kamar ADD CONSTRAINT chk_pindah_kamar_logic CHECK ((jenis_pindah = 'Reguler' AND partner_tukar_id IS NULL AND status_partner IS NULL) OR (jenis_pindah = 'Tukar' AND partner_tukar_id IS NOT NULL AND status_partner IS NOT NULL AND partner_tukar_id <> mahasiswa_id))");
            DB::statement("ALTER TABLE pindah_kamar ADD CONSTRAINT chk_pindah_kamar_room_diff CHECK (kamar_asal_id <> kamar_tujuan_id)");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pindah_kamar');
    }
};
