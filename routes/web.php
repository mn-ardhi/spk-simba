<?php

use Illuminate\Support\Facades\Route;
use App\Models\Periode;

Route::get('/', function () {
    $periodeAktif = Periode::where('is_aktif', true)->first();
    return view('welcome', compact('periodeAktif'));
})->name('home');

// =========================================================
// 1. POLISI LALU LINTAS (Gerbang Utama Setelah Login)
// =========================================================
// Biarkan ini menggunakan '/dashboard' agar sinkron dengan default redirect login Laravel
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    // Jika yang login adalah admin, lempar ke dashboard admin
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    
    // Jika mahasiswa, lempar ke dashboard mahasiswa (Perbaikan nama route di sini)
    return redirect()->route('mahasiswa.dashboard'); 
})->name('dashboard'); // Ubah nama route ini jadi 'dashboard' agar lebih logis

// =========================================================
// 2. RUTE KHUSUS MAHASISWA
// =========================================================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mahasiswa', \App\Livewire\MahasiswaDashboard::class)->name('mahasiswa.dashboard');
    Route::get('/pendaftaran', \App\Livewire\FormPendaftaran::class)->name('pendaftaran');
});

// =========================================================
// 3. RUTE KHUSUS EKSEKUTIF REKTORAT (ADMIN)
// =========================================================
Route::middleware(['auth', 'admin'])->group(function () {
    // UBAH URI DARI '/dashboard' MENJADI '/admin/dashboard'
    // Tujuannya agar tidak bentrok dengan Polisi Lalu Lintas di atas
    Route::get('/admin/dashboard', \App\Livewire\AdminDashboard::class)->name('admin.dashboard');
    
    Route::get('/kandidat', \App\Livewire\AdminPendaftar::class)->name('admin.pendaftar');
    Route::get('/kandidat/penilaian/{id}', \App\Livewire\AdminPenilaian::class)->name('admin.penilaian');
    Route::get('/hasil-seleksi', \App\Livewire\AdminHasilSeleksi::class)->name('admin.hasil');
    Route::get('/master-periode', \App\Livewire\MasterPeriode::class)->name('master.periode');
});

require __DIR__ . '/settings.php';