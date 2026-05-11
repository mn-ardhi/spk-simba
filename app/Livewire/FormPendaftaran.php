<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Mahasiswa;
use App\Models\Periode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;  
use Livewire\Attributes\Layout;

#[Layout('layouts.mahasiswa')] // <--- BERITAHU LIVEWIRE PAKAI LAYOUT MAHASISWA

class FormPendaftaran extends Component
{
    use WithFileUploads;

    // Properti Form
    public $nim, $prodi, $semester, $tahun_masuk, $nilai_ijazah;
    public $nik, $nisn, $nama_lengkap, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $nama_ibu_kandung, $wa;
    public $propinsi, $kabupaten, $kecamatan, $kelurahan, $rt, $rw, $alamat, $kode_pos;
    public $penghasilan_ortu, $prestasi_non_akademik, $status_pesantren, $kondisi_keluarga, $setuju_pernyataan = false;

    // Properti File
    public $file_ktp, $file_kk, $file_kip, $file_ijazah, $bukti_sertifikat;

    
    protected $messages = [
    // Identitas Pribadi
    'nim.nullable' => 'NIM wajib diisi.',
    'nim.numeric' => 'NIM harus berupa angka.',
    'nim.unique' => 'NIM ini sudah terdaftar dalam sistem.',
    'prodi.nullable' => 'Program Studi wajib diisi.',
    'semester.nullable' => 'Semester wajib diisi.',
    'semester.numeric' => 'Semester harus berupa angka.',
    'semester.between' => 'Semester harus berada di antara 1 hingga 14.',
    'tahun_masuk.nullable' => 'Tahun masuk wajib diisi.',
    'tahun_masuk.numeric' => 'Tahun masuk harus berupa angka.',
    'nilai_ijazah.nullable' => 'Nilai ijazah/IPK wajib diisi.',
    'nilai_ijazah.decimal' => 'Nilai ijazah harus berupa angka desimal (contoh: 85.50).',
    'nilai_ijazah.between' => 'Nilai ijazah harus di antara 0 hingga 100.',
    'nik.nullable' => 'NIK wajib diisi.',
    'nik.digits' => 'NIK harus berjumlah tepat 16 angka.',
    'nik.unique' => 'NIK ini sudah terdaftar.',
    'nisn.nullable' => 'NISN wajib diisi.',
    'nisn.digits' => 'NISN harus berjumlah tepat 10 angka.',
    'nama_lengkap.nullable' => 'Nama lengkap wajib diisi.',
    'nama_lengkap.min' => 'Nama lengkap minimal 3 karakter.',
    'tempat_lahir.nullable' => 'Tempat lahir wajib diisi.',
    'tempat_lahir.min' => 'Tempat lahir minimal 2 karakter.',
    'tempat_lahir.max' => 'Tempat lahir maksimal 50 karakter.',
    'tempat_lahir.regex' => 'Tempat lahir hanya boleh berisi huruf dan spasi.',
    'tanggal_lahir.nullable' => 'Tanggal lahir wajib diisi.',
    'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
    'jenis_kelamin.nullable' => 'Jenis kelamin wajib dipilih.',
    'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
    'nama_ibu_kandung.nullable' => 'Nama ibu kandung wajib diisi.',
    'wa.nullable' => 'Nomor WhatsApp wajib diisi.',
    'wa.numeric' => 'Nomor WhatsApp hanya boleh berisi angka.',
    'wa.digits_between' => 'Nomor WhatsApp harus antara 10 hingga 15 angka.',

    // Alamat & Kontak
    'propinsi.nullable' => 'Provinsi wajib diisi.',
    'kabupaten.nullable' => 'Kabupaten/Kota wajib diisi.',
    'kecamatan.nullable' => 'Kecamatan wajib diisi.',
    'kelurahan.nullable' => 'Kelurahan/Desa wajib diisi.',
    'rt.nullable' => 'RT wajib diisi.',
    'rt.numeric' => 'RT harus berupa angka.',
    'rw.nullable' => 'RW wajib diisi.',
    'rw.numeric' => 'RW harus berupa angka.',
    'alamat.nullable' => 'Alamat detail wajib diisi.',
    'kode_pos.nullable' => 'Kode pos wajib diisi.',
    'kode_pos.digits' => 'Kode pos harus berjumlah tepat 5 angka.',

    // Data Tambahan & Keluarga
    'penghasilan_ortu.nullable' => 'Penghasilan orang tua wajib diisi.',
    'penghasilan_ortu.numeric' => 'Penghasilan orang tua harus berupa angka (tanpa titik).',
    'penghasilan_ortu.min' => 'Penghasilan orang tua tidak boleh kurang dari 0.',
    'prestasi_non_akademik.string' => 'Prestasi non akademik harus berupa teks.',
    'status_pesantren.nullable' => 'Status pesantren wajib dipilih.',
    'kondisi_keluarga.nullable' => 'Kondisi keluarga wajib dipilih/diisi.',
    'setuju_pernyataan.accepted' => 'Anda wajib mencentang persetujuan kebenaran data.',

    // Upload Berkas
    'file_ktp.nullable' => 'Dokumen KTP wajib diunggah.',
    'file_ktp.mimes' => 'KTP harus berformat PDF, JPG, JPEG, atau PNG.',
    'file_ktp.max' => 'Ukuran KTP maksimal 2MB.',
    'file_kk.nullable' => 'Dokumen KK wajib diunggah.',
    'file_kk.mimes' => 'KK harus berformat PDF, JPG, JPEG, atau PNG.',
    'file_kk.max' => 'Ukuran KK maksimal 2MB.',
    'file_kip.nullable' => 'Dokumen KIP wajib diunggah.',
    'file_kip.mimes' => 'KIP harus berformat PDF, JPG, JPEG, atau PNG.',
    'file_kip.max' => 'Ukuran KIP maksimal 2MB.',
    'file_ijazah.nullable' => 'Dokumen Ijazah wajib diunggah.',
    'file_ijazah.mimes' => 'Ijazah harus berformat PDF, JPG, JPEG, atau PNG.',
    'file_ijazah.max' => 'Ukuran Ijazah maksimal 2MB.',
    'bukti_sertifikat.nullable' => 'Bukti sertifikat wajib diunggah.',
    'bukti_sertifikat.mimes' => 'Sertifikat harus berformat PDF, JPG, JPEG, atau PNG.',
    'bukti_sertifikat.max' => 'Ukuran sertifikat maksimal 2MB.',
    ];

    protected function rules()
    {
        return [
            'nim' => 'nullable|numeric|unique:mahasiswas,nim',
            'prodi' => 'nullable|string',
            'semester' => 'nullable|numeric|between:1,14',
            'tahun_masuk' => 'nullable|numeric',
            'nilai_ijazah' => 'nullable|decimal:0,2|between:0,100',
            'nik' => 'nullable|digits:16|unique:mahasiswas,nik',
            'nisn' => 'nullable|digits:10',
            'nama_lengkap' => 'nullable|string|min:3',
            'tempat_lahir' => 'nullable|string|min:2|max:50|regex:/^[a-zA-Z\s]+$/',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'nama_ibu_kandung' => 'nullable',
            'wa' => 'nullable|numeric|digits_between:10,15',
            'propinsi' => 'nullable|string',
            'kabupaten' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kelurahan' => 'nullable|string',
            'rt' => 'nullable|numeric',
            'rw' => 'nullable|numeric',
            'alamat' => 'nullable|string',
            'kode_pos' => 'nullable|digits:5',
            'penghasilan_ortu' => 'nullable|numeric|min:0',
            'prestasi_non_akademik' => 'nullable|string',
            'status_pesantren' => 'nullable',
            'kondisi_keluarga' => 'nullable',
            'setuju_pernyataan' => 'accepted', // Wajib dicentang
            'file_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
             'bukti_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
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
        $pathKtp = $this->file_ktp ? $this->file_ktp->store('berkas', 'public') : null;
        $pathKk = $this->file_kk ? $this->file_kk->store('berkas', 'public') : null;
        $pathKip = $this->file_kip ? $this->file_kip->store('berkas', 'public') : null;
        $pathIjazah = $this->file_ijazah ? $this->file_ijazah->store('berkas', 'public') : null;
        $pathSertifikat = $this->bukti_sertifikat ? $this->bukti_sertifikat->store('berkas', 'public') : null;

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
            'prestasi_non_akademik' => $this->prestasi_non_akademik,
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

public function mount()
{
    // kembalikan nullabel menjadi required
    // Kondisi ini memastikan pengisian otomatis HANYA terjadi di server lokal Anda (tahap uji coba)
    if (app()->environment('local')) { 
        $this->nim = '202610001';
        $this->prodi = 'Teknik Informatika';
        $this->semester = '3';
        $this->tahun_masuk = '2024';
        $this->nilai_ijazah = '88.50';
        $this->nik = '3301234567890001';
        $this->nisn = '0012345678';
        $this->nama_lengkap = 'Mahasiswa Uji Coba';
        $this->tempat_lahir = 'Jakarta';
        $this->tanggal_lahir = '2005-08-17';
        $this->jenis_kelamin = 'L';
        $this->nama_ibu_kandung = 'Ibu Fulanah';
        $this->wa = '081234567890';
        $this->propinsi = 'Jawa Tengah';
        $this->kabupaten = 'Semarang';
        $this->kecamatan = 'Banyumanik';
        $this->kelurahan = 'Srondol';
        $this->rt = '1';
        $this->rw = '2';
        $this->alamat = 'Jl. Merdeka No. 123';
        $this->kode_pos = '50263';
        $this->penghasilan_ortu = '2500000';
        $this->status_pesantren = 'Tidak';
        $this->kondisi_keluarga = 'Lengkap';
        $this->prestasi_non_akademik = 'Juara 1 Lomba Web Design';
        $this->setuju_pernyataan = true;
    }
}

    public function render()
{
    // 1. Cari periode aktif berdasarkan rentang waktu hari ini
    // Menggunakan helper now() lebih ringkas daripada Carbon::now()
    $periodeAktif = Periode::where('tanggal_mulai', '<=', now())
                            ->where('tanggal_akhir', '>=', now())
                            ->latest()
                            ->first();

    // 2. Fallback: Ambil periode terbaru jika tidak ada yang aktif saat ini
    if (!$periodeAktif) {
        $periodeAktif = Periode::latest()->first();
    }

    // 3. Ambil data pendaftaran milik user (Gunakan auth()->id() agar lebih singkat)
    $dataMahasiswa = Mahasiswa::where('user_id', auth()->id())->first();

    // 4. Kirim data ke view dengan layout khusus mahasiswa
    return view('livewire.form-pendaftaran', [
        'periodeAktif' => $periodeAktif,
        'mahasiswa'    => $dataMahasiswa,
    ]);
}
}