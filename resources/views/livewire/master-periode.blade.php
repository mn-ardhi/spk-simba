<div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
    {{-- Import SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Header & Status Periode Aktif --}}
    {{-- Kita langsung query ke database dari view untuk mencegah error undefined variable --}}
    @php
        $periodeAktif = \App\Models\Periode::where('is_aktif', 1)->first();
    @endphp

    <div class="mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
        <h2 class="text-2xl font-black text-gray-800 dark:text-gray-100">
            Manajemen Periode Beasiswa
        </h2>
        <p class="text-md mt-2 text-gray-600 dark:text-gray-400">
            Periode Aktif Saat Ini:
            @if ($periodeAktif)
                <span
                    class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                    <span class="w-2 h-2 inline-block bg-green-500 rounded-full animate-pulse"></span>
                    {{ $periodeAktif->nama_periode }}
                </span>
            @else
                <span
                    class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                    <span class="w-2 h-2 inline-block bg-red-500 rounded-full"></span>
                    Tidak ada periode yang aktif
                </span>
            @endif
        </p>
    </div>

    {{-- Alert Pesan Sukses / Error --}}
    @if (session()->has('pesan'))
        <div
            class="mb-4 px-4 py-3 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-md font-semibold shadow-sm">
            {{ session('pesan') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-4 px-4 py-3 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-md font-semibold shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- Form Input / Edit Periode --}}
    <form wire:submit.prevent="simpanPeriode"
        class="relative overflow-hidden bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xl shadow-slate-200/50 dark:shadow-none rounded-2xl mb-8 transition-all duration-300">

        <div class="absolute top-0 left-0 w-full h-1 bg-linear-to-r from-blue-500 to-cyan-400"></div>

        <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Bagian Header Form --}}
            <div class="col-span-1 md:col-span-2 mb-2">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg">
                        @if ($is_edit)
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white tracking-tight">
                            {{ $is_edit ? 'Edit Data Periode' : 'Tambah Periode Baru' }}
                        </h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                            {{ $is_edit ? 'Perbarui informasi detail untuk master periode ini.' : 'Lengkapi form di bawah untuk membuat master periode baru.' }}
                        </p>
                    </div>
                </div>
                <hr class="mt-6 border-slate-100 dark:border-slate-700/50">
            </div>

            {{-- Input: Nama Periode --}}
            <div class="col-span-1">
                <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Nama Periode <span
                        class="text-red-500">*</span></label>
                <input type="text" wire:model="nama_periode"
                    class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition-all duration-300 placeholder-slate-400"
                    placeholder="Misal: Pendaftaran Genap 2026">
                @error('nama_periode')
                    <span class="text-red-500 text-xs font-medium mt-1.5 flex items-center gap-1"><svg class="w-4 h-4"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg> {{ $message }}</span>
                @enderror
            </div>

            {{-- Input: Kuota Penerima --}}
            <div class="col-span-1">
                <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Kuota Penerima <span
                        class="text-red-500">*</span></label>
                <input type="number" wire:model="kuota_penerima"
                    class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition-all duration-300 placeholder-slate-400"
                    placeholder="Contoh: 150">
                @error('kuota_penerima')
                    <span class="text-red-500 text-xs font-medium mt-1.5 flex items-center gap-1"><svg class="w-4 h-4"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg> {{ $message }}</span>
                @enderror
            </div>

            {{-- Input: Tanggal Mulai --}}
            <div class="col-span-1">
                <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Tanggal Mulai <span
                        class="text-red-500">*</span></label>
                <input type="date" wire:model="tanggal_mulai"
                    class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition-all duration-300">
                @error('tanggal_mulai')
                    <span class="text-red-500 text-xs font-medium mt-1.5 flex items-center gap-1"><svg class="w-4 h-4"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg> {{ $message }}</span>
                @enderror
            </div>

            {{-- Input: Tanggal Akhir --}}
            <div class="col-span-1">
                <label class="block text-sm font-semibold mb-2 text-slate-700 dark:text-slate-300">Tanggal Akhir <span
                        class="text-red-500">*</span></label>
                <input type="date" wire:model="tanggal_akhir"
                    class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900/50 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition-all duration-300">
                @error('tanggal_akhir')
                    <span class="text-red-500 text-xs font-medium mt-1.5 flex items-center gap-1"><svg class="w-4 h-4"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg> {{ $message }}</span>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div
                class="col-span-1 md:col-span-2 flex justify-end gap-3 mt-4 pt-6 border-t border-slate-100 dark:border-slate-700/50">
                @if ($is_edit)
                    <button type="button" wire:click="batalEdit"
                        class="inline-flex items-center justify-center px-6 py-2.5 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 font-semibold rounded-xl transition-all duration-300 hover:shadow-sm focus:ring-2 focus:ring-slate-200">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal Edit
                    </button>
                @endif

                <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-2.5 bg-linear-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all duration-300 transform active:scale-95">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    {{ $is_edit ? 'Simpan Perubahan' : 'Simpan Periode' }}
                </button>
            </div>

        </div>
    </form>

    {{-- Tabel Data --}}
    <div
        class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-4">Nama Periode</th>
                    <th scope="col" class="px-6 py-4 text-center">Kuota</th>
                    <th scope="col" class="px-6 py-4">Tanggal Pendaftaran</th>
                    <th scope="col" class="px-6 py-4 text-center">Status</th>
                    <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($periodes as $p)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                            {{ $p->nama_periode }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $p->kuota_penerima }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs">
                                <span class="text-green-600 font-semibold">Mulai:</span>
                                {{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y') }} <br>
                                <span class="text-red-500 font-semibold">Akhir:</span>
                                {{ \Carbon\Carbon::parse($p->tanggal_akhir)->format('d M Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{-- Logika UI yang bergantung pada is_aktif (1 atau 0) --}}
                            @if ($p->is_aktif == 1)
                                <span
                                    class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full shadow-sm border border-green-200">
                                    OPEN
                                </span>
                            @else
                                <span
                                    class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full shadow-sm border border-red-200">
                                    CLOSED
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">

                                {{-- Tombol Toggle Status --}}
                                <button wire:click="toggleStatus({{ $p->id }})"
                                    class="px-3 py-1 text-xs font-bold text-white rounded-md transition-all shadow-sm
                                {{ $p->is_aktif == 1 ? 'bg-orange-500 hover:bg-orange-600' : 'bg-emerald-500 hover:bg-emerald-600' }}">
                                    {{ $p->is_aktif == 1 ? 'Tutup' : 'Buka' }}
                                </button>

                                {{-- Tombol Edit --}}
                                
                                <button wire:click="editPeriode({{ $p->id }})"
                                    class="px-3 py-1 text-xs font-bold text-white uppercase transition-all bg-yellow-500 rounded-md shadow-sm hover:bg-yellow-600">
                                    Edit
                                </button>

                                {{-- Tombol Hapus dengan SweetAlert & Alpine.js --}}
                                <button type="button"
                                    @click="
                                    Swal.fire({
                                        title: 'Hapus Periode?',
                                        text: 'Data yang dihapus tidak dapat dikembalikan!',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#dc2626',
                                        cancelButtonColor: '#4b5563',
                                        confirmButtonText: 'Ya, Hapus!',
                                        cancelButtonText: 'Batal'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Gunakan $wire bawaan Livewire 3 untuk memanggil fungsi backend
                                            $wire.hapus({{ $p->id }});
                                        }
                                    });
                                "
                                    class="px-3 py-1 text-xs font-bold text-white uppercase transition-all bg-red-600 rounded-md shadow-sm hover:bg-red-700">
                                    Hapus
                                </button>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                                Belum ada data periode yang ditambahkan.
                            </div>
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
