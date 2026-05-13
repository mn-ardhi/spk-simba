<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Mahasiswa;
use App\Models\Periode;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.mahasiswa')]
class FormPendaftaran extends Component
{
    use WithFileUploads;

    // --- STATE MANAGEMENT ---
    public $currentStep = 1;
    public $totalSteps = 4;

    // --- PROPERTI FORM ---
    // Step 1: Identitas Pribadi
    public ?string $nik = null;
    public ?string $nama_lengkap = null;
    public ?string $tempat_lahir = null;
    public ?string $tanggal_lahir = null;
    public ?string $jenis_kelamin = null;
    public ?string $nama_ibu_kandung = null;
    public ?string $wa = null;

    // Step 2: Data Akademik
    public ?string $nim = null;
    public ?string $prodi = null;
    public ?string $semester = null;
    public ?string $tahun_masuk = null;
    public ?string $nisn = null;
    public ?string $tahun_lulus_sma = null;
    public ?string $nilai_ijazah = null;

    // Step 3: Alamat Domisili
    public ?string $alamat = null;
    public ?string $propinsi = null;
    public ?string $kabupaten = null;
    public ?string $kecamatan = null;
    public ?string $kelurahan = null;
    public ?string $rt = null;
    public ?string $rw = null;
    public ?string $kode_pos = null;

    // Step 4: Kriteria & Berkas Dukung
    public ?string $penghasilan_ortu = null;
    public ?string $prestasi_non_akademik = null;
    public ?string $status_pesantren = null;
    public ?string $kondisi_keluarga = null;
    public mixed $file_ijazah = null;
    public mixed $file_ktp = null;
    public mixed $file_kk = null;
    public mixed $file_kip = null;
    public mixed $bukti_sertifikat = null;
    public bool $setuju_pernyataan = false;

    // --- LIFECYCLE HOOKS ---
    public function mount()
    {
        // 1. Auto-Fill Data: Ambil data jika mahasiswa sedang melakukan Revisi (status ditolak)
        $mahasiswaExisting = Mahasiswa::where('user_id', Auth::id())->first();

        if ($mahasiswaExisting) {
            // Step 1
            $this->nik = $mahasiswaExisting->nik;
            $this->nama_lengkap = $mahasiswaExisting->nama_lengkap;
            $this->tempat_lahir = $mahasiswaExisting->tempat_lahir;
            $this->tanggal_lahir = $mahasiswaExisting->tanggal_lahir ? $mahasiswaExisting->tanggal_lahir->format('Y-m-d') : null;
            $this->jenis_kelamin = $mahasiswaExisting->jenis_kelamin;
            $this->nama_ibu_kandung = $mahasiswaExisting->nama_ibu_kandung;
            $this->wa = $mahasiswaExisting->wa;

            // Step 2
            $this->nim = $mahasiswaExisting->nim;
            $this->prodi = $mahasiswaExisting->prodi;
            $this->semester = $mahasiswaExisting->semester;
            $this->nisn = $mahasiswaExisting->nisn;
            $this->tahun_masuk = $mahasiswaExisting->tahun_masuk;
            $this->tahun_lulus_sma = $mahasiswaExisting->tahun_lulus_sma;
            $this->nilai_ijazah = $mahasiswaExisting->nilai_ijazah;

            // Step 3
            $this->alamat = $mahasiswaExisting->alamat;
            $this->propinsi = $mahasiswaExisting->propinsi;
            $this->kabupaten = $mahasiswaExisting->kabupaten;
            $this->kecamatan = $mahasiswaExisting->kecamatan;
            $this->kelurahan = $mahasiswaExisting->kelurahan;
            $this->rt = $mahasiswaExisting->rt;
            $this->rw = $mahasiswaExisting->rw;
            $this->kode_pos = $mahasiswaExisting->kode_pos;

            // Step 4
            $this->penghasilan_ortu = $mahasiswaExisting->penghasilan_ortu;
            $this->prestasi_non_akademik = $mahasiswaExisting->prestasi_non_akademik;
            $this->status_pesantren = $mahasiswaExisting->status_pesantren;
            $this->kondisi_keluarga = $mahasiswaExisting->kondisi_keluarga;

            // File tidak di-bind kembali ke public property file upload Livewire demi keamanan, 
            // tapi kita akan menangani file lamanya di fungsi simpan().
        }
    }

    // --- NAVIGATION & AUTO-SAVE LOGIC ---
    public function nextStep()
    {
        // 1. Validasi spesifik per step sebelum lanjut (Backend Security)
        if ($this->currentStep == 1) {
            // Validasi Step 1: Identitas Pribadi
            $this->validate([
                'nik'              => 'required|numeric|digits:16',
                'nama_lengkap'     => 'required|string|max:255',
                'tempat_lahir'     => 'required|string|max:255',
                'tanggal_lahir'    => 'required|date',
                'jenis_kelamin'    => 'required|in:L,P', // Asumsi value L untuk Laki-laki, P untuk Perempuan
                'nama_ibu_kandung' => 'required|string|max:255',
                'wa'               => 'required|numeric|min_digits:10',
            ], [
                // Custom Error Messages (Opsional, tapi bagus untuk UX)
                'nik.digits' => 'NIK harus tepat 16 digit.',
                'wa.numeric' => 'Nomor WhatsApp harus berupa angka.',
            ]);
        } elseif ($this->currentStep == 2) {
            // Validasi Step 2: Data Akademik
            $this->validate([
                'nim'             => 'required|string|max:20',
                'prodi'           => 'required|string|max:100',
                'semester'        => 'required|numeric|min:1|max:14',
                'nisn'             => 'required|string|max:15',
                'tahun_masuk'     => 'required|numeric|digits:4',
                'tahun_lulus_sma' => 'required|numeric|digits:4',
                'nilai_ijazah'    => 'required|numeric', // Bisa tambahkan between:0,100 jika pakai skala 100
            ]);
        } elseif ($this->currentStep == 3) {
            // Validasi Step 3: Alamat Domisili
            $this->validate([
                'alamat'    => 'required|string|max:500',
                'propinsi'  => 'required|string|max:100',
                'kabupaten' => 'required|string|max:100',
                'kecamatan' => 'required|string|max:100',
                'kelurahan' => 'required|string|max:100',
                'rt'        => 'required|numeric',
                'rw'        => 'required|numeric',
                'kode_pos'  => 'required|numeric|digits:5',
            ]);
        }

        // 2. Draft System (Auto-save): Eksekusi penyimpanan sementara ke Database
        // Pastikan di dalam fungsi autoSaveDraft() sudah menyertakan periode_id ya!
        $this->autoSaveDraft();

        // 3. Pindah ke langkah selanjutnya jika belum di langkah terakhir
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    // Fungsi terpisah untuk menjaga kode tetap bersih (Clean Code)
    private function autoSaveDraft()
    {
        // 1. Cari periode aktif. 
        // Kita gunakan first() supaya bisa kita cek dulu keberadaannya.
        $periodeAktif = \App\Models\Periode::where('status_otomatis', true)->first();

        // 2. Defensive Programming: Cek apakah periode ditemukan?
        if (!$periodeAktif) {
            // Jika tidak ada periode aktif, jangan paksa simpan karena pasti error SQL.
            // Berikan notifikasi ke user atau log error.
            $this->dispatch(
                'notifikasi-error',
                title: 'Gagal Menyimpan (Draft)',
                text: 'Sistem tidak menemukan Periode Pendaftaran yang aktif. Silakan hubungi Admin.'
            );

            // Hentikan eksekusi kode di bawahnya
            return;
        }

        // 3. Eksekusi Update atau Create
        \App\Models\Mahasiswa::updateOrCreate(
            ['user_id' => \Illuminate\Support\Facades\Auth::id()],
            [
                'periode_id'       => $periodeAktif->id, // Sekarang kita yakin ini tidak null
                'nik'              => $this->nik,
                'nisn'             => $this->nisn,
                'nama_lengkap'     => $this->nama_lengkap,
                'tempat_lahir'     => $this->tempat_lahir,
                'tanggal_lahir'    => $this->tanggal_lahir,
                'jenis_kelamin'    => $this->jenis_kelamin,
                'nama_ibu_kandung' => $this->nama_ibu_kandung,
                'wa'               => $this->wa,
                'status_berkas'    => 'draft',

                // Masukkan field lainnya meskipun isinya masih null (karena sudah kita buat nullable di migration)
                'nim'              => $this->nim,
                'prodi'            => $this->prodi,
                'semester'         => $this->semester,
                'tahun_masuk'      => $this->tahun_masuk,
                'tahun_lulus_sma'  => $this->tahun_lulus_sma,
                'nilai_ijazah'     => $this->nilai_ijazah,
                'alamat'           => $this->alamat,
                'propinsi'         => $this->propinsi,
                'kabupaten'        => $this->kabupaten,
                'kecamatan'        => $this->kecamatan,
                'kelurahan'        => $this->kelurahan,
                'rt'               => $this->rt,
                'rw'               => $this->rw,
                'kode_pos'         => $this->kode_pos,
            ]
        );
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    // --- VALIDATION LOGIC ---
    public function validateData()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'nik' => 'required|string|max:16',
                'nisn' => 'required|string|max:15',
                'nama_lengkap' => 'required|string|max:255',
                'tempat_lahir' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:L,P',
                'wa' => 'required|string|max:15',
                'nama_ibu_kandung' => 'required|string|max:255',
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'nim' => 'required|string|max:20',
                'prodi' => 'required|string|max:255',
                'semester' => 'required|numeric|min:1|max:14',
                'tahun_masuk' => 'required|numeric|digits:4',
                'tahun_lulus_sma' => 'required|numeric|digits:4',
                'nilai_ijazah' => 'required|numeric|min:0|max:100',
            ]);
        } elseif ($this->currentStep == 3) {
            $this->validate([
                'alamat' => 'required|string',
                'propinsi' => 'required|string|max:255',
                'kabupaten' => 'required|string|max:255',
                'kecamatan' => 'required|string|max:255',
                'kelurahan' => 'required|string|max:255',
                'rt' => 'required|string|max:5',
                'rw' => 'required|string|max:5',
                'kode_pos' => 'required|numeric',
            ]);
        } elseif ($this->currentStep == 4) {
            $this->validate([
                'penghasilan_ortu' => 'required|numeric|min:0',
                'prestasi_non_akademik' => 'nullable|string|max:255',
                'status_pesantren' => 'required|string',
                'kondisi_keluarga' => 'required|string',
                'file_ijazah' => 'nullable|mimes:pdf,jpg,png|max:2048',
                'file_ktp' => 'nullable|mimes:pdf,jpg,png|max:2048',
                'file_kk' => 'nullable|mimes:pdf,jpg,png|max:2048',
                'file_kip' => 'nullable|mimes:pdf,jpg,png|max:2048',
                'bukti_sertifikat' => 'nullable|mimes:pdf,jpg,png|max:2048',
            ]);
        }
    }

    // --- FINAL SUBMISSION LOGIC ---
    public function simpan()
    {
        // 1. Lakukan validasi akhir di Step 4
        $this->validateData();
        $this->validate([
            'setuju_pernyataan' => 'accepted' // Memastikan checkbox wajib dicentang (bernilai true)
        ]);

        // 2. Ambil Periode Aktif
        $periodeAktif = Periode::where('is_aktif', true)->first();
        if (!$periodeAktif) {
            session()->flash('error', 'Pendaftaran ditutup karena tidak ada periode aktif.');
            return redirect()->route('mahasiswa.dashboard');
        }

        // 3. Cek Data yang Ada (Existing Data)
        $mahasiswaExisting = Mahasiswa::where('user_id', Auth::id())->where('periode_id', $periodeAktif->id)->first();

        // 4. Proteksi: Jika data sedang 'menunggu' atau sudah 'valid', blokir perubahan!
        if ($mahasiswaExisting && in_array($mahasiswaExisting->status_berkas, ['menunggu', 'valid'])) {
            session()->flash('error', 'Pendaftaran Anda sedang diproses atau sudah tervalidasi. Data tidak dapat diubah.');
            return redirect()->route('mahasiswa.dashboard');
        }

        // 5. Smart File Handling: Jika ada file baru, simpan. Jika tidak, pertahankan file yang lama
        $pathIjazah = $this->file_ijazah ? $this->file_ijazah->store('berkas', 'public') : ($mahasiswaExisting->file_ijazah ?? null);
        $pathKtp = $this->file_ktp ? $this->file_ktp->store('berkas', 'public') : ($mahasiswaExisting->file_ktp ?? null);
        $pathKk = $this->file_kk ? $this->file_kk->store('berkas', 'public') : ($mahasiswaExisting->file_kk ?? null);
        $pathKip = $this->file_kip ? $this->file_kip->store('berkas', 'public') : ($mahasiswaExisting->file_kip ?? null);
        $pathSertifikat = $this->bukti_sertifikat ? $this->bukti_sertifikat->store('berkas', 'public') : ($mahasiswaExisting->bukti_sertifikat ?? null);

        // Validasi ekstra: Wajib upload file baru JIKA tidak ada file lama di database
        if (!$pathKtp || !$pathKk || !$pathIjazah) {
            session()->flash('error', 'KTP, KK, dan Ijazah Wajib diunggah!');
            return;
        }

        // 6. Eksekusi Buat atau Perbarui Data
        Mahasiswa::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'periode_id' => $periodeAktif->id,
            ],
            [
                // Biodata
                'nik' => $this->nik,
                'nisn' => $this->nisn,
                'nama_lengkap' => $this->nama_lengkap,
                'tempat_lahir' => $this->tempat_lahir,
                'tanggal_lahir' => $this->tanggal_lahir,
                'jenis_kelamin' => $this->jenis_kelamin,
                'nama_ibu_kandung' => $this->nama_ibu_kandung,
                'wa' => $this->wa,

                // Akademik
                'nim' => $this->nim,
                'prodi' => $this->prodi,
                'semester' => $this->semester,
                'tahun_masuk' => $this->tahun_masuk,
                'tahun_lulus_sma' => $this->tahun_lulus_sma,
                'nilai_ijazah' => $this->nilai_ijazah,

                // Alamat
                'alamat' => $this->alamat,
                'propinsi' => $this->propinsi,
                'kabupaten' => $this->kabupaten,
                'kecamatan' => $this->kecamatan,
                'kelurahan' => $this->kelurahan,
                'rt' => $this->rt,
                'rw' => $this->rw,
                'kode_pos' => $this->kode_pos,

                // Tambahan & File
                'penghasilan_ortu' => $this->penghasilan_ortu,
                'prestasi_non_akademik' => $this->prestasi_non_akademik,
                'status_pesantren' => $this->status_pesantren,
                'kondisi_keluarga' => $this->kondisi_keluarga,
                'setuju_pernyataan' => $this->setuju_pernyataan,
                'status_berkas' => 'menunggu', // Kembalikan ke 'menunggu' untuk diverifikasi ulang
                'catatan_admin' => null,       // Kosongkan catatan penolakan sebelumnya
                'file_ijazah' => $pathIjazah,
                'file_ktp' => $pathKtp,
                'file_kk' => $pathKk,
                'file_kip' => $pathKip,
                'bukti_sertifikat' => $pathSertifikat,
            ]
        );

        session()->flash('message', 'Formulir Pendaftaran Berhasil Disimpan!');
        return redirect()->route('mahasiswa.dashboard');
    }

    public function render()
    {
        return view('livewire.form-pendaftaran', [
            'periodeAktif' => Periode::where('is_aktif', true)->first(),
        ]);
    }
}
