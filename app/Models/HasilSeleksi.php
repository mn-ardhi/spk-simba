<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilSeleksi extends Model
{
    use HasFactory;

    // Ini adalah kode izin akses agar sistem perhitungan bisa menyimpan nilai
    protected $fillable = ['mahasiswa_id', 'skor_akhir', 'peringkat'];

    // Ini adalah jembatan penghubung antara nilai dan data diri mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
