<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            // 1. Mengubah nama kolom
            $table->renameColumn('ipk', 'nilai_ijazah');
        });

        Schema::table('mahasiswas', function (Blueprint $table) {
            // 2. Mengubah tipe data agar bisa menampung nilai hingga 100.00
            $table->decimal('nilai_ijazah', 5, 2)->nullable()->change();
        });
    }

    /**
     * Kembalikan migrasi (Rollback).
     */
    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            // 1. Kembalikan nama kolom
            $table->renameColumn('nilai_ijazah', 'ipk');
        });

        Schema::table('mahasiswas', function (Blueprint $table) {
            // 2. Kembalikan ke presisi awal (asumsi nilai maksimal 4.00)
            $table->decimal('ipk', 3, 2)->nullable()->change();
        });
    }
};
