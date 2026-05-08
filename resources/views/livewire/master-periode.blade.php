<div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
    {{-- Import SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6">Manajemen Periode Beasiswa</h2>

    {{-- Alert Pesan --}}
    @if (session()->has('pesan'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded-md">
            {{ session('pesan') }}
        </div>
    @endif

    {{-- Form Input --}}
    <form wire:submit.prevent="simpanPeriode" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 p-6 rounded-lg">
        <div class="col-span-1">
            <label class="block text-sm font-semibold mb-1 text-gray-700 dark:text-gray-300">Nama Periode</label>
            <input type="text" wire:model="nama_periode" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:ring-blue-500 px-4 py-2">
            @error('nama_periode') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>
        <div class="col-span-1">
            <label class="block text-sm font-semibold mb-1 text-gray-700 dark:text-gray-300">Kuota Penerima</label>
            <input type="number" wire:model="kuota_penerima" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:ring-blue-500 px-4 py-2">
            @error('kuota_penerima') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>
        <div class="col-span-1">
            <label class="block text-sm font-semibold mb-1 text-gray-700 dark:text-gray-300">Tanggal Mulai</label>
            <input type="date" wire:model="tanggal_mulai" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:ring-blue-500 px-4 py-2">
            @error('tanggal_mulai') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>
        <div class="col-span-1">
            <label class="block text-sm font-semibold mb-1 text-gray-700 dark:text-gray-300">Tanggal Selesai</label>
            <input type="date" wire:model="tanggal_akhir" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:ring-blue-500 px-4 py-2">
            @error('tanggal_akhir') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>
        <div class="col-span-1 md:col-span-2 text-right mt-2 space-x-2">
            @if($is_edit)
                <button type="button" wire:click="batalEdit" class="px-6 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                    Batal
                </button>
            @endif
            <button type="submit" class="inline-flex items-center justify-center px-6 py-2 text-sm font-medium text-white transition-all duration-300 rounded-lg bg-gradient-to-r {{ $is_edit ? 'from-orange-500 to-yellow-500 focus:ring-orange-500' : 'from-blue-600 to-indigo-600 focus:ring-blue-500' }} shadow-sm focus:outline-none focus:ring-4">
                {{ $is_edit ? 'Update Periode' : 'Simpan Periode' }}
            </button>
        </div>
    </form>

    {{-- Tabel Data --}}
    <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg mb-4">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">Periode</th>
                    <th scope="col" class="px-6 py-3 text-center">Kuota</th>
                    <th scope="col" class="px-6 py-3 text-center">Jadwal</th>
                    <th scope="col" class="px-6 py-3 text-center">Sisa Waktu</th>
                    <th scope="col" class="px-6 py-3 text-center">Status Sistem</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($periodes as $p)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        {{ $p->nama_periode }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-gray-300">
                            {{ $p->kuota_penerima }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center text-xs">
                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y') }}</div>
                        <div class="text-gray-400 dark:text-gray-500 my-0.5">s/d</div>
                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($p->tanggal_akhir)->format('d M Y') }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @php
                            $warnaSisa = 'bg-gray-100 text-gray-800';
                            if($p->sisa_hari > 3) $warnaSisa = 'bg-green-100 text-green-800';
                            if($p->sisa_hari > 0 && $p->sisa_hari <= 3) $warnaSisa = 'bg-yellow-100 text-yellow-800';
                            if($p->sisa_hari <= 0) $warnaSisa = 'bg-red-100 text-red-800';
                        @endphp
                        <span class="px-2.5 py-0.5 rounded text-xs font-medium {{ $warnaSisa }}">
                            {{ $p->sisa_hari > 0 ? $p->sisa_hari . ' Hari' : 'Berakhir' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2.5 py-0.5 rounded text-xs font-medium {{ $p->status_otomatis ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $p->status_otomatis ? 'OPEN' : 'CLOSED' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center space-x-1">
                        {{-- Toggle Status --}}
                        <button wire:click="toggleStatus({{ $p->id }})" class="px-3 py-1 text-xs font-bold text-white uppercase rounded-md {{ $p->is_aktif ? 'bg-red-600 hover:bg-red-700' : 'bg-emerald-600 hover:bg-emerald-700' }}">
                            {{ $p->is_aktif ? 'Closed' : 'Open' }}
                        </button>
                        
                        {{-- Tombol Edit --}}
                        <button wire:click="edit({{ $p->id }})" class="px-3 py-1 text-xs font-bold text-white uppercase rounded-md bg-amber-500 hover:bg-amber-600">
                            Edit
                        </button>

                        {{-- Tombol Hapus dengan SweetAlert via AlpineJS --}}
                        <button type="button" 
                            x-on:click="
                                Swal.fire({
                                    title: 'Hapus Periode Ini?',
                                    text: 'Data yang dihapus tidak dapat dikembalikan!',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#dc2626',
                                    cancelButtonColor: '#4b5563',
                                    confirmButtonText: 'Ya, Hapus!',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $wire.hapus({{ $p->id }})
                                    }
                                })
                            "
                            class="px-3 py-1 text-xs font-bold text-white uppercase rounded-md bg-gray-800 hover:bg-black dark:bg-gray-600 dark:hover:bg-gray-500">
                            Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        Belum ada data periode yang ditambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Link Pagination --}}
    <div class="mt-4">
        {{ $periodes->links() }}
    </div>
</div>