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
            $table->bigInteger('penghasilan_ortu')->nullable()->after('wa');
            $table->boolean('is_alumni_pesantren')->default(false)->after('penghasilan_ortu');
            $table->boolean('bersedia_asrama')->default(false)->after('is_alumni_pesantren');
            $table->boolean('setuju_pernyataan')->default(false)->after('kode_pos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            //
        });
    }
};
