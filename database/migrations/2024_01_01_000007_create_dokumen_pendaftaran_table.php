<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_pendaftaran', function (Blueprint $table) {
            $table->id('id_dokumen');
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran', 'id_daftar')
                  ->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('tipe_dokumen', ['KTM', 'KIPK', 'KK', 'Lainnya']);
            $table->string('path_file', 255);
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_pendaftaran');
    }
};
