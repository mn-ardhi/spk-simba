<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Mahasiswa;
use App\Models\Periode;
use App\Models\Penilaian; // Pastikan model ini dipanggil

class AdminPendaftar extends Component
{
    use WithPagination;

    public $search = '';

    // Properti khusus untuk Panel Modal
    public $isModalOpen = false;
    public $mhs_id, $nama_lengkap, $nim, $ipk;
    public $file_ktp, $file_kk, $file_kip;
    public $status_berkas;

    // Properti Kriteria Algoritma SAW (Skala 1-100)
    public $c1, $c2, $c3, $c4, $c5, $c6, $c7;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function bukaPanel($id)
    {
        $mhs = Mahasiswa::findOrFail($id);
        $this->mhs_id = $mhs->id;
        $this->nama_lengkap = $mhs->nama_lengkap;
        $this->nim = $mhs->nim;
        $this->ipk = $mhs->ipk;
        $this->status_berkas = $mhs->status_berkas;

        $berkas = json_decode($mhs->file_berkas, true);
        $this->file_ktp = $berkas['ktp'] ?? null;
        $this->file_kk = $berkas['kk'] ?? null;
        $this->file_kip = $berkas['kip'] ?? null;

        // Cek apakah mahasiswa ini sudah pernah dinilai sebelumnya
        $nilai = Penilaian::where('mahasiswa_id', $this->mhs_id)->first();
        if ($nilai) {
            $this->c1 = $nilai->c1;
            $this->c2 = $nilai->c2;
            $this->c3 = $nilai->c3;
            $this->c4 = $nilai->c4;
            $this->c5 = $nilai->c5;
            $this->c6 = $nilai->c6;
            $this->c7 = $nilai->c7;
        } else {
            // Kosongkan form nilai, namun C1 (Akademik) bisa kita bantu otomatiskan dari IPK
            $this->reset(['c2', 'c3', 'c4', 'c5', 'c6', 'c7']);
            $this->c1 = ($this->ipk >= 3.75) ? 100 : (($this->ipk >= 3.50) ? 80 : 60);
        }

        $this->isModalOpen = true;
    }

    public function tutupPanel()
    {
        $this->isModalOpen = false;
    }

    public function simpanValidasi()
    {
        $mhs = Mahasiswa::findOrFail($this->mhs_id);

        // 1. Simpan Keputusan Berkas
        $mhs->update(['status_berkas' => $this->status_berkas]);

        // 2. Jika dinyatakan VALID, simpan nilainya ke tabel Penilaian
        if ($this->status_berkas == 'valid') {
            Penilaian::updateOrCreate(
                ['mahasiswa_id' => $this->mhs_id],
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

        session()->flash('message', 'Validasi dan Penilaian berhasil disimpan.');
        $this->isModalOpen = false;
    }

    public function render()
    {
        $periodeAktif = Periode::latest()->first();

        if (!$periodeAktif) {
            return view('livewire.admin-pendaftar', ['mahasiswas' => collect([]), 'periode' => null]);
        }

        $mahasiswas = Mahasiswa::where('periode_id', $periodeAktif->id)
            ->where(function ($query) {
                $query->where('nama_lengkap', 'like', '%' . $this->search . '%')
                    ->orWhere('nim', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin-pendaftar', ['mahasiswas' => $mahasiswas, 'periode' => $periodeAktif])->layout('layouts.admin');
    }
}
