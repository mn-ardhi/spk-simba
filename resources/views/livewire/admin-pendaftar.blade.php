<div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm">

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Daftar Pendaftar Beasiswa</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Periode Aktif:
                {{ $periode ? $periode->nama_periode : 'Tidak ada periode aktif' }}</p>
        </div>

        <div class="w-full md:w-1/3">
            <input type="text" wire:model.live="search" placeholder="Cari Nama / NIM..."
                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:ring-blue-500 px-4 py-2">
        </div>
    </div>

    <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">Mahasiswa</th>
                    <th scope="col" class="px-6 py-3">Jurusan / IPK</th>
                    <th scope="col" class="px-6 py-3">Status Berkas</th>
                    <th scope="col" class="px-6 py-3 text-right">Aksi Penilaian</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mahasiswas as $mhs)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900 dark:text-white">{{ $mhs->nama_lengkap }}</div>
                            <div class="text-xs">{{ $mhs->nim }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div>{{ $mhs->prodi }}</div>
                            <div class="font-bold text-blue-600 dark:text-blue-400">IPK: {{ $mhs->ipk }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if ($mhs->status_berkas == 'menunggu')
                                <span
                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Menunggu
                                    Validasi</span>
                            @elseif($mhs->status_berkas == 'valid')
                                <span
                                    class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Validasi
                                    Sukses</span>
                            @else
                                <span
                                    class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button wire:click="bukaPanel({{ $mhs->id }})"
                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-all duration-300 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 shadow-[0_0_15px_rgba(37,99,235,0.4)] hover:shadow-[0_0_25px_rgba(37,99,235,0.6)] hover:from-blue-500 hover:to-indigo-500 focus:outline-none focus:ring-4 focus:ring-blue-500/50">
                                Buka Panel
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data pendaftar yang
                            masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($periode)
        <div class="mt-4">
            {{ $mahasiswas->links() }}
        </div>
    @endif
    @if ($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 transition-opacity p-4">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-3xl w-full p-6 mx-auto max-h-[90vh] overflow-y-auto">

                <h3
                    class="text-lg font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-4">
                    Panel Validasi: {{ $nama_lengkap }} (NIM: {{ $nim }} | IPK: {{ $ipk }})
                </h3>

                <div class="space-y-6">
                    <div>
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Dokumen Pendaftar (PDF):
                        </p>
                        <div class="flex flex-wrap gap-3">
                            @if ($file_ktp)
                                <a href="{{ asset('storage/' . $file_ktp) }}" target="_blank"
                                    class="px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-md text-sm font-semibold transition">📄
                                    Cek KTP</a>
                            @endif
                            @if ($file_kk)
                                <a href="{{ asset('storage/' . $file_kk) }}" target="_blank"
                                    class="px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-md text-sm font-semibold transition">📄
                                    Cek KK</a>
                            @endif
                            @if ($file_kip)
                                <a href="{{ asset('storage/' . $file_kip) }}" target="_blank"
                                    class="px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-md text-sm font-semibold transition">📄
                                    Cek KIP / Bukti Pendukung</a>
                            @endif
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <label class="block text-sm font-bold text-gray-800 dark:text-gray-200 mb-2">Keputusan Validasi
                            Berkas:</label>
                        <select wire:model.live="status_berkas"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-blue-500 font-semibold">
                            <option value="menunggu">🟡 Menunggu Validasi</option>
                            <option value="valid">🟢 Valid (Lolos Cek Berkas & Lanjut Penilaian)</option>
                            <option value="ditolak">🔴 Ditolak (Berkas Tidak Sah / Buram)</option>
                        </select>
                    </div>

                    @if ($status_berkas == 'valid')
                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700 transition-all duration-300">
                            <div
                                class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg border border-blue-100 dark:border-gray-600">
                                <h4 class="font-bold text-blue-800 dark:text-blue-300 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                    Input Nilai Kriteria SAW (Skala 1-100)
                                </h4>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300">C1 -
                                            Akademik (Otomatis dari IPK)</label>
                                        <input type="number" wire:model="c1"
                                            class="mt-1 w-full text-sm rounded-md shadow-sm border-gray-300 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                            placeholder="Skor 1-100">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300">C2 -
                                            Prestasi Non-Akademik</label>
                                        <input type="number" wire:model="c2"
                                            class="mt-1 w-full text-sm rounded-md shadow-sm border-gray-300 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                            placeholder="Skor 1-100">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300">C3 -
                                            Penghasilan Orang Tua</label>
                                        <input type="number" wire:model="c3"
                                            class="mt-1 w-full text-sm rounded-md shadow-sm border-gray-300 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                            placeholder="Skor 1-100">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300">C4 -
                                            Status Kesejahteraan</label>
                                        <input type="number" wire:model="c4"
                                            class="mt-1 w-full text-sm rounded-md shadow-sm border-gray-300 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                            placeholder="Skor 1-100">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300">C5 -
                                            Kondisi Khusus</label>
                                        <input type="number" wire:model="c5"
                                            class="mt-1 w-full text-sm rounded-md shadow-sm border-gray-300 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                            placeholder="Skor 1-100">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300">C6 -
                                            Tanggungan Keluarga</label>
                                        <input type="number" wire:model="c6"
                                            class="mt-1 w-full text-sm rounded-md shadow-sm border-gray-300 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                            placeholder="Skor 1-100">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300">C7
                                            -
                                            Nilai Kepesantrenan</label>
                                        <input type="number" wire:model="c7"
                                            class="mt-1 w-full text-sm rounded-md shadow-sm border-gray-300 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                            placeholder="Skor 1-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
                    <button wire:click="tutupPanel"
                        class="px-5 py-2.5 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-semibold transition">Batal</button>
                    <button wire:click="simpanValidasi"
                        class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold shadow-md transition">Simpan
                        Data</button>
                </div>
            </div>
        </div>
    @endif
</div>
