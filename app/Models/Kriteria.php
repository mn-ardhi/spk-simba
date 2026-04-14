<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    // Izin kolom wajib di sini
    protected $fillable = ['kode', 'nama_kriteria', 'atribut', 'bobot'];
}
