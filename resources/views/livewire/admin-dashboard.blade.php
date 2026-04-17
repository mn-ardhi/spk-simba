<div class="p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Dashboard Eksekutif Kemahasiswaan</h2>
        <p class="text-gray-500 dark:text-gray-400">Ringkasan Sistem Seleksi Beasiswa KIP Kuliah - Periode: <span
                class="font-bold text-blue-600">{{ $periode ? $periode->nama_periode : 'Tidak ada periode' }}</span></p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Pendaftar
            </h3>
            <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">{{ $stats['total'] }} <span
                    class="text-sm font-normal text-gray-500">Orang</span></p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Menunggu
                Validasi</h3>
            <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">{{ $stats['menunggu'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Berkas Valid
            </h3>
            <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">{{ $stats['valid'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ditolak (TMS)
            </h3>
            <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">{{ $stats['ditolak'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div
            class="lg:col-span-1 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 border-b pb-2 dark:border-gray-700">Rasio
                Validasi Berkas</h3>
            <div class="relative h-64 w-full flex justify-center items-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <div
            class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 border-b pb-2 dark:border-gray-700">Top 5
                Kandidat Terbaik (SAW)</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-3 text-center">Rank</th>
                            <th class="px-4 py-3">Nama Pendaftar</th>
                            <th class="px-4 py-3">Program Studi</th>
                            <th class="px-4 py-3 text-right">Skor Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topMahasiswa as $top)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td
                                    class="px-4 py-3 text-center font-bold {{ $top->peringkat == 1 ? 'text-yellow-500 text-lg' : 'text-gray-700 dark:text-gray-300' }}">
                                    #{{ $top->peringkat }}</td>
                                <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">
                                    {{ $top->mahasiswa->nama_lengkap }}</td>
                                <td class="px-4 py-3">{{ $top->mahasiswa->prodi }}</td>
                                <td class="px-4 py-3 text-right font-mono font-bold text-blue-600 dark:text-blue-400">
                                    {{ number_format($top->skor_akhir, 4) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500">Kalkulasi SAW belum
                                    dijalankan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('livewire:initialized', () => {
            const ctx = document.getElementById('statusChart');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Berkas Valid', 'Ditolak', 'Menunggu'],
                    datasets: [{
                        data: [
                            {{ $stats['valid'] }},
                            {{ $stats['ditolak'] }},
                            {{ $stats['menunggu'] }}
                        ],
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.8)', // Hijau
                            'rgba(239, 68, 68, 0.8)', // Merah
                            'rgba(234, 179, 8, 0.8)' // Kuning
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
</div>
