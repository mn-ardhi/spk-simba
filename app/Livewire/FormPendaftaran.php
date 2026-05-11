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
    public $nim, $prodi, $semester, $tahun_masuk, $tahun_lulus_sma, $nilai_ijazah;
    public $nik, $nisn, $nama_lengkap, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $nama_ibu_kandung, $wa;
    public $propinsi, $kabupaten, $kecamatan, $kelurahan, $rt, $rw, $alamat, $kode_pos;
    public $penghasilan_ortu, $prestasi_non_akademik, $status_pesantren, $kondisi_keluarga, $setuju_pernyataan = false;

    // Properti File
    public $file_ktp, $file_kk, $file_kip, $file_ijazah, $bukti_sertifikat;

    
    protected $messages = [
    // Identitas Pribadi
    'nim.required' => 'NIM wajib diisi.',
    'nim.string' => 'NIM harus berupa string.',
    'nim.unique' => 'NIM ini sudah terdaftar dalam sistem.',
    'prodi.required' => 'Program Studi wajib diisi.',
    'semester.required' => 'Semester wajib diisi.',
    'semester.numeric' => 'Semester harus berupa angka.',
    'semester.between' => 'Semester harus berada di antara 1 hingga 14.',
    'tahun_masuk.required' => 'Tahun masuk wajib diisi.',
    'tahun_masuk.numeric' => 'Tahun masuk harus berupa angka.',
    'nilai_ijazah.required' => 'Nilai ijazah/IPK wajib diisi.',
    'nilai_ijazah.decimal' => 'Nilai ijazah harus berupa angka desimal (contoh: 85.50).',
    'nilai_ijazah.between' => 'Nilai ijazah harus di antara 0 hingga 100.',
    'nik.required' => 'NIK wajib diisi.',
    'nik.digits' => 'NIK harus berjumlah tepat 16 angka.',
    'nik.unique' => 'NIK ini sudah terdaftar.',
    'nisn.required' => 'NISN wajib diisi.',
    'nisn.digits' => 'NISN harus berjumlah tepat 10 angka.',
    'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
    'nama_lengkap.min' => 'Nama lengkap minimal 3 karakter.',
    'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
    'tempat_lahir.min' => 'Tempat lahir minimal 2 karakter.',
    'tempat_lahir.max' => 'Tempat lahir maksimal 50 karakter.',
    'tempat_lahir.regex' => 'Tempat lahir hanya boleh berisi huruf dan spasi.',
    'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
    'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
    'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
    'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
    'nama_ibu_kandung.required' => 'Nama ibu kandung wajib diisi.',
    'wa.required' => 'Nomor WhatsApp wajib diisi.',
    'wa.numeric' => 'Nomor WhatsApp hanya boleh berisi angka.',
    'wa.digits_between' => 'Nomor WhatsApp harus antara 10 hingga 15 angka.',

    // Alamat & Kontak
    'propinsi.required' => 'Provinsi wajib diisi.',
    'kabupaten.required' => 'Kabupaten/Kota wajib diisi.',
    'kecamatan.required' => 'Kecamatan wajib diisi.',
    'kelurahan.required' => 'Kelurahan/Desa wajib diisi.',
    'rt.required' => 'RT wajib diisi.',
    'rt.numeric' => 'RT harus berupa angka.',
    'rw.required' => 'RW wajib diisi.',
    'rw.numeric' => 'RW harus berupa angka.',
    'alamat.required' => 'Alamat detail wajib diisi.',
    'kode_pos.required' => 'Kode pos wajib diisi.',
    'kode_pos.digits' => 'Kode pos harus berjumlah tepat 5 angka.',

    // Data Tambahan & Keluarga
    'penghasilan_ortu.required' => 'Penghasilan orang tua wajib diisi.',
    'penghasilan_ortu.numeric' => 'Penghasilan orang tua harus berupa angka (tanpa titik).',
    'penghasilan_ortu.min' => 'Penghasilan orang tua tidak boleh kurang dari 0.',
    'prestasi_non_akademik.string' => 'Prestasi non akademik harus berupa teks.',
    'status_pesantren.required' => 'Status pesantren wajib dipilih.',
    'kondisi_keluarga.required' => 'Kondisi keluarga wajib dipilih/diisi.',
    'setuju_pernyataan.accepted' => 'Anda wajib mencentang persetujuan kebenaran data.',

    // Upload Berkas
    'file_ktp.required' => 'Dokumen KTP wajib diunggah.',
    'file_ktp.mimes' => 'KTP harus berformat PDF, JPG, JPEG, atau PNG.',
    'file_ktp.max' => 'Ukuran KTP maksimal 2MB.',
    'file_kk.required' => 'Dokumen KK wajib diunggah.',
    'file_kk.mimes' => 'KK harus berformat PDF, JPG, JPEG, atau PNG.',
    'file_kk.max' => 'Ukuran KK maksimal 2MB.',
    'file_kip.required' => 'Dokumen KIP wajib diunggah.',
    'file_kip.mimes' => 'KIP harus berformat PDF, JPG, JPEG, atau PNG.',
    'file_kip.max' => 'Ukuran KIP maksimal 2MB.',
    'file_ijazah.required' => 'Dokumen Ijazah wajib diunggah.',
    'file_ijazah.mimes' => 'Ijazah harus berformat PDF, JPG, JPEG, atau PNG.',
    'file_ijazah.max' => 'Ukuran Ijazah maksimal 2MB.',
    'bukti_sertifikat.required' => 'Bukti sertifikat wajib diunggah.',
    'bukti_sertifikat.mimes' => 'Sertifikat harus berformat PDF, JPG, JPEG, atau PNG.',
    'bukti_sertifikat.max' => 'Ukuran sertifikat maksimal 2MB.',
    ];

    protected function rules()
    {
        return [
            'nim' => 'required|string|unique:mahasiswas,nim',
            'prodi' => 'required|string',
            'semester' => 'required|numeric|between:1,14',
            'tahun_masuk' => 'required|numeric',
            'nilai_ijazah' => 'required|decimal:0,2|between:0,100',
            'nik' => 'required|digits:16|unique:mahasiswas,nik',
            'nisn' => 'required|digits:10',
            'nama_lengkap' => 'required|string|min:3',
            'tempat_lahir' => 'required|string|min:2|max:50|regex:/^[a-zA-Z\s]+$/',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_ibu_kandung' => 'required',
            'wa' => 'required|numeric|digits_between:10,15',
            'propinsi' => 'required|string',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'rt' => 'required|numeric',
            'rw' => 'required|numeric',
            'alamat' => 'required|string',
            'kode_pos' => 'required|digits:5',
            'penghasilan_ortu' => 'required|numeric|min:0',
            'prestasi_non_akademik' => 'nullable|string',
            'status_pesantren' => 'required',
            'kondisi_keluarga' => 'required',
            'setuju_pernyataan' => 'accepted', // Wajib dicentang
            'file_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kip' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
             'bukti_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ];
    }

    public function simpan()
{
    // 1. Jalankan Validasi
    $this->validate();

    // 2. Ambil Periode Aktif
    $periodeAktif = Periode::where('is_aktif', true)->first();
    if (!$periodeAktif) {
        session()->flash('error', 'Pendaftaran ditutup karena tidak ada periode aktif.');
        return;
    }

    // 3. Cek Record Mahasiswa yang Sudah Ada (Existing Data)
    $mahasiswaExisting = Mahasiswa::where('user_id', Auth::id())
        ->where('periode_id', $periodeAktif->id)
        ->first();

    // 4. Logika Keamanan: Cegah kirim ulang jika status sudah 'menunggu' atau 'valid'
    if ($mahasiswaExisting) {
        if (in_array($mahasiswaExisting->status_berkas, ['menunggu', 'valid'])) {
            session()->flash('error', 'Pendaftaran Anda sedang diproses atau sudah valid. Tidak dapat diubah.');
            return;
        }
    }

    // 5. SMART FILE HANDLING (Persistence Logic)
    // Jika ada file baru di-upload, simpan. Jika tidak, pakai path file yang lama (agar data file tidak hilang).
    $pathKtp = $this->file_ktp ? $this->file_ktp->store('berkas', 'public') : ($mahasiswaExisting->file_ktp ?? null);
    $pathKk = $this->file_kk ? $this->file_kk->store('berkas', 'public') : ($mahasiswaExisting->file_kk ?? null);
    $pathKip = $this->file_kip ? $this->file_kip->store('berkas', 'public') : ($mahasiswaExisting->file_kip ?? null);
    $pathIjazah = $this->file_ijazah ? $this->file_ijazah->store('berkas', 'public') : ($mahasiswaExisting->file_ijazah ?? null);
    $pathSertifikat = $this->bukti_sertifikat ? $this->bukti_sertifikat->store('berkas', 'public') : ($mahasiswaExisting->bukti_sertifikat ?? null);

    // 6. EKSEKUSI UPDATE ATAU CREATE (The Heart of the System)
    Mahasiswa::updateOrCreate(
        [
            'user_id' => Auth::id(),
            'periode_id' => $periodeAktif->id,
        ],
        [
            'nim' => $this->nim,
            'prodi' => $this->prodi,
            'semester' => $this->semester,
            'tahun_masuk' => $this->tahun_masuk,
            'tahun_lulus_sma' => $this->tahun_lulus_sma,
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
            
            // RESET METADATA
            'status_berkas' => 'menunggu', // Status reset ke antrean verifikasi
            'catatan_admin' => null,       // Hapus alasan penolakan yang lama
            
            // FILES
            'file_ktp' => $pathKtp,
            'file_kk' => $pathKk,
            'file_kip' => $pathKip,
            'file_ijazah' => $pathIjazah,
            'bukti_sertifikat' => $pathSertifikat,
        ]
    );

    return redirect()->route('mahasiswa.dashboard')->with('message', 'Pendaftaran Berhasil Diperbarui & Dikirim!');
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

public function mount()
{
    // 1. Cari apakah mahasiswa ini sudah pernah mengisi form sebelumnya
    $mahasiswa = \App\Models\Mahasiswa::where('user_id', auth()->id())->first();

    // 2. Jika data DITEMUKAN, masukkan semua nilainya ke properti form
    if ($mahasiswa) {
        $this->nim = $mahasiswa->nim;
        $this->prodi = $mahasiswa->prodi;
        $this->semester = $mahasiswa->semester;
        $this->tahun_masuk = $mahasiswa->tahun_masuk;
        $this->nilai_ijazah = $mahasiswa->nilai_ijazah;
        $this->nik = $mahasiswa->nik;
        $this->nisn = $mahasiswa->nisn;
        $this->nama_lengkap = $mahasiswa->nama_lengkap;
        $this->tempat_lahir = $mahasiswa->tempat_lahir;
        $this->tanggal_lahir = $mahasiswa->tanggal_lahir ? $mahasiswa->tanggal_lahir->format('Y-m-d') : null;
        $this->jenis_kelamin = $mahasiswa->jenis_kelamin;
        $this->nama_ibu_kandung = $mahasiswa->nama_ibu_kandung;
        $this->wa = $mahasiswa->wa;
        $this->propinsi = $mahasiswa->propinsi;
        $this->kabupaten = $mahasiswa->kabupaten;
        $this->kecamatan = $mahasiswa->kecamatan;
        $this->kelurahan = $mahasiswa->kelurahan;
        $this->rt = $mahasiswa->rt;
        $this->rw = $mahasiswa->rw;
        $this->alamat = $mahasiswa->alamat;
        $this->kode_pos = $mahasiswa->kode_pos;
        $this->penghasilan_ortu = $mahasiswa->penghasilan_ortu;
        $this->status_pesantren = $mahasiswa->status_pesantren;
        $this->kondisi_keluarga = $mahasiswa->kondisi_keluarga;
        $this->prestasi_non_akademik = $mahasiswa->prestasi_non_akademik;
        
        // Note: Untuk file/berkas, biarkan kosong agar mahasiswa mengunggah ulang jika perlu
    }
}
}