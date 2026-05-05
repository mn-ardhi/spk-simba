<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mahasiswa;

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

        // Inisialisasi data dari database ke form
        $this->status_berkas = $this->mhs->status_berkas ?? 'menunggu';
        $this->c1 = $this->mhs->c1;
        $this->c2 = $this->mhs->c2;
        $this->c3 = $this->mhs->c3;
        $this->c4 = $this->mhs->c4;
        $this->c5 = $this->mhs->c5;
        $this->c6 = $this->mhs->c6;
        $this->c7 = $this->mhs->c7;
    }

    // Pastikan bagian fungsi simpanPenilaian diperbarui seperti ini:
    public function simpanPenilaian()
    {
        $rules = [
            'status_berkas' => 'required',
        ];

        if ($this->status_berkas === 'valid') {
            $rules = array_merge($rules, [
                'c1' => 'required|numeric|min:0', // IPK atau Rapor
                'c2' => 'required|numeric',        // Prestasi (Skor dari Select)
                'c3' => 'required|numeric|min:0', // Penghasilan (Rupiah)
                'c4' => 'required|numeric',        // Kesejahteraan (Skor dari Select)
                'c5' => 'required|numeric',        // Kondisi Khusus (Skor dari Select)
                'c6' => 'required|numeric',        // Tanggungan (Skor dari Select)
                'c7' => 'required|numeric',        // Kepesantrenan (Skor dari Select)
            ]);
        }

        $this->validate($rules);

        $this->mhs->update([
            'status_berkas' => $this->status_berkas,
            'c1' => $this->c1,
            'c2' => $this->c2,
            'c3' => $this->c3,
            'c4' => $this->c4,
            'c5' => $this->c5,
            'c6' => $this->c6,
            'c7' => $this->c7,
        ]);

        session()->flash('message', 'Penilaian berhasil disimpan berdasarkan kriteria baru.');
        return redirect()->route('admin.pendaftar');
    }

    public function render()
    {
        return view('livewire.admin-penilaian')->layout('layouts.admin');
    }
}
