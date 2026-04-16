<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

// 1. Rute Default / Mahasiswa (Bisa diakses siapa saja yang sudah login)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', \App\Livewire\MahasiswaDashboard::class)->name('dashboard');
    Route::get('/pendaftaran', \App\Livewire\FormPendaftaran::class)->name('pendaftaran');
});

// 2. Rute Khusus Eksekutif Rektorat (Digembok oleh Middleware 'admin')
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-dashboard', \App\Livewire\AdminDashboard::class)->name('admin.dashboard');
    Route::get('/admin-pendaftar', \App\Livewire\AdminPendaftar::class)->name('admin.pendaftar');
    Route::get('/admin-hasil-seleksi', \App\Livewire\AdminHasilSeleksi::class)->name('admin.hasil');
});

require __DIR__ . '/settings.php';
