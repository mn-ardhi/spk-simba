<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            // 1. Rename kolom
            $table->renameColumn('bersedia_asrama', 'kondisi_keluarga');
        });

        Schema::table('mahasiswas', function (Blueprint $table) {
            // 2. Ubah tipe data menjadi string
            $table->string('kondisi_keluarga')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->renameColumn('kondisi_keluarga', 'bersedia_asrama');
            $table->boolean('bersedia_asrama')->default(0)->change();
        });
    }
};
