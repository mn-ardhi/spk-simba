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
    Schema::table('periodes', function (Blueprint $table) {
        // Menambahkan kolom integer setelah kolom nama_periode
        $table->integer('kuota_penerima')->default(0)->after('nama_periode');
    });
}

public function down(): void
{
    Schema::table('periodes', function (Blueprint $table) {
        // Membatalkan penambahan kolom jika migrasi di-rollback
        $table->dropColumn('kuota_penerima');
    });
}
};
