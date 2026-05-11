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
            //
            Schema::table('mahasiswas', function (Blueprint $table) {
                $table->text('catatan_admin')->nullable()->after('status_berkas');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            // Menghapus kolom jika kita melakukan rollback
            $table->dropColumn('catatan_admin');
            
        });
    }
};
