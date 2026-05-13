<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8">

            {{-- 1. HEADER WELCOME --}}
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
                Selamat Datang, {{ auth()->user()->name }}! 👋
            </h2>

            {{-- 2. LOGIKA STATUS PENDAFTARAN --}}
            @if (!$mahasiswa)
                {{-- KONDISI: BELUM MENDAFTAR --}}
                <div class="bg-blue-50 dark:bg-gray-700 border-l-4 border-blue-500 p-6 rounded-r-lg shadow-sm">
                    <h3 class="text-lg font-bold text-blue-800 dark:text-blue-300">Status: Belum Mendaftar</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                        Anda belum mengisi formulir pendaftaran beasiswa KIP Kuliah untuk periode aktif. 
                        Silakan lengkapi data diri dan unggah berkas Anda segera.
                    </p>
                    <a href="{{ route('pendaftaran') }}" wire:navigate
                        class="mt-4 inline-block px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow transition transform hover:-translate-y-1">
                        📝 Isi Formulir Pendaftaran Sekarang
                    </a>
                </div>
            @else
                {{-- KONDISI: SUDAH MENDAFTAR --}}
                <div class="space-y-6">
                    
                    {{-- SUB-KONDISI A: MENUNGGU VERIFIKASI --}}
                    @if ($mahasiswa->status_berkas === 'menunggu')
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 p-6 rounded-r-lg shadow-sm">
                            <h3 class="text-lg font-bold text-yellow-800 dark:text-yellow-300">Status: Berkas Sedang Diverifikasi ⏳</h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                                Berkas pendaftaran Anda sudah kami terima dan sedang dalam antrean proses pengecekan oleh admin. 
                                Mohon pantau dashboard ini secara berkala untuk pembaruan status.
                            </p>
                        </div>

                    {{-- SUB-KONDISI B: VALIDASI BERHASIL --}}
                    @elseif ($mahasiswa->status_berkas === 'valid')
                        <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-6 rounded-r-lg shadow-sm">
                            <h3 class="text-lg font-bold text-green-800 dark:text-green-300">Status: Validasi Berkas Berhasil ✅</h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                                Seluruh berkas administrasi Anda dinyatakan sah dan memenuhi kriteria. 
                                Anda berhak lanjut ke tahap pemeringkatan seleksi beasiswa.
                            </p>
                        </div>

                    {{-- SUB-KONDISI C: DITOLAK / TMS (REVISI) --}}
                    @elseif ($mahasiswa->status_berkas === 'ditolak')
                        <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-600 p-6 rounded-r-lg shadow-md">
                            <div class="flex items-start">
                                <div class="shrink-0">
                                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="ml-4 w-full">
                                    <h3 class="text-lg font-bold text-red-800 dark:text-red-300 uppercase tracking-wide">Status: Pendaftaran Ditolak (TMS)</h3>
                                    <p class="mt-1 text-sm text-red-700 dark:text-red-400">
                                        Berkas Anda dinyatakan **Tidak Memenuhi Syarat**. Namun jangan berkecil hati, Anda masih bisa melakukan perbaikan.
                                    </p>
                                    
                                    {{-- BOX CATATAN DARI ADMIN --}}
                                    <div class="mt-4 p-4 bg-white/70 dark:bg-gray-800/60 rounded-xl border border-red-200 dark:border-red-800">
                                        <p class="text-xs font-black text-red-800 dark:text-red-400 uppercase mb-1 tracking-tighter">Pesan dari Admin Penilai:</p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 italic font-medium leading-relaxed">
                                            "{{ $mahasiswa->catatan_admin ?? 'Tidak ada catatan spesifik, silakan hubungi admin via loket.' }}"
                                        </p>
                                    </div>

                                    {{-- TOMBOL REVISI --}}
                                    <div class="mt-5">
                                        <a href="{{ route('pendaftaran') }}" wire:navigate
                                            class="inline-flex items-center px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-extrabold rounded-lg shadow-lg shadow-red-500/30 transition-all transform hover:-translate-y-1 active:scale-95">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Perbaiki & Kirim Ulang Data
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- 3. AREA PENGUMUMAN HASIL AKHIR (SAW) --}}
                    @if ($mahasiswa->status_berkas === 'valid' && $mahasiswa->hasilSeleksi)
                        <div class="mt-8 pt-8 border-t border-gray-100 dark:border-gray-700">
                            <h3 class="text-xl font-black text-gray-800 dark:text-white mb-4">🏆 Pengumuman Hasil Seleksi</h3>
                            
                            <div class="p-6 bg-linear-to-br from-blue-600 to-indigo-700 rounded-3xl text-white shadow-2xl relative overflow-hidden">
                                <div class="relative z-10">
                                    <div class="text-sm uppercase font-bold opacity-80 tracking-widest mb-1">Peringkat Anda</div>
                                    <div class="text-6xl font-extrabold mb-2">#{{ $mahasiswa->hasilSeleksi->peringkat }}</div>
                                    <div class="text-lg font-medium opacity-90">
                                        Skor Kompetensi: <span class="font-mono font-bold">{{ number_format($mahasiswa->hasilSeleksi->skor_akhir * 100, 2, ',', '.') }}%</span>
                                    </div>

                                    @if ($mahasiswa->hasilSeleksi->peringkat <= $mahasiswa->periode->kuota_penerima)
                                        <div class="mt-6 inline-block bg-white text-blue-800 px-8 py-3 rounded-2xl font-black shadow-xl">
                                            🎉 SELAMAT! ANDA LOLOS SELEKSI
                                        </div>
                                        <p class="mt-3 text-xs font-medium opacity-80">* Anda masuk dalam kuota utama {{ $mahasiswa->periode->kuota_penerima }} penerima.</p>
                                    @else
                                        <div class="mt-6 inline-block bg-white/20 backdrop-blur-sm text-white px-8 py-3 rounded-2xl font-bold border border-white/30">
                                            Peringkat Anda berada di luar kuota utama.
                                        </div>
                                        <p class="mt-3 text-xs font-medium opacity-80">* Kuota periode ini terbatas untuk {{ $mahasiswa->periode->kuota_penerima }} orang.</p>
                                    @endif
                                </div>
                                {{-- Dekorasi BG --}}
                                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                            </div>
                        </div>
                    @endif

                </div>
            @endif

        </div>
    </div>
</div>