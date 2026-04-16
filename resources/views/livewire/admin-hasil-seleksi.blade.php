<div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm">

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Hasil Seleksi & Peringkat (Metode SAW)</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Periode Aktif:
                {{ $periode ? $periode->nama_periode : 'Tidak ada periode aktif' }}</p>
        </div>

        <div>
            <button wire:click="hitungSAW" wire:loading.attr="disabled"
                class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-md transition flex items-center gap-2 focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-800">
                <span wire:loading.remove wire:target="hitungSAW">🧮 Jalankan Kalkulasi SAW</span>
                <span wire:loading wire:target="hitungSAW">⏳ Sedang Menghitung...</span>
            </button>

        </div>
        <div>
            <button wire:click="cetakPDF"
                class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow-md flex items-center gap-2 transition">
                <span>🖨️ Cetak PDF</span>
            </button>
        </div>

    </div>

    @if (session()->has('message'))
        <div
            class="p-4 mb-4 text-sm text-green-800 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-100 font-medium">
            ✅ {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="p-4 mb-4 text-sm text-red-800 bg-red-100 rounded-lg dark:bg-red-900 dark:text-red-100 font-medium">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-4 text-center w-24">Peringkat</th>
                    <th scope="col" class="px-6 py-4">Nama Pendaftar</th>
                    <th scope="col" class="px-6 py-4">NIM / Prodi</th>
                    <th scope="col" class="px-6 py-4 text-center">Skor Akhir (V)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($hasilSeleksi as $hasil)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td
                            class="px-6 py-4 text-center font-extrabold text-lg 
                            {{ $hasil->peringkat == 1 ? 'text-yellow-500' : ($hasil->peringkat == 2 ? 'text-gray-400' : ($hasil->peringkat == 3 ? 'text-amber-600' : 'text-gray-700 dark:text-gray-300')) }}">
                            #{{ $hasil->peringkat }}
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                            {{ $hasil->mahasiswa->nama_lengkap }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="block text-gray-800 dark:text-gray-200">{{ $hasil->mahasiswa->nim }}</span>
                            <span class="text-xs text-gray-500">{{ $hasil->mahasiswa->prodi }}</span>
                        </td>
                        <td
                            class="px-6 py-4 text-center font-mono font-bold text-blue-600 dark:text-blue-400 text-base">
                            {{ number_format($hasil->skor_akhir, 4) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Belum ada hasil kalkulasi.<br>Silakan klik tombol <b>"Jalankan Kalkulasi SAW"</b> di atas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
