<?php

namespace App\Services;

use App\Models\Mahasiswa;
use App\Models\Penilaian;
use App\Models\HasilSeleksi;

class SawCalculationService
{
    // Konfigurasi Bobot dan Sifat Kriteria berdasarkan Pedoman KIP
    private $kriteria = [
        'c1' => ['bobot' => 0.20, 'sifat' => 'benefit'], // Akademik
        'c2' => ['bobot' => 0.10, 'sifat' => 'benefit'], // Non-Akademik
        'c3' => ['bobot' => 0.25, 'sifat' => 'cost'],    // Penghasilan Ortu (Cost: Makin miskin makin besar skornya)
        'c4' => ['bobot' => 0.15, 'sifat' => 'benefit'], // Kesejahteraan
        'c5' => ['bobot' => 0.10, 'sifat' => 'benefit'], // Kondisi Khusus
        'c6' => ['bobot' => 0.10, 'sifat' => 'benefit'], // Tanggungan Keluarga
        'c7' => ['bobot' => 0.10, 'sifat' => 'benefit'], // Kepesantrenan
    ];

    public function hitung($periodeId)
    {
        // 1. Ambil data nilai HANYA untuk mahasiswa yang Valid di periode aktif
        $penilaians = Penilaian::whereHas('mahasiswa', function ($q) use ($periodeId) {
            $q->where('periode_id', $periodeId)->where('status_berkas', 'valid');
        })->get();

        if ($penilaians->isEmpty()) {
            return false; // Berhenti jika tidak ada data yang bisa dihitung
        }

        // 2. Tahap Mencari Nilai Max (untuk Benefit) & Min (untuk Cost) dari seluruh pendaftar
        $maxMin = [];
        $kolomC = ['c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7'];

        foreach ($kolomC as $c) {
            if ($this->kriteria[$c]['sifat'] == 'benefit') {
                $maxMin[$c] = $penilaians->max($c);
            } else {
                $maxMin[$c] = $penilaians->min($c);
            }
        }

        // 3. Tahap Normalisasi Matriks (R) & Perhitungan Nilai Akhir (V)
        $kumpulanHasil = [];

        foreach ($penilaians as $nilai) {
            $skorTotal = 0;

            foreach ($kolomC as $c) {
                $x = $nilai->$c;
                $pembagi = $maxMin[$c];

                // Proses Normalisasi
                $normalisasi = 0;
                if ($pembagi != 0 && $x != null) {
                    if ($this->kriteria[$c]['sifat'] == 'benefit') {
                        $normalisasi = $x / $pembagi;
                    } else { // Jika Cost
                        $normalisasi = $pembagi / $x;
                    }
                }

                // Kalikan hasil normalisasi dengan Bobot Kriteria
                $skorTotal += $normalisasi * $this->kriteria[$c]['bobot'];
            }

            // Simpan sementara skor setiap mahasiswa ke dalam array
            $kumpulanHasil[] = [
                'mahasiswa_id' => $nilai->mahasiswa_id,
                'skor_akhir'   => $skorTotal,
            ];
        }

        // 4. Mengurutkan Data (Ranking) dari Skor Tertinggi ke Terendah
        usort($kumpulanHasil, function ($a, $b) {
            return $b['skor_akhir'] <=> $a['skor_akhir'];
        });

        // 5. Simpan Hasil Peringkat ke Database
        // Hapus data hasil lama di periode ini jika Admin menekan tombol "Hitung Ulang"
        HasilSeleksi::whereHas('mahasiswa', function ($q) use ($periodeId) {
            $q->where('periode_id', $periodeId);
        })->delete();

        // Masukkan data baru beserta nomor peringkatnya
        $peringkat = 1;
        foreach ($kumpulanHasil as $hasil) {
            HasilSeleksi::create([
                'mahasiswa_id' => $hasil['mahasiswa_id'],
                'skor_akhir'   => round($hasil['skor_akhir'], 4),
                'peringkat'    => $peringkat++
            ]);
        }

        return true;
    }
}