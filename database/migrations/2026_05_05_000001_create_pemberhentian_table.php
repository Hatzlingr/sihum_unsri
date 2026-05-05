<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemberhentian', function (Blueprint $table) {
            $table->id('id_pemberhentian');
            $table->foreignId('penempatan_id')->constrained('penempatan', 'id_penempatan')
                ->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa', 'id_mahasiswa')
                ->cascadeOnUpdate()->restrictOnDelete();
            $table->dateTime('tgl_ajuan');
            $table->date('tgl_berhenti');
            $table->text('alasan');
            $table->string('berkas_path')->nullable();
            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');
            $table->timestamps();

            $table->index(['mahasiswa_id', 'status']);
            $table->index(['penempatan_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemberhentian');
    }
};
