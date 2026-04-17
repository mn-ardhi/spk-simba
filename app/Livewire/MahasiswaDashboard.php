<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mahasiswa;
use App\Models\HasilSeleksi;
use Illuminate\Support\Facades\Auth;

class MahasiswaDashboard extends Component
{
    public function render()
    {
        // Mencari data pendaftaran berdasarkan ID user yang sedang login
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();
        $hasilSeleksi = null;

        // Jika mahasiswa sudah divalidasi, cari nilai akhirnya
        if ($mahasiswa && $mahasiswa->status_berkas == 'valid') {
            $hasilSeleksi = HasilSeleksi::where('mahasiswa_id', $mahasiswa->id)->first();
        }

        return view('livewire.mahasiswa-dashboard', [
            'mahasiswa' => $mahasiswa,
            'hasil' => $hasilSeleksi
        ])->layout('layouts.mahasiswa');
    }
}
