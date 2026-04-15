<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained()->cascadeOnDelete();

            // Wajib ada baris ini:
            $table->integer('c1')->nullable();
            $table->integer('c2')->nullable();
            $table->integer('c3')->nullable();
            $table->integer('c4')->nullable();
            $table->integer('c5')->nullable();
            $table->integer('c6')->nullable();
            $table->integer('c7')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
