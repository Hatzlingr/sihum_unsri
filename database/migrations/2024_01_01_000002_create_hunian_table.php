<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hunian', function (Blueprint $table) {
            $table->id('id_hunian');
            $table->string('nama_hunian', 100);
            $table->text('lokasi');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe', ['Rusunawa', 'Asrama', 'Apartemen']);
            $table->boolean('khusus_kipk')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hunian');
    }
};
