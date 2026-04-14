<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    //
    protected $fillable = [
        'user_id',
        'periode_id',
        'nim',
        'prodi',
        'semester',
        'tahun_masuk',
        'ipk',
        'nik',
        'nisn',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'nama_ibu_kandung',
        'wa',
        'propinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'rt',
        'rw',
        'alamat',
        'kode_pos',
        'file_berkas',
        'status_berkas'
    ];
}
