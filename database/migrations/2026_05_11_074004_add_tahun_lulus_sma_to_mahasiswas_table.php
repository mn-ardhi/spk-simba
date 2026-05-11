<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            // Kita gunakan tipe data string dengan panjang 4 karakter (misal: "2024").
            // nullable() wajib ditambahkan agar data mahasiswa lama tidak error karena kolom ini kosong.
            // after() digunakan agar posisi kolom di database rapi, ditaruh setelah tahun_masuk.
            $table->string('tahun_lulus_sma', 4)->nullable()->after('tahun_masuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            // Logika rollback jika kita ingin membatalkan migrasi
            $table->dropColumn('tahun_lulus_sma');
        });
    }
};