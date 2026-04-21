<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kamar', function (Blueprint $table) {
            $table->id('id_kamar');
            $table->foreignId('hunian_id')->constrained('hunian', 'id_hunian')
                  ->cascadeOnUpdate()->restrictOnDelete();
            $table->string('nomor_kamar', 10);
            $table->integer('lantai');
            $table->integer('kapasitas');
            $table->integer('terisi')->default(0);
            $table->decimal('harga_sewa', 15, 2);
            $table->enum('status', ['Tersedia', 'Penuh', 'Rusak'])->default('Tersedia');
            $table->timestamps();

            $table->unique(['hunian_id', 'nomor_kamar']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
};
