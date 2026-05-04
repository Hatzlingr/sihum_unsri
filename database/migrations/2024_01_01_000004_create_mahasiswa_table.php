<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id('id_mahasiswa');
            $table->foreignId('user_id')->constrained('users')
                  ->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('nim', 20)->unique();
            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->string('prodi', 100);
            $table->boolean('status_kipk')->default(false);
            $table->string('no_hp', 15)->nullable();
            $table->string('foto_profil', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
