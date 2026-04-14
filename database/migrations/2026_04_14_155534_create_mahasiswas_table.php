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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();

            // 1. Relasi Inti Sistem
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('periode_id')->constrained()->cascadeOnDelete(); // Wajib ada

            // 2. Data Akademik
            $table->string('nim')->unique();
            $table->string('prodi')->nullable();
            $table->integer('semester')->nullable();
            $table->year('tahun_masuk')->nullable();
            $table->decimal('ipk', 3, 2)->nullable();

            // 3. Data Personal
            $table->string('nik', 16)->unique()->nullable();
            $table->string('nisn', 10)->unique()->nullable();
            $table->string('nama_lengkap'); // Dibuat tidak nullable karena penting
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('nama_ibu_kandung')->nullable();
            $table->string('wa')->nullable();

            // 4. Data Domisili & Alamat
            $table->string('propinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('rt', 3)->nullable();
            $table->string('rw', 3)->nullable();
            $table->text('alamat')->nullable();
            $table->string('kode_pos', 5)->nullable();

            // 5. Data Operasional SPK Beasiswa
            $table->string('file_berkas')->nullable();
            $table->enum('status_berkas', ['menunggu', 'valid', 'tolak'])->default('menunggu');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
