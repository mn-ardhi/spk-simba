<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Mahasiswa;
use App\Models\Periode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FormPendaftaran extends Component
{
    use WithFileUploads;

    // Properti Form
    public $nim, $prodi, $semester, $tahun_masuk, $nilai_ijazah;
    public $nik, $nisn, $nama_lengkap, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $nama_ibu_kandung, $wa;
    public $propinsi, $kabupaten, $kecamatan, $kelurahan, $rt, $rw, $alamat, $kode_pos;
    public $penghasilan_ortu, $status_pesantren, $kondisi_keluarga, $setuju_pernyataan = false;

    // Properti File
    public $file_ktp, $file_kk, $file_kip, $file_ijazah, $bukti_sertifikat;

    protected function rules()
    {
        return [
            'nim' => 'required|numeric|unique:mahasiswas,nim',
            'prodi' => 'required|string',
            'semester' => 'required|numeric|between:1,14',
            'tahun_masuk' => 'required|numeric',
            'nilai_ijazah' => 'required|decimal:0,2|between:0,100',
            'nik' => 'required|digits:16|unique:mahasiswas,nik',
            'nisn' => 'required|digits:10',
            'nama_lengkap' => 'required|string|min:3',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_ibu_kandung' => 'required',
            'wa' => 'required|numeric|digits_between:10,15',
            'propinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'rt' => 'required|numeric',
            'rw' => 'required|numeric',
            'alamat' => 'required',
            'kode_pos' => 'required|digits:5',
            'penghasilan_ortu' => 'required|numeric|min:0',
            'status_pesantren' => 'required',
            'kondisi_keluarga' => 'required',
            'setuju_pernyataan' => 'accepted', // Wajib dicentang
            'file_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kip' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'bukti_sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }

    public function simpan()
    {
        $this->validate();

        $periodeAktif = Periode::where('is_aktif', true)->first();
        if (!$periodeAktif) {
            session()->flash('error', 'Pendaftaran ditutup karena tidak ada periode aktif.');
            return;
        }

        // Cek apakah user sudah pernah mendaftar di periode ini
        $sudahDaftar = Mahasiswa::where('user_id', Auth::id())
            ->where('periode_id', $periodeAktif->id)
            ->exists();

        if ($sudahDaftar) {
            session()->flash('error', 'Anda sudah terdaftar pada periode ini.');
            return;
        }

        // Simpan File ke folder storage/app/public/berkas
        $pathKtp = $this->file_ktp->store('berkas', 'public');
        $pathKk = $this->file_kk->store('berkas', 'public');
        $pathKip = $this->file_kip->store('berkas', 'public');
        $pathIjazah = $this->file_ijazah->store('berkas', 'public');
        $pathSertifikat = $this->bukti_sertifikat->store('berkas', 'public');


        Mahasiswa::create([
            'user_id' => Auth::id(),
            'periode_id' => $periodeAktif->id,
            'nim' => $this->nim,
            'prodi' => $this->prodi,
            'semester' => $this->semester,
            'tahun_masuk' => $this->tahun_masuk,
            'nilai_ijazah' => $this->nilai_ijazah,
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
            'penghasilan_ortu' => $this->penghasilan_ortu,
            'status_pesantren' => $this->status_pesantren,
            'kondisi_keluarga' => $this->kondisi_keluarga,
            'setuju_pernyataan' => $this->setuju_pernyataan,
            'status_berkas' => 'menunggu', // Default status
            'file_ktp' => $pathKtp,
            'file_kk' => $pathKk,
            'file_kip' => $pathKip,
            'file_ijazah' => $pathIjazah,
            'bukti_sertifikat' => $pathSertifikat,
        ]);

        return redirect()->route('mahasiswa.dashboard')->with('message', 'Pendaftaran Berhasil Dikirim!');
    }

    public function render()
    {
        return view('livewire.form-pendaftaran')->layout('layouts.mahasiswa');
    }
}
