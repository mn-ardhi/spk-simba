<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    // Wajib mendaftarkan c1 sampai c7 agar diizinkan masuk ke database
    protected $fillable = [
        'mahasiswa_id',
        'c1',
        'c2',
        'c3',
        'c4',
        'c5',
        'c6',
        'c7'
    ];

    // Relasi balik ke tabel Mahasiswa (Akan berguna saat perhitungan SAW nanti)
    public function up(): void
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained()->cascadeOnDelete();

            // Kolom nilai skala 1-100
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
}
