<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengelola', function (Blueprint $table) {
            $table->id('id_pengelola');
            $table->foreignId('user_id')->constrained('users')
                  ->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->string('no_hp', 15)->nullable();
            $table->foreignId('hunian_id')->nullable()
                  ->constrained('hunian', 'id_hunian')
                  ->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengelola');
    }
};
