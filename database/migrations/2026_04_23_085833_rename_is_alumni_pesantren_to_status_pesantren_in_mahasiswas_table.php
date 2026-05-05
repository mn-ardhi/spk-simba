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
            // 1. Mengganti nama kolom
            $table->renameColumn('is_alumni_pesantren', 'status_pesantren');
        });

        Schema::table('mahasiswas', function (Blueprint $table) {
            // 2. Mengubah tipe data menjadi string (setelah di-rename)
            $table->string('status_pesantren')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->renameColumn('status_pesantren', 'is_alumni_pesantren');
        });

        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->boolean('is_alumni_pesantren')->default(0)->change();
        });
    }
};
