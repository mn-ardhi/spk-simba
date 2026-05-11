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
                    <th scope="col" class="px-6 py-3">Jurusan</th>
                    <th scope="col" class="px-6 py-3 text-center">Status Berkas</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi Penilaian</th>
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
                        </td>
                        <td class="px-6 py-4 text-center">
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
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.penilaian', $mhs->id) }}" wire:navigate
                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-all duration-300 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 shadow-[0_0_15px_rgba(37,99,235,0.4)] hover:shadow-[0_0_25px_rgba(37,99,235,0.6)] hover:from-blue-500 hover:to-indigo-500 focus:outline-none focus:ring-4 focus:ring-blue-500/50">
                                Buka Halaman Penilaian
                            </a>
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


</div>
