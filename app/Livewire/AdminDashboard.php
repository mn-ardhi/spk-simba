<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mahasiswa;
use App\Models\Periode;
use App\Models\HasilSeleksi;

class AdminDashboard extends Component
{
    public function render()
    {
        $periodeAktif = Periode::latest()->first();

        // Siapkan variabel kosong
        $stats = ['total' => 0, 'valid' => 0, 'ditolak' => 0, 'menunggu' => 0];
        $topMahasiswa = [];

        // Jika ada periode aktif, hitung semua datanya
        if ($periodeAktif) {
            $stats['total'] = Mahasiswa::where('periode_id', $periodeAktif->id)->count();
            $stats['valid'] = Mahasiswa::where('periode_id', $periodeAktif->id)->where('status_berkas', 'valid')->count();
            $stats['ditolak'] = Mahasiswa::where('periode_id', $periodeAktif->id)->where('status_berkas', 'ditolak')->count();
            $stats['menunggu'] = Mahasiswa::where('periode_id', $periodeAktif->id)->where('status_berkas', 'menunggu')->count();

            // Ambil Top 5 Peringkat Teratas
            $topMahasiswa = HasilSeleksi::with('mahasiswa')
                ->whereHas('mahasiswa', function ($q) use ($periodeAktif) {
                    $q->where('periode_id', $periodeAktif->id);
                })
                ->orderBy('peringkat', 'asc')
                ->take(5)
                ->get();
        }

        return view('livewire.admin-dashboard', [
            'periode' => $periodeAktif,
            'stats' => $stats,
            'topMahasiswa' => $topMahasiswa
        ])->layout('layouts.admin');
    }
}
