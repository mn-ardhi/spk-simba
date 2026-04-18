<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HasilSeleksi;
use App\Models\Periode;
use App\Services\SawCalculationService; // Memanggil mesin kalkulator
use Barryvdh\DomPDF\Facade\Pdf; // memanggil fungsi cetak laporan pdf

class AdminHasilSeleksi extends Component
{
    // Fungsi ini akan berjalan saat Admin menekan tombol "Hitung"
    public function hitungSAW(SawCalculationService $sawService)
    {
        $periodeAktif = Periode::latest()->first();

        if (!$periodeAktif) {
            session()->flash('error', 'Kalkulasi gagal: Belum ada data periode di database.');
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
        $periodeAktif = Periode::latest()->first();
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
        ])->layout('layouts.admin');
    }
    public function cetakPDF()
    {
        $periodeAktif = Periode::where('is_aktif', true)->first();

        if (!$periodeAktif) return;

        // Ambil data hasil seleksi terbaru
        $data = HasilSeleksi::with('mahasiswa')
            ->whereHas('mahasiswa', function ($q) use ($periodeAktif) {
                $q->where('periode_id', $periodeAktif->id);
            })
            ->orderBy('peringkat', 'asc')
            ->get();

        // Siapkan data untuk dikirim ke view PDF
        $pdfContent = [
            'title' => 'Laporan Hasil Seleksi Beasiswa KIP Kuliah',
            'date' => date('d/m/Y'),
            'periode' => $periodeAktif->nama_periode,
            'hasil' => $data
        ];

        // Load view khusus PDF dan download
        $pdf = Pdf::loadView('reports.hasil-seleksi-pdf', $pdfContent);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Laporan_KIP_' . $periodeAktif->nama_periode . '.pdf');
    }
}
