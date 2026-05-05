<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div class="space-y-1">
                <a href="{{ route('admin.pendaftar') }}" wire:navigate
                    class="group inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 transition">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Pendaftar
                </a>
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Panel Penilaian
                    Mahasiswa</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Lakukan validasi berkas dan input nilai kriteria SAW
                    secara teliti.</p>
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto">
                <button wire:click="simpanPenilaian"
                    class="flex-1 md:flex-none inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg shadow-blue-500/30 transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Penilaian
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <div class="lg:col-span-7 space-y-6">
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">Profil & Data Akademik</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div class="space-y-1">
                                    <label
                                        class="text-[10px] uppercase font-black text-gray-400 tracking-widest">NIK</label>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $mhs->nik ?? '-' }}
                                    </p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[10px] uppercase font-black text-gray-400 tracking-widest">Nama
                                        Lengkap</label>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $mhs->nama_lengkap }}
                                    </p>
                                </div>
                                <div class="space-y-1">
                                    <label
                                        class="text-[10px] uppercase font-black text-gray-400 tracking-widest">Tempat,
                                        Tgl Lahir</label>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $mhs->tempat_lahir ?? '-' }},
                                        {{ $mhs->tanggal_lahir ? \Carbon\Carbon::parse($mhs->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                    </p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[10px] uppercase font-black text-gray-400 tracking-widest">Nama
                                        Ibu Kandung</label>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $mhs->nama_ibu_kandung ?? '-' }}</p>
                                </div>
                                <div
                                    class="space-y-1 md:col-span-2 border-t border-gray-100 dark:border-gray-700 pt-3 mt-1">
                                    <label class="text-[10px] uppercase font-black text-gray-400 tracking-widest">NIM |
                                        Program Studi</label>
                                    <p class="text-gray-700 dark:text-gray-300 font-medium">{{ $mhs->nim }} <span
                                            class="mx-2 text-gray-300">|</span> {{ $mhs->prodi }}</p>
                                </div>
                                <div
                                    class="space-y-1 md:col-span-2 border-t border-gray-100 dark:border-gray-700 pt-3 mt-1">
                                    <label class="text-[10px] uppercase font-black text-gray-400 tracking-widest">Prestasi Non Akademik </label>
                                    <p class="text-gray-700 dark:text-gray-300 font-medium"> Prestasi : {{ $mhs->prestasi_non_akademik}} 
                                    
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div
                                    class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800">
                                    <label
                                        class="text-[10px] uppercase font-bold text-blue-600 dark:text-blue-400 block mb-1">IPK
                                        / Nilai Rapor</label>
                                    <p class="text-3xl font-black text-blue-700 dark:text-blue-300">
                                        {{ $mhs->nilai_ijazah }}
                                    </p>
                                </div>
                                <div
                                    class="p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800">
                                    <label
                                        class="text-[10px] uppercase font-bold text-emerald-600 dark:text-emerald-400 block mb-1">Penghasilan
                                        Ortu (C3)</label>
                                    <p class="text-xl font-black text-emerald-700 dark:text-emerald-300">Rp
                                        {{ number_format($mhs->penghasilan_ortu, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">Verifikasi Dokumen Pendukung</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            @foreach (['file_ijazah' => 'Kartu Tanda Penduduk','bukt_sertifikat' => 'Sertifikat', 'file_ktp' => 'Kartu Tanda Penduduk', 'file_kk' => 'Kartu Keluarga', 'file_kip' => 'KIP / Bukti DTKS'] as $field => $label)
                                <div class="relative group">
                                    @if ($mhs->$field)
                                        <a href="{{ asset('storage/' . $mhs->$field) }}" target="_blank"
                                            class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-700 hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-all">
                                            <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-500 mb-2"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            <span
                                                class="text-[11px] font-bold text-gray-600 dark:text-gray-400 text-center">{{ $label }}</span>
                                            <span
                                                class="mt-2 text-[10px] bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full opacity-0 group-hover:opacity-100 transition">Klik
                                                untuk Lihat</span>
                                        </a>
                                    @else
                                        <div
                                            class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-dashed border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/50">
                                            <svg class="w-8 h-8 text-gray-200 dark:text-gray-700 mb-2" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 14l2-2m0 0l2 2m-2-2v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            <span
                                                class="text-[11px] font-bold text-gray-300 dark:text-gray-600 text-center italic">Tidak
                                                Ada File</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 space-y-6">
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border-2 border-blue-500/20 p-6 sticky top-8">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white mb-6 flex items-center">
                        <span
                            class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center mr-3 text-sm">7</span>
                        Kriteria Skor SAW
                    </h3>

                    <div class="space-y-5">
                        <div>
                            <label
                                class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Kelayakan
                                Berkas</label>
                            <select wire:model.live="status_berkas"
                                class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-bold">
                                <option value="menunggu">⏳ Menunggu Verifikasi</option>
                                <option value="valid">✅ Berkas Sah (Lanjut Penilaian)</option>
                                <option value="ditolak">❌ Berkas Tidak Valid</option>
                            </select>
                        </div>

                        @if ($status_berkas === 'valid')
                            <div class="pt-4 border-t border-gray-100 dark:border-gray-700 space-y-4">
                                @php
                                    $kriteria = [
                                        'c1' => ['label' => 'C1 - Potensi Akademik', 'desc' => 'IPK/Rapor (Benefit)'],
                                        'c2' => [
                                            'label' => 'C2 - Prestasi Non-Akad',
                                            'options' => [
                                                100 => 'Internasional',
                                                80 => 'Nasional',
                                                60 => 'Provinsi',
                                                40 => 'Kab/Kota',
                                                10 => 'Tidak Ada',
                                            ],
                                        ],
                                        'c3' => ['label' => 'C3 - Penghasilan Ortu', 'desc' => 'Nominal Rupiah (Cost)'],
                                        'c4' => [
                                            'label' => 'C4 - Kesejahteraan',
                                            'options' => [
                                                100 => 'KIP/PKH + DTKS',
                                                80 => 'Hanya KIP/PKH',
                                                60 => 'Hanya DTKS',
                                                40 => 'SKTM',
                                                10 => 'Tidak Ada',
                                            ],
                                        ],
                                        'c5' => [
                                            'label' => 'C5 - Kondisi Khusus',
                                            'options' => [
                                                100 => 'Yatim Piatu & Terdampak Bencana/Musibah',
                                                90 => 'Yatim/Piatu & Terdampak Bencana/Musibah',
                                                80 => 'Yatim Piatu',
                                                70 => 'Yatim atau Piatu',
                                                50 => 'Keluarga Lengkap & Terdampak Bencana/Musibah',
                                                10 => 'Keluarga Lengkap (Tidak Ada Kondisi Khusus)',
                                            ],
                                        ],
                                        'c6' => [
                                            'label' => 'C6 - Jml Tanggungan',
                                            'options' => [
                                                100 => '> 5 Orang',
                                                80 => '4-5 Orang',
                                                60 => '3 Orang',
                                                40 => '2 Orang',
                                                20 => '1 Orang',
                                            ],
                                        ],
                                        'c7' => [
                                            'label' => 'C7 - Kepesantrenan',
                                            'options' => [
                                                100 => 'Berasrama dan Alumni Pesantren',
                                                80 => 'Berasrama (Bukan Alumni Pesantren)',
                                                60 => 'Tidak Berasrama (Alumni Pesantren)',
                                                20 => 'Tidak Berasrama dan Bukan Alumni Pesantren',
                                            ],
                                        ],
                                    ];
                                @endphp

                                @foreach ($kriteria as $key => $data)
                                    <div class="relative">
                                        <label
                                            class="block text-[10px] font-black text-gray-400 uppercase mb-1">{{ $data['label'] }}</label>
                                        @if (isset($data['options']))
                                            <select wire:model="{{ $key }}"
                                                class="w-full rounded-xl border-gray-200 dark:bg-gray-700 dark:border-gray-600 text-sm focus:ring-blue-500 transition-all">
                                                <option value="">-- Pilih Skor --</option>
                                                @foreach ($data['options'] as $val => $txt)
                                                    <option value="{{ $val }}">{{ $txt }} (Skor:
                                                        {{ $val }})</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="number" step="0.01" wire:model="{{ $key }}"
                                                class="w-full rounded-xl border-gray-200 dark:bg-gray-700 dark:border-gray-600 text-sm focus:ring-blue-500"
                                                placeholder="{{ $data['desc'] }}">
                                        @endif
                                        @error($key)
                                            <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        @elseif($status_berkas === 'ditolak')
                            <div
                                class="p-4 bg-red-50 dark:bg-red-900/20 rounded-2xl border border-red-100 dark:border-red-800 text-center">
                                <p class="text-red-700 dark:text-red-400 text-sm font-bold italic underline">Pendaftar
                                    ini telah ditolak. Data nilai tidak akan diproses oleh mesin SAW.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
