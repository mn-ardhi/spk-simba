<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mahasiswa extends Model
{
    use \App\Traits\UppercaseText; // Memastikan Nama & Prodi otomatis Kapital

    protected $fillable = [
        'user_id',
        'periode_id',
        'nim',
        'prodi',
        'semester',
        'tahun_masuk',
        'nilai_ijazah',
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
        'penghasilan_ortu',
        'status_pesantren',
        'kondisi_khusus',
        'setuju_pernyataan',
        'prestasi_non_akademik',
        'status_berkas',
        'file_berkas',
        'bukti_sertifikat',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'status_pesantren' => 'string',
        'bersedia_asrama' => 'string',
        'setuju_pernyataan' => 'boolean',
        'penghasilan_ortu' => 'integer',
        'nilai_ijazah' => 'decimal:2',
        'file_berkas' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }
}
