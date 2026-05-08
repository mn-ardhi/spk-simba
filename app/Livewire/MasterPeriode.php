<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Periode;
use Carbon\Carbon;

class MasterPeriode extends Component
{
    use WithPagination;    
    public $periode_id, $nama_periode, $kuota_penerima, $tanggal_mulai, $tanggal_akhir;
    public $is_edit = false;

    protected $rules = [
        'nama_periode' => 'required|string|max:255',
        'kuota_penerima' => 'required|integer|min:1',
        'tanggal_mulai' => 'required|date',
        'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
    ];

    public function simpanPeriode()
    {
        $this->validate();

        if ($this->is_edit) {
            $periode = Periode::findOrFail($this->periode_id);
            $periode->update([
                'nama_periode' => $this->nama_periode,
                'kuota_penerima' => $this->kuota_penerima,
                'tanggal_mulai' => Carbon::parse($this->tanggal_mulai),
                'tanggal_akhir' => Carbon::parse($this->tanggal_akhir),
            ]);
            session()->flash('pesan', 'Periode berhasil diperbarui!');
        } else {
            Periode::create([
                'nama_periode' => $this->nama_periode,
                'kuota_penerima' => $this->kuota_penerima,
                'tanggal_mulai' => Carbon::parse($this->tanggal_mulai),
                'tanggal_akhir' => Carbon::parse($this->tanggal_akhir),
                'is_aktif' => false, 
            ]);
            session()->flash('pesan', 'Periode berhasil ditambahkan!');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $periode = Periode::findOrFail($id);
        $this->periode_id = $periode->id;
        $this->nama_periode = $periode->nama_periode;
        $this->kuota_penerima = $periode->kuota_penerima;
        $this->tanggal_mulai = Carbon::parse($periode->tanggal_mulai)->format('Y-m-d');
        $this->tanggal_akhir = Carbon::parse($periode->tanggal_akhir)->format('Y-m-d');
        
        $this->is_edit = true;
    }

    public function hapus($id)
    {
        Periode::findOrFail($id)->delete();
        session()->flash('pesan', 'Periode berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $periode = Periode::findOrFail($id);
        
        if ($periode->is_aktif) {
            // Jika sedang aktif, matikan (Force Shutdown)
            $periode->update(['is_aktif' => false]);
            session()->flash('pesan', 'Periode dimatikan.');
        } else {
            // Matikan semua, lalu aktifkan yang dipilih
            Periode::query()->update(['is_aktif' => false]);
            $periode->update(['is_aktif' => true]);
            session()->flash('pesan', 'Periode diaktifkan.');
        }
    }

    public function batalEdit()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['periode_id', 'nama_periode', 'kuota_penerima', 'tanggal_mulai', 'tanggal_akhir', 'is_edit']);
    }

    public function render()
    {
        return view('livewire.master-periode', [
            'periodes' => Periode::latest()->paginate(10)
        ])->layout('layouts.admin');
    }
}