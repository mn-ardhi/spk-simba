<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mahasiswa;
use App\Models\Penilaian; // Jangan lupa import model Penilaian
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')] // <--- BERITAHU LIVEWIRE PAKAI LAYOUT ADMIN

class AdminPenilaian extends Component
{
    public $mhs;
    public $id_mhs;

    // Properti Form
    public $status_berkas;
    public $c1, $c2, $c3, $c4, $c5, $c6, $c7;

    public function mount($id)
    {
        $this->id_mhs = $id;
        $this->mhs = Mahasiswa::findOrFail($id);

        // Ambil data penilaian jika sudah ada sebelumnya di database
        $penilaian = Penilaian::where('mahasiswa_id', $id)->first();

        // Inisialisasi data status dari Mahasiswa
        $this->status_berkas = $this->mhs->status_berkas ?? 'menunggu';
        
        // Inisialisasi data nilai dari model Penilaian (bukan dari model Mahasiswa)
        $this->c1 = $penilaian->c1 ?? null;
        $this->c2 = $penilaian->c2 ?? null;
        $this->c3 = $penilaian->c3 ?? null;
        $this->c4 = $penilaian->c4 ?? null;
        $this->c5 = $penilaian->c5 ?? null;
        $this->c6 = $penilaian->c6 ?? null;
        $this->c7 = $penilaian->c7 ?? null;
    }

    public function simpanPenilaian()
    {
        $rules = [
            'status_berkas' => 'required',
        ];

        // Validasi kriteria hanya jika status berkas valid
        if ($this->status_berkas === 'valid') {
            $rules = array_merge($rules, [
                'c1' => 'required|numeric|min:0',
                'c2' => 'required|numeric',       
                'c3' => 'required|numeric|min:0', 
                'c4' => 'required|numeric',       
                'c5' => 'required|numeric',       
                'c6' => 'required|numeric',       
                'c7' => 'required|numeric',       
            ]);
        }

        $this->validate($rules);

        // 1. Update status berkas di tabel Mahasiswa
        $this->mhs->update([
            'status_berkas' => $this->status_berkas,
        ]);

        // 2. Simpan atau Update nilai di tabel Penilaian
        // Kita gunakan updateOrCreate agar jika data belum ada maka dibuat (Insert), 
        // jika sudah ada maka diperbarui (Update).
        if ($this->status_berkas === 'valid') {
            \App\Models\Penilaian::updateOrCreate(
            ['mahasiswa_id' => $this->id_mhs], 
            [
                'c1' => $this->c1,
                'c2' => $this->c2,
                'c3' => $this->c3,
                'c4' => $this->c4,
                'c5' => $this->c5,
                'c6' => $this->c6,
                'c7' => $this->c7,
            ] 
        );
        }
        // Redirect jika sukses
        session()->flash('message', 'Status dan Penilaian berhasil diperbarui.');
        return redirect()->route('admin.pendaftar');
    }

    public function render()
    {
        return view('livewire.admin-penilaian')
        ;}
}