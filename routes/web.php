<?php

use Illuminate\Support\Facades\Route;
use App\Models\Periode;

Route::get('/', function () {
    $periodeAktif = Periode::where('is_aktif', true)->first();
    return view('welcome', compact('periodeAktif'));
})->name('home');


// 1. POLISI LALU LINTAS (Gerbang Utama Setelah Login)
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    // Jika yang login adalah admin, arahkan ke dasbor admin
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    // Jika bukan admin (mahasiswa), arahkan ke dasbor mahasiswa
    return redirect()->route('mahasiswa.dashboard');
})->name('dashboard');

// 2. RUTE KHUSUS MAHASISWA
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mahasiswa-dashboard', \App\Livewire\MahasiswaDashboard::class)->name('mahasiswa.dashboard');
    Route::get('/pendaftaran', \App\Livewire\FormPendaftaran::class)->name('pendaftaran');
});

// 3. RUTE KHUSUS EKSEKUTIF REKTORAT (ADMIN)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-dashboard', \App\Livewire\AdminDashboard::class)->name('admin.dashboard');
    Route::get('/admin-pendaftar', \App\Livewire\AdminPendaftar::class)->name('admin.pendaftar');

    // RUTE BARU: Halaman khusus penilaian mahasiswa berdasarkan ID
    Route::get('/admin-pendaftar/penilaian/{id}', \App\Livewire\AdminPenilaian::class)->name('admin.penilaian');

    Route::get('/admin-hasil-seleksi', \App\Livewire\AdminHasilSeleksi::class)->name('admin.hasil');
});

require __DIR__ . '/settings.php';
