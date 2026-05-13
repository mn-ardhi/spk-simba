<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMBA - Pendaftaran KIP Kuliah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 font-sans antialiased selection:bg-blue-500 selection:text-white">

    <nav x-data="{ open: false }"
        class="bg-white/90 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="shrink-0 flex items-center gap-2">
                    <a href="/">
                        <div class="shrink-0 flex items-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                            <span class="ml-2 font-bold text-xl text-gray-900 tracking-tight">Portal <span class="text-blue-600">Beasiswa</span></span>
                        </div>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#syarat-mutlak"
                        class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Syarat Wajib</a>
                    <a href="#kriteria-saw"
                        class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Kriteria
                        Penilaian</a>
                    <a href="#berkas"
                        class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Berkas</a>
                </div>

                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="text-sm font-semibold text-slate-700 hover:text-blue-600">Dasbor Saya</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-semibold text-slate-600 hover:text-blue-600">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="text-sm font-semibold bg-blue-600 text-white px-5 py-2 rounded-full shadow-sm hover:bg-blue-700 hover:shadow transition">Daftar
                            Beasiswa</a>
                    @endauth
                </div>

                <div class="flex items-center md:hidden">
                    <button @click="open = !open" type="button"
                        class="text-slate-500 hover:text-slate-900 focus:outline-none p-2">
                        <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-cloak x-show="open" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-cloak x-show="open" class="md:hidden bg-white border-t border-slate-100 shadow-lg absolute w-full">
            <div class="px-4 pt-2 pb-4 space-y-1">
                <a href="#syarat-mutlak" @click="open = false"
                    class="block px-3 py-2 rounded-md font-medium text-slate-700 hover:text-blue-600 hover:bg-slate-50">Syarat
                    Wajib</a>
                <a href="#kriteria-saw" @click="open = false"
                    class="block px-3 py-2 rounded-md font-medium text-slate-700 hover:text-blue-600 hover:bg-slate-50">Kriteria
                    Penilaian</a>
                <a href="#berkas" @click="open = false"
                    class="block px-3 py-2 rounded-md font-medium text-slate-700 hover:text-blue-600 hover:bg-slate-50">Berkas</a>
                <div class="border-t border-slate-200 pt-4 mt-2">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="block px-3 py-2 font-semibold text-blue-600 hover:bg-slate-50 rounded-md">Dasbor
                            Saya</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="block px-3 py-2 font-medium text-slate-700 hover:bg-slate-50 rounded-md">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="block px-3 py-2 mt-2 text-center font-semibold bg-blue-600 text-white rounded-md hover:bg-blue-700">Daftar
                            KIP-K</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- <section class="relative bg-white pt-20 pb-28 border-b border-slate-200">
        <div class="max-w-5xl mx-auto px-4 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-blue-50 text-blue-600 text-sm font-semibold mb-6 border border-blue-100">Evaluasi KIP Kuliah 2025</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight mb-6 leading-tight">
                Transparansi Seleksi Melalui <br/><span class="text-blue-600">Sistem Pendukung Keputusan</span>
            </h1>
            <p class="mt-4 text-lg text-slate-600 max-w-2xl mx-auto mb-10">
                Pendaftaran dan evaluasi beasiswa Perguruan Tinggi Keagamaan Islam (PTKI) kini lebih objektif menggunakan algoritma Simple Additive Weighting (SAW).
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-8 py-3 rounded-full font-semibold text-lg hover:bg-blue-700 shadow-md transition">Daftar Sekarang</a>
                <a href="#syarat-mutlak" class="bg-white text-slate-700 border border-slate-300 px-8 py-3 rounded-full font-semibold text-lg hover:bg-slate-50 transition">Cek Syarat</a>
            </div>
        </div>
    </section> --}}

    <section class="relative bg-white pt-24 pb-32 overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5">
        </div>
        <div class="relative max-w-5xl mx-auto px-4 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-blue-50 text-blue-600 text-sm font-semibold mb-6 border border-blue-100">
            @if($periodeAktif)
                🚀 Rekrutmen {{ $periodeAktif->nama_periode }} Sedang Berlangsung
            @else
                ⌛ Pendaftaran Saat Ini Sedang Ditutup
            @endif
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 tracking-tight mb-6 leading-tight">
                Lanjutkan Cita-Cita Bersama <span class="text-blue-600 bg-clip-text">KIP Kuliah</span>
            </h1>
            <p class="mt-4 text-lg md:text-xl text-slate-600 max-w-3xl mx-auto mb-10 leading-relaxed">
                Sistem Pendukung Keputusan yang transparan dan akurat untuk evaluasi kelayakan penerima beasiswa
                Perguruan Tinggi Keagamaan Islam (PTKI).
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}"
                    class="bg-blue-600 text-white px-8 py-3.5 rounded-full font-semibold text-lg hover:bg-blue-700 shadow-lg hover:shadow-blue-500/30 transition transform hover:-translate-y-0.5">Mulai
                    Pendaftaran</a>
                <a href="#syarat-mutlak"
                    class="bg-white text-slate-700 border border-slate-300 px-8 py-3.5 rounded-full font-semibold text-lg hover:bg-slate-50 transition">Pelajari
                    Syarat</a>
            </div>
        </div>
    </section>

    <section id="syarat-mutlak" class="py-16 bg-slate-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-900">Syarat Mutlak (Gerbang Masuk)</h2>
                <p class="mt-2 text-slate-600">Pastikan Anda memenuhi syarat dasar ini. Jika tidak, sistem otomatis
                    menolak (TMS).</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-xl border border-red-100 shadow-sm border-l-4 border-l-red-500">
                    <h3 class="font-bold text-slate-900">1. Tahun Lulus</h3>
                    <p class="text-sm text-slate-600 mt-2">Maksimal 2 tahun sebelum tahun berjalan Periode Pembukaan
                        (Misal: Tahun Periode dibuka pada 2025, maka tahun lulus maksimal 2023).</p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-red-100 shadow-sm border-l-4 border-l-red-500">
                    <h3 class="font-bold text-slate-900">2. Status Aktif</h3>
                    <p class="text-sm text-slate-600 mt-2">Berstatus Mahasiswa Baru & sudah terdaftar aktif di SIAKAD
                        Kampus.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-red-100 shadow-sm border-l-4 border-l-red-500">
                    <h3 class="font-bold text-slate-900">3. Belum Menikah</h3>
                    <p class="text-sm text-slate-600 mt-2">Belum menikah & sanggup tidak menikah selama menerima program
                        KIP.</p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-red-100 shadow-sm border-l-4 border-l-red-500">
                    <h3 class="font-bold text-slate-900">4. Bantuan Ganda</h3>
                    <p class="text-sm text-slate-600 mt-2">Tidak sedang menerima beasiswa lain dari APBN/APBD di saat
                        bersamaan.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="kriteria-saw" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-12 items-start">

                <div class="w-full lg:w-1/3 lg:sticky lg:top-24">
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">Kriteria Penilaian</h2>
                    <p class="text-slate-600 mb-6">Jika lolos seleksi berkas, kami akan merangking pendaftar
                        menggunakan ke-7 parameter ini untuk menentukan yang paling berhak menerima beasiswa.</p>
                </div>

                <div class="w-full lg:w-2/3 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-100 shadow-sm">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-bold text-blue-900">Potensi Akademik (C1)</h4>
                            <span class="text-xs bg-green-200 text-green-800 px-2 py-1 rounded font-bold">Benefit •
                                20%</span>
                        </div>
                        <p class="text-sm text-blue-700">Dilihat dari standar Angka Rata-rata Nilai Rapor atau IPK
                            Awal.</p>
                    </div>

                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-100 shadow-sm">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-bold text-blue-900">Prestasi Non-Akademik (C2)</h4>
                            <span class="text-xs bg-green-200 text-green-800 px-2 py-1 rounded font-bold">Benefit •
                                10%</span>
                        </div>
                        <p class="text-sm text-blue-700">Penilaian berdasarkan tingkat kejuaraan yang diraih.</p>
                    </div>

                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-100 shadow-sm">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-bold text-blue-900">Penghasilan Ortu (C3)</h4>
                            <span class="text-xs bg-red-200 text-red-800 px-2 py-1 rounded font-bold">Cost • 25%</span>
                        </div>
                        <p class="text-sm text-blue-700">Semakin kecil pendapatan, bobot skor sistem semakin tinggi.
                        </p>
                    </div>

                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-100 shadow-sm">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-bold text-blue-900">Status Kesejahteraan (C4)</h4>
                            <span class="text-xs bg-green-200 text-green-800 px-2 py-1 rounded font-bold">Benefit •
                                15%</span>
                        </div>
                        <p class="text-sm text-blue-700">Pemilik KIP, KKS, atau KJP menjadi skala prioritas
                            tertinggi.</p>
                    </div>

                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-100 shadow-sm">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-bold text-blue-900">Kondisi Khusus (C5)</h4>
                            <span class="text-xs bg-green-200 text-green-800 px-2 py-1 rounded font-bold">Benefit •
                                10%</span>
                        </div>
                        <p class="text-sm text-blue-700">Prioritas tambahan bagi mahasiswa Yatim/Piatu.</p>
                    </div>

                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-100 shadow-sm">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-bold text-blue-900">Jumlah Tanggungan (C6)</h4>
                            <span class="text-xs bg-green-200 text-green-800 px-2 py-1 rounded font-bold">Benefit •
                                10%</span>
                        </div>
                        <p class="text-sm text-blue-700">Makin banyak anggota keluarga ditanggung, skor makin besar.
                        </p>
                    </div>

                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-100 shadow-sm sm:col-span-2">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-bold text-blue-900">Nilai Kepesantrenan (C7)</h4>
                            <span class="text-xs bg-green-200 text-green-800 px-2 py-1 rounded font-bold">Benefit •
                                10%</span>
                        </div>
                        <p class="text-sm text-blue-700">Kesiapan pembinaan asrama pesantren sesuai ciri khas PTP
                            Kemenag.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="berkas" class="py-16 bg-slate-900 text-white border-t border-slate-800">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Siapkan Berkas Berikut Sebelum Mendaftar</h2>
                <p class="text-slate-400">Pastikan dokumen dipindai (di-*scan*) dengan jelas dalam format PDF atau JPG
                    maksimal 2MB per *file*.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-slate-800 p-6 rounded-xl border border-slate-700">
                    <h3 class="text-lg font-bold text-green-400 mb-4 border-b border-slate-700 pb-2">Berkas Utama
                        (Wajib)</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <span class="text-green-400 mr-2 mt-0.5">✔</span>
                            <span class="text-sm text-slate-300"><strong>KTP & Kartu Keluarga (KK).</strong></span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-400 mr-2 mt-0.5">✔</span>
                            <span class="text-sm text-slate-300"><strong>Ijazah & Transkrip Nilai Terakhir</strong>
                                : Sebagai bukti Rata-rata Nilai untuk kriteria C1.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-400 mr-2 mt-0.5">✔</span>
                            <span class="text-sm text-slate-300"><strong>Pakta Integritas</strong>
                                <a href="{{ Storage::url('syarat/form-1.pdf') }}" download
                                    class="text-slate-300 hover:underline font-medium">
                                    (Form 1)
                                </a>
                                yang telah ditandatangani Mahasiswa.</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-slate-800 p-6 rounded-xl border border-slate-700">
                    <h3 class="text-lg font-bold text-yellow-400 mb-4 border-b border-slate-700 pb-2">Bukti Ekonomi
                        (Pilih Salah Satu)</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <span class="text-yellow-400 mr-2 mt-0.5">✦</span>
                            <span class="text-sm text-slate-300">Fotokopi KIP / KKS / KJP (Jika memiliki kartu sakti
                                ini).</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-yellow-400 mr-2 mt-0.5">✦</span>
                            <span class="text-sm text-slate-300">Slip Gaji Orang Tua (Maks. Rp 4.000.000/bulan).</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-yellow-400 mr-2 mt-0.5">✦</span>
                            <span class="text-sm text-slate-300">
                                Surat Keterangan Penghasilan
                                <a href="{{ Storage::url('syarat/form-4.pdf') }}" download
                                    class="text-slate-300 hover:underline font-medium">
                                    (Form 4)
                                </a>
                                jika tidak ada slip gaji.
                            </span>
                        </li>
                    </ul>
                </div>

                <div class="bg-slate-800 p-6 rounded-xl border border-slate-700">
                    <h3 class="text-lg font-bold text-blue-400 mb-4 border-b border-slate-700 pb-2">Pendukung (Sesuai
                        Kondisi)</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <span class="text-blue-400 mr-2 mt-0.5">ℹ</span>
                            <span class="text-sm text-slate-300"><strong>Syahadah/Ijazah Pesantren:</strong> Untuk
                                nilai maksimal kriteria Kepesantrenan (C7).</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-400 mr-2 mt-0.5">ℹ</span>
                            <span class="text-sm text-slate-300"><strong>Sertifikat Prestasi/Karya:</strong> Untuk
                                tambahan nilai kriteria C2.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-400 mr-2 mt-0.5">ℹ</span>
                            <span class="text-sm text-slate-300"><strong>Surat Keterangan Kematian:</strong> Khusus
                                pendaftar Yatim/Piatu (Kriteria C5).</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <footer class="bg-black py-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-slate-500 text-sm">&copy; {{ date('Y') }} SIMBA. Sistem Informasi Beasiswa.</p>
        </div>
    </footer>

</body>

</html>
