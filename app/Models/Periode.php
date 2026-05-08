<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Periode extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'nama_periode',
        'tanggal_mulai',
        'tanggal_akhir',
        'is_aktif',
        'kuota_penerima',
    ];

    // Accessor untuk menghitung Sisa Hari
    public function getSisaHariAttribute()
    {
        $hariIni = Carbon::now();
        $selesai = Carbon::parse($this->tanggal_akhir);

        if ($hariIni->gt($selesai)) {
            return 0; // Sudah berakhir
        }

        return (int) $hariIni->diffInDays($selesai);
    }

    // Accessor untuk menentukan Status Otomatis (Real-time)
    public function getStatusOtomatisAttribute()
    {
        $hariIni = \Carbon\Carbon::now();
        
        // Konversi string database menjadi objek Carbon dengan batasan waktu yang presisi
        $mulai = \Carbon\Carbon::parse($this->tanggal_mulai)->startOfDay(); // 00:00:00
        $akhir = \Carbon\Carbon::parse($this->tanggal_akhir)->endOfDay();   // 23:59:59

        // Mengembalikan nilai true/false murni HANYA berdasarkan rentang tanggal
        return $hariIni->between($mulai, $akhir);
    }
}
