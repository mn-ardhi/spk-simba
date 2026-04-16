<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HasilSeleksi;
use App\Models\Periode;
use App\Services\SawCalculationService; // Memanggil mesin kalkulator

class AdminHasilSeleksi extends Component
{
    // Fungsi ini akan berjalan saat Admin menekan tombol "Hitung"
    public function hitungSAW(SawCalculationService $sawService)
    {
        $periodeAktif = Periode::where('is_aktif', true)->first();

        if (!$periodeAktif) {
            session()->flash('error', 'Kalkulasi gagal: Tidak ada periode aktif.');
            return;
        }

        // Jalankan mesin kalkulator
        $berhasil = $sawService->hitung($periodeAktif->id);

        if ($berhasil) {
            session()->flash('message', 'Kalkulasi SAW berhasil dijalankan! Peringkat telah diperbarui.');
        } else {
            session()->flash('error', 'Belum ada data mahasiswa dengan status VALID untuk dihitung pada periode ini.');
        }
    }

    public function render()
    {
        $periodeAktif = Periode::where('is_aktif', true)->first();
        $hasilSeleksi = [];

        if ($periodeAktif) {
            // Ambil data hasil seleksi dari database, urutkan dari Peringkat 1 ke bawah
            $hasilSeleksi = HasilSeleksi::with('mahasiswa')
                ->whereHas('mahasiswa', function ($q) use ($periodeAktif) {
                    $q->where('periode_id', $periodeAktif->id);
                })
                ->orderBy('peringkat', 'asc')
                ->get();
        }

        return view('livewire.admin-hasil-seleksi', [
            'hasilSeleksi' => $hasilSeleksi,
            'periode' => $periodeAktif
        ]);
    }
}
