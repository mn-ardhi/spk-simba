<div class="min-h-screen bg-slate-50 py-10 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-5xl mx-auto space-y-6">

        @if (session()->has('message'))
            <div
                class="p-4 flex items-center gap-3 text-green-800 bg-green-100 border border-green-200 rounded-2xl shadow-sm font-semibold">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div
                class="p-4 flex items-center gap-3 text-red-800 bg-red-100 border border-red-200 rounded-2xl shadow-sm font-semibold">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-blue-600 rounded-3xl p-8 shadow-lg text-white">
            <h2 class="text-3xl font-black uppercase tracking-tight">Formulir Pendaftaran Beasiswa</h2>
            <p class="mt-2 text-blue-100 font-medium">Pastikan penulisan NIK, Nama Lengkap, Tempat Lahir, dan Nama Ibu
                Kandung sesuai dengan data Dukcapil (KTP/KK).</p>
        </div>

        <form wire:submit.prevent="simpan" class="space-y-8">

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-10">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-6">
                    <span
                        class="flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full font-bold text-sm">1</span>
                    <h3 class="text-xl font-bold text-gray-800">Identitas Pribadi</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">NIK KTP</label>
                        <input type="text" wire:model="nik"
                            class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        @error('nik')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">NISN</label>
                        <input type="text" wire:model="nisn"
                            class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        @error('nisn')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nama Lengkap</label>
                        <input type="text" wire:model="nama_lengkap"
                            class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all uppercase">
                        @error('nama_lengkap')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Tempat Lahir</label>
                        <input type="text" wire:model="tempat_lahir"
                            class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                        @error('tempat_lahir')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Tanggal Lahir</label>
                        <input type="date" wire:model="tanggal_lahir"
                            class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                        @error('tanggal_lahir')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jenis Kelamin</label>
                        <select wire:model="jenis_kelamin"
                            class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nomor WhatsApp</label>
                        <input type="text" wire:model="wa"
                            class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                        @error('wa')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nama Ibu Kandung</label>
                        <input type="text" wire:model="nama_ibu_kandung"
                            class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                        @error('nama_ibu_kandung')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-10">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-6">
                    <span
                        class="flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full font-bold text-sm">2</span>
                    <h3 class="text-xl font-bold text-gray-800">Data Akademik</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">NIM</label>
                        <input type="text" wire:model="nim"
                            class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                        @error('nim')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Program Studi</label>
                        <input type="text" wire:model="prodi"
                            class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                        @error('prodi')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Semester</label>
                        <input type="number" wire:model="semester"
                            class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                        @error('semester')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Tahun Masuk</label>
                        <input type="number" wire:model="tahun_masuk"
                            class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                        @error('tahun_masuk')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nilai Rata-Rata
                            Ijazah</label>
                        <input type="number" step="0.01" max="100" wire:model="nilai_ijazah"
                            class="w-full bg-slate-50 text-blue-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all font-bold">
                        @error('nilai_ijazah')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-10">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-6">
                    <span
                        class="flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full font-bold text-sm">3</span>
                    <h3 class="text-xl font-bold text-gray-800">Alamat Domisili</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Alamat Jalan</label>
                        <textarea wire:model="alamat" rows="2"
                            class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all"></textarea>
                        @error('alamat')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Provinsi</label>
                        <input type="text" wire:model="propinsi"
                            class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                        @error('propinsi')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Kabupaten/Kota</label>
                        <input type="text" wire:model="kabupaten"
                            class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                        @error('kabupaten')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Kecamatan</label>
                        <input type="text" wire:model="kecamatan"
                            class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                        @error('kecamatan')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Kelurahan/Desa</label>
                        <input type="text" wire:model="kelurahan"
                            class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                        @error('kelurahan')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">RT</label>
                            <input type="text" wire:model="rt"
                                class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                            @error('rt')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">RW</label>
                            <input type="text" wire:model="rw"
                                class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                            @error('rw')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Kode Pos</label>
                        <input type="number" wire:model="kode_pos"
                            class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                        @error('kode_pos')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-10">
                <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-6">
                    <span
                        class="flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full font-bold text-sm">4</span>
                    <h3 class="text-xl font-bold text-gray-800">Kriteria & Berkas Dukung</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Penghasilan Orang
                                Tua</label>
                            <input type="number" wire:model="penghasilan_ortu" placeholder="Contoh: 3000000"
                                class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                            @error('penghasilan_ortu')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Prestasi Non-Akademik
                            </label>
                            <input type="text" wire:model="prestasi_non_akademik"
                                placeholder="Contoh: Juara MTQ Internasional"
                                class="w-full bg-slate-50 text-gray-900 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                            @error('prestasi_non_akademik')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div
                            class="space-y-2 p-4 bg-slate-50 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                Status Pesantren
                            </label>


                            <select wire:model="status_pesantren"
                                class="w-full text-gray-900 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:text-white transition shadow-sm cursor-pointer">
                                <option value="">-- Pilih Status Asrama dan Kepesantrenan --</option>
                                <option value="Berasrama dan Alumni Pesantren">Berasrama dan Alumni Pesantren</option>
                                <option value="Berasrama (Bukan Alumni Pesantren)">Berasrama (Bukan Alumni Pesantren)
                                </option>
                                <option value="Tidak Berasrama (Alumni Pesantren)">Tidak Berasrama (Alumni Pesantren)
                                </option>
                                <option value="Tidak Berasrama dan Bukan Alumni Pesantren">Tidak Berasrama dan Bukan
                                    Alumni Pesantren</option>
                            </select>
                            @error('status_pesantren')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div
                            class="space-y-2 p-4 bg-slate-50 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                Kondisi Keluarga </label>
                            <select wire:model="kondisi_keluarga"
                                class="w-full text-gray-900 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:text-white transition shadow-sm cursor-pointer">
                                <option value="">-- Pilih Kondisi Keluarga --</option>
                                <option value="Yatim Piatu dan Terdampak Bencana/Musibah">Yatim Piatu & Terdampak
                                    Bencana/Musibah</option>
                                <option value="Yatim atau Piatu dan Terdampak Bencana/Musibah">Yatim/Piatu & Terdampak
                                    Bencana/Musibah</option>
                                <option value="Yatim Piatu">Yatim Piatu</option>
                                <option value="Yatim atau Piatu">Yatim atau Piatu</option>
                                <option value="Keluarga Lengkap dan Terdampak Bencana/Musibah">Keluarga Lengkap &
                                    Terdampak Bencana/Musibah</option>
                                <option value="Keluarga Lengkap (Tidak Ada Kondisi Khusus)">Keluarga Lengkap (Tidak Ada
                                    Kondisi Khusus)</option>
                            </select>
                            @error('kondisi_keluarga')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                            <label class="block text-xs font-bold text-blue-900 uppercase mb-2">Ijazah & Transkrip
                                Nilai (Max
                                2MB)</label>
                            <input type="file" accept=".pdf,.jpg,.png" wire:model="file_ijazah"
                                class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                            <div wire:loading wire:target="file_ijazah" class="text-xs text-blue-600 mt-2">
                                Mengunggah...
                            </div>
                            @error('file_ijazah')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                            <label class="block text-xs font-bold text-blue-900 uppercase mb-2">Upload KTP (Max
                                2MB)</label>
                            <input type="file" accept=".pdf,.jpg,.png" wire:model="file_ktp"
                                class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                            <div wire:loading wire:target="file_ktp" class="text-xs text-blue-600 mt-2">Mengunggah...
                            </div>
                            @error('file_ktp')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                            <label class="block text-xs font-bold text-blue-900 uppercase mb-2">Upload KK (Max
                                2MB)</label>
                            <input type="file" accept=".pdf,.jpg,.png" wire:model="file_kk"
                                class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                            <div wire:loading wire:target="file_kk" class="text-xs text-blue-600 mt-2">Mengunggah...
                            </div>
                            @error('file_kk')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                            <label class="block text-xs font-bold text-blue-900 uppercase mb-2">Upload KIP/PKH/KJP/SP
                                penghasilan orang tua (Max 2MB)</label>
                            <input type="file" accept=".pdf,.jpg,.png" wire:model="file_kip"
                                class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                            <div wire:loading wire:target="file_kip" class="text-xs text-blue-600 mt-2">Mengunggah...
                            </div>
                            @error('file_kip')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                            <label class="block text-xs font-bold text-blue-900 uppercase mb-2">Upload Sertifikat (Max
                                2MB)</label>
                            <input type="file" accept=".pdf,.jpg,.png" wire:model="bukt_sertifikat"
                                class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                            <div wire:loading wire:target="file_kip" class="text-xs text-blue-600 mt-2">Mengunggah...
                            </div>
                            @error('bukt_sertifikat')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <div class="bg-blue-900 rounded-3xl shadow-2xl p-8 md:p-10 text-white">
                <div class="flex items-start gap-4 mb-8">
                    <div class="mt-1">
                        <input type="checkbox" wire:model.live="setuju_pernyataan"
                            class="w-6 h-6 text-blue-500 border-none rounded focus:ring-0 cursor-pointer bg-white">
                    </div>
                    <div>
                        <p class="text-sm md:text-base leading-relaxed font-medium text-blue-50">
                            "Saya menyatakan dengan sejujur-jujurnya bahwa seluruh data yang saya isikan di atas adalah
                            <strong class="text-white">BENAR</strong> dan <strong class="text-white">SAH</strong>.
                            Saya bersedia menerima sanksi diskualifikasi atau pengembalian dana beasiswa jika di
                            kemudian hari ditemukan pemalsuan data."
                        </p>
                        @error('setuju_pernyataan')
                            <span class="text-red-300 text-sm mt-2 block font-bold">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mt-8">
                    @if($periodeAktif && $periodeAktif->status_otomatis)
                        {{-- Tombol AKTIF jika periode valid --}}
                        <button type="submit" @if (!$setuju_pernyataan) disabled @endif
                            class="w-full py-5 rounded-2xl font-black text-xl uppercase tracking-widest transition-all duration-300 
                            {{ $setuju_pernyataan ? 'bg-yellow-400 text-blue-900 hover:bg-yellow-300 hover:-translate-y-1 shadow-xl shadow-blue-900/50' : 'bg-slate-700 text-slate-500 cursor-not-allowed' }}">
                            Kirim Data Pendaftaran
                        </button>
                    @else
                        {{-- Tampilan jika pendaftaran TUTUP --}}
                        <div class="bg-red-50 border-2 border-red-200 p-6 rounded-2xl text-center shadow-inner group">
                            <div class="inline-flex items-center justify-center w-12 h-12 bg-red-100 text-red-600 rounded-full mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10m11 3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-red-700 font-black text-xl uppercase italic">Akses Pendaftaran Ditutup</p>
                            <p class="text-red-600 text-sm mt-1 font-medium italic opacity-80">
                                Maaf, jadwal pendaftaran untuk periode ini belum tersedia atau telah berakhir.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            

        </form>
    </div>
</div>
