<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Periode;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.admin')]
class MasterPeriode extends Component
{
    use WithPagination;

    // State untuk Form Input
    public ?int $periode_id = null;
    public ?string $nama_periode = null;
    public ?int $kuota_penerima = null;
    public ?string $tanggal_mulai = null;
    public ?string $tanggal_akhir = null;
    public bool $is_edit = false;

    // Validation Rules (Full Stack Standard)
    protected $rules = [
        'nama_periode' => 'required|string|max:255',
        'kuota_penerima' => 'required|integer|min:1',
        'tanggal_mulai' => 'required|date',
        'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
    ];

    /**
     * RENDER LOGIC:
     * Di sini kunci perbaikannya. Kita harus mengirimkan variabel '$periode' 
     * ke view agar Header Span kamu bisa membacanya secara dinamis.
     */
    public function render()
    {
        // 1. Fetch data periode aktif secara spesifik
        // Gunakan findBy atau where dengan first()
        $periodeAktif = Periode::where('is_aktif', 1)->first();

        return view('livewire.master-periode', [
            // Menggunakan key yang deskriptif untuk pagination
            'periodes' => Periode::latest()->paginate(5),

            // Mengirimkan state periode aktif ke frontend
            'periodeAktif' => $periodeAktif,
        ]);
    }

    public function toggleStatus(int $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $target = Periode::findOrFail($id);

                if ($target->is_aktif == 1) {
                    // Jika sedang aktif, kita matikan (OFF)
                    $target->update(['is_aktif' => 0]);
                } else {
                    // JIKA INGIN DIAKTIFKAN (ON):
                    // 1. Matikan semua periode lain agar tidak ada dualisme (is_aktif = 0)
                    Periode::query()->update(['is_aktif' => 0]);

                    // 2. Aktifkan periode yang dipilih (is_aktif = 1)
                    $target->update(['is_aktif' => 1]);
                }
            });

            session()->flash('pesan', 'Status periode berhasil diperbarui!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function editPeriode(int $id)
    {
        try {
            // 1. Tarik data dari database berdasarkan ID yang diklik
            $periode = \App\Models\Periode::findOrFail($id);

            // 2. Masukkan (binding) data ke dalam properti state form
            $this->periode_id = $id;
            $this->nama_periode = $periode->nama_periode;
            $this->kuota_penerima = $periode->kuota_penerima;

            // 3. Format tanggal agar terbaca oleh tag HTML <input type="date"> (Wajib format Y-m-d)
            $this->tanggal_mulai = \Carbon\Carbon::parse($periode->tanggal_mulai)->format('Y-m-d');
            $this->tanggal_akhir = \Carbon\Carbon::parse($periode->tanggal_akhir)->format('Y-m-d');

            // 4. Ubah status form menjadi mode edit (UI akan otomatis menyesuaikan judul & tombol)
            $this->is_edit = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memuat data: ' . $e->getMessage());
        }
    }

    /**
     * Fungsi untuk membatalkan proses edit dan menutup form edit
     * HARUS public agar bisa dipanggil dari Blade
     */
    public function batalEdit()
    {
        // Panggil fungsi reset untuk mengosongkan inputan
        $this->resetForm();
    }

    

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
        } else {
            Periode::create([
                'nama_periode' => $this->nama_periode,
                'kuota_penerima' => $this->kuota_penerima,
                'tanggal_mulai' => Carbon::parse($this->tanggal_mulai),
                'tanggal_akhir' => Carbon::parse($this->tanggal_akhir),
                'is_aktif' => 0,
            ]);
        }

        $this->resetForm();
        session()->flash('pesan', 'Data berhasil disimpan!');
    }

    public function resetForm()
    {
        $this->reset(['periode_id', 'nama_periode', 'kuota_penerima', 'tanggal_mulai', 'tanggal_akhir', 'is_edit']);
    }

    /**
     * Fungsi untuk menghapus periode
     * Harus public agar bisa dipanggil oleh $wire.hapus() di Blade
     */
    public function hapus(int $id)
    {
        try {
            // Cari data berdasarkan ID
            $periode = \App\Models\Periode::findOrFail($id);

            // Hapus data
            $periode->delete();

            // Kirim notifikasi sukses
            session()->flash('pesan', 'Data periode berhasil dihapus!');
        } catch (\Exception $e) {
            // Jika gagal (misal karena constraint database)
            session()->flash('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
