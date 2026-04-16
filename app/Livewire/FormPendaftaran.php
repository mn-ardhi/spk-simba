<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Mahasiswa;
use App\Models\Periode;
use Illuminate\Support\Facades\Auth;

class FormPendaftaran extends Component
{
    use WithFileUploads;

    // Properti Data Mahasiswa
    public $nim, $prodi, $semester, $tahun_masuk, $ipk;
    public $nik, $nisn, $nama_lengkap, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $nama_ibu_kandung, $wa;
    public $propinsi, $kabupaten, $kecamatan, $kelurahan, $rt, $rw, $alamat, $kode_pos;

    // Properti 3 File Berkas Baru
    public $file_ktp, $file_kk, $file_kip;

    public function simpan()
    {
        // 1. Validasi Input & Ketiga File
        $this->validate([
            'nim' => 'required|unique:mahasiswas,nim',
            'nama_lengkap' => 'required|string',
            'ipk' => 'required|numeric|between:0,4.00',
            'nik' => 'required|digits:16|unique:mahasiswas,nik',
            'nisn' => 'required|digits:10|unique:mahasiswas,nisn',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'file_ktp' => 'required|mimes:pdf|max:2048',
            'file_kk' => 'required|mimes:pdf|max:2048',
            'file_kip' => 'required|mimes:pdf|max:2048',
        ]);

        // 2. Cek Periode Aktif
        $periodeAktif = Periode::where('is_aktif', true)->first();
        if (!$periodeAktif) {
            session()->flash('error', 'Periode pendaftaran belum dibuka.');
            return;
        }

        // 3. Simpan Ketiga File Fisik ke Storage Server
        $path_ktp = $this->file_ktp->store('berkas_mahasiswa/ktp', 'public');
        $path_kk  = $this->file_kk->store('berkas_mahasiswa/kk', 'public');
        $path_kip = $this->file_kip->store('berkas_mahasiswa/kip', 'public');

        // Gabungkan ketiga path menjadi satu string JSON
        $gabungan_berkas = json_encode([
            'ktp' => $path_ktp,
            'kk' => $path_kk,
            'kip' => $path_kip
        ]);

        // 4. Simpan ke Database
        Mahasiswa::create([
            'user_id' => Auth::id(), //mengambil id pengguna yg sedang login
            'periode_id' => $periodeAktif->id,
            'nim' => $this->nim,
            'prodi' => $this->prodi,
            'semester' => $this->semester,
            'tahun_masuk' => $this->tahun_masuk,
            'ipk' => $this->ipk,
            'nik' => $this->nik,
            'nisn' => $this->nisn,
            'nama_lengkap' => $this->nama_lengkap,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'nama_ibu_kandung' => $this->nama_ibu_kandung,
            'wa' => $this->wa,
            'propinsi' => $this->propinsi,
            'kabupaten' => $this->kabupaten,
            'kecamatan' => $this->kecamatan,
            'kelurahan' => $this->kelurahan,
            'rt' => $this->rt,
            'rw' => $this->rw,
            'alamat' => $this->alamat,
            'kode_pos' => $this->kode_pos,
            'file_berkas' => $gabungan_berkas, // Disimpan sebagai JSON
            'status_berkas' => 'menunggu',
        ]);

        session()->flash('message', 'Pendaftaran dan seluruh berkas berhasil dikirim!');
        $this->reset(); // Kosongkan form setelah sukses
    }

    public function render()
    {
        return view('livewire.form-pendaftaran');
    }
}
