<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8">

            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
                Selamat Datang, {{ auth()->user()->name }}! 👋
            </h2>

            @if (!$mahasiswa)
                <div class="bg-blue-50 dark:bg-gray-700 border-l-4 border-blue-500 p-6 rounded-r-lg">
                    <h3 class="text-lg font-bold text-blue-800 dark:text-blue-300">Status: Belum Mendaftar</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Anda belum mengisi formulir pendaftaran
                        beasiswa KIP Kuliah untuk periode aktif. Silakan lengkapi data diri dan unggah berkas Anda.</p>
                    <a href="{{ route('pendaftaran') }}"
                        class="mt-4 inline-block px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow transition">
                        📝 Isi Formulir Pendaftaran Sekarang
                    </a>
                </div>
            @else
                <div class="mb-8 border-b border-gray-200 dark:border-gray-700 pb-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nomor Induk Mahasiswa (NIM): <span
                            class="font-bold text-gray-800 dark:text-gray-200">{{ $mahasiswa->nim }}</span></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Program Studi: <span
                            class="font-bold text-gray-800 dark:text-gray-200">{{ $mahasiswa->prodi }}</span></p>
                </div>

                @if ($mahasiswa->status_berkas == 'menunggu')
                    <div class="bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-500 p-6 rounded-r-lg">
                        <h3 class="text-lg font-bold text-yellow-800 dark:text-yellow-400 flex items-center">
                            ⏳ Status: Berkas Sedang Dievaluasi
                        </h3>
                        <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Pendaftaran Anda telah kami terima.
                            Saat ini panitia Rektorat sedang melakukan verifikasi keaslian dokumen Anda. Silakan cek
                            halaman ini secara berkala.</p>
                    </div>
                @elseif($mahasiswa->status_berkas == 'ditolak')
                    <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 p-6 rounded-r-lg">
                        <h3 class="text-lg font-bold text-red-800 dark:text-red-400 flex items-center">
                            ❌ Status: Pendaftaran Ditolak (TMS)
                        </h3>
                        <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Mohon maaf, berdasarkan hasil
                            verifikasi, berkas pendaftaran Anda dinyatakan Tidak Memenuhi Syarat (TMS) atau dokumen yang
                            diunggah tidak sah/buram.</p>
                    </div>
                @elseif($mahasiswa->status_berkas == 'valid')
                    <div class="bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 p-6 rounded-r-lg mb-6">
                        <h3 class="text-lg font-bold text-green-800 dark:text-green-400 flex items-center">
                            ✅ Status: Berkas Valid & Lolos Seleksi Tahap 1
                        </h3>
                        <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Selamat! Berkas Anda dinyatakan valid.
                            Data Anda saat ini sedang dalam proses pemeringkatan menggunakan sistem perhitungan
                            otomatis.</p>
                    </div>

                    <!-- @if ($hasil)
                        <div
                            class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 text-white text-center">
                            <h4 class="text-sm uppercase tracking-wider font-semibold opacity-80 mb-2">Peringkat
                                Kelulusan Akhir</h4>
                            <div class="text-6xl font-extrabold mb-2">#{{ $hasil->peringkat }}</div>
                            <div class="text-lg font-medium opacity-90">Skor Kompetensi: <span
                                    class="font-mono font-bold">{{ number_format($hasil->skor_akhir, 4) }}</span></div>

                            @if ($hasil->peringkat <= 10)
                                <div
                                    class="mt-4 inline-block bg-white text-blue-800 px-6 py-2 rounded-full font-bold shadow-sm">
                                    🎉 SELAMAT! ANDA DINYATAKAN LULUS BEASISWA
                                </div>
                            @else
                                <div
                                    class="mt-4 inline-block bg-white text-gray-800 px-6 py-2 rounded-full font-bold shadow-sm opacity-80">
                                    Mohon maaf, peringkat Anda berada di luar kuota penerimaan.
                                </div>
                            @endif
                        </div>
                    @endif -->
                    @if ($hasil)
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 text-white text-center">
                            <h4 class="text-sm uppercase tracking-wider font-semibold opacity-80 mb-2">
                                Peringkat Kelulusan Akhir
                            </h4>
                            <div class="text-6xl font-extrabold mb-2">#{{ $hasil->peringkat }}</div>
                            <div class="text-lg font-medium opacity-90">
                                Skor Kompetensi: <span class="font-mono font-bold">{{ number_format($hasil->skor_akhir, 4) }}</span>
                            </div>

                            {{-- Logika Dinamis Berdasarkan Kuota Periode --}}
                            @if ($hasil->peringkat <= $mahasiswa->periode->kuota_penerima)
                                <div class="mt-4 inline-block bg-white text-blue-800 px-6 py-2 rounded-full font-bold shadow-sm">
                                    🎉 SELAMAT! ANDA DINYATAKAN LULUS BEASISWA
                                </div>
                                <p class="mt-2 text-xs opacity-75">* Anda masuk dalam kuota {{ $mahasiswa->periode->kuota_penerima }} penerima terbaik.</p>
                            @else
                                <div class="mt-4 inline-block bg-white text-gray-800 px-6 py-2 rounded-full font-bold shadow-sm opacity-80">
                                    Mohon maaf, peringkat Anda berada di luar kuota penerimaan.
                                </div>
                                <p class="mt-2 text-xs opacity-75">* Kuota penerimaan periode ini adalah {{ $mahasiswa->periode->kuota_penerima }} orang.</p>
                            @endif
                        </div>
                    @endif

                @endif
            @endif

        </div>
    </div>
</div>
