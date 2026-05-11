<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mahasiswa;
use App\Models\HasilSeleksi;
use Illuminate\Support\Facades\Auth;

use Livewire\Attributes\Layout;

#[Layout('layouts.mahasiswa')] // <--- BERITAHU LIVEWIRE PAKAI LAYOUT MAHASISWA

class MahasiswaDashboard extends Component
{
    public $layout = 'layouts.mahasiswa';

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
        'mahasiswa' => $mahasiswa, // Variabel ini harus ditambahkan agar bisa dibaca di Blade
        'hasil' => $hasilSeleksi
    ]);
}
    
}
