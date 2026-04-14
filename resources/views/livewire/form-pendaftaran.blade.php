<div
    class="max-w-4xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md text-gray-900 dark:text-gray-100 transition-colors duration-200">
    <form wire:submit.prevent="simpan" class="space-y-8">

        @if (session()->has('message'))
            <div class="p-4 text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-100 rounded-lg font-medium">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="p-4 text-red-800 bg-red-100 dark:bg-red-900 dark:text-red-100 rounded-lg font-medium">
                {{ session('error') }}
            </div>
        @endif
        <section>
            <p class="text-lg  pb-2 mb-4"> Pastikan penulisan NIK, Nama Lengkap, Tempat Lahir, Tanggal Lahir dan Nama Ibu
                Kandung sesuai dengan penulisan pada data dukcapil (KTP/KK) </p>
            <h3 class="text-lg font-bold border-b pb-2 mb-4">Data Akademik </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <input type="text" wire:model="nim" placeholder="NIM" class="w-full border p-2 rounded">
                    @error('nim')
                        <span class="text-red-500 text-xs mt-1 font-medium block">{{ $message }}</span>
                    @enderror
                </div>

                <input type="text" wire:model="prodi" placeholder="Program Studi" class="border p-2 rounded">
                <input type="number" wire:model="semester" placeholder="Semester" class="border p-2 rounded">
                <input type="number" wire:model="tahun_masuk" placeholder="Tahun Masuk" class="border p-2 rounded">
                <input type="number" step="0.01" wire:model="ipk" placeholder="IPK" class="border p-2 rounded">
            </div>
        </section>

        <section>
            <h3 class="text-lg font-bold border-b pb-2 mb-4">Data Personal</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" wire:model="nik" placeholder="NIK (16 Digit)" class="border p-2 rounded">
                <input type="text" wire:model="nisn" placeholder="NISN (10 Digit)" class="border p-2 rounded">
                <input type="text" wire:model="nama_lengkap" placeholder="Nama Lengkap"
                    class="border p-2 rounded col-span-2">
                <select wire:model="jenis_kelamin" class="border p-2 rounded">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                <input type="text" wire:model="wa" placeholder="No. WhatsApp" class="border p-2 rounded">
                <input type="text" wire:model="nama_ibu_kandung" placeholder="Nama Ibu Kandung"
                    class="border p-2 rounded col-span-2">
            </div>
        </section>

        <section>
            <h3 class="text-lg font-bold border-b pb-2 mb-4">Domisili</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <input type="text" wire:model="propinsi" placeholder="Provinsi"
                    class="border p-2 rounded col-span-2">
                <input type="text" wire:model="kabupaten" placeholder="Kabupaten"
                    class="border p-2 rounded col-span-2">
                <input type="text" wire:model="kecamatan" placeholder="Kecamatan"
                    class="border p-2 rounded col-span-2">
                <input type="text" wire:model="kelurahan" placeholder="Kelurahan"
                    class="border p-2 rounded col-span-2">
                <input type="text" wire:model="rt" placeholder="RT" class="border p-2 rounded">
                <input type="text" wire:model="rw" placeholder="RW" class="border p-2 rounded">
                <input type="text" wire:model="kode_pos" placeholder="Kode Pos"
                    class="border p-2 rounded col-span-2">
                <textarea wire:model="alamat" placeholder="Alamat Lengkap" class="border p-2 rounded col-span-4"></textarea>
            </div>
        </section>
        <section>
            <h3 class="text-lg font-bold border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">Upload Berkas Syarat
            </h3>

            <div class="grid grid-cols-1 gap-6">

                <div class="w-full">
                    <label class="block text-sm font-semibold mb-2">Scan KTP (PDF, Maks 2MB)</label>
                    <input type="file" wire:model="file_ktp"
                        class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm p-2 cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-gray-700 dark:file:text-gray-200">
                    <div wire:loading wire:target="file_ktp"
                        class="text-sm text-blue-600 dark:text-blue-400 mt-2 font-medium">Mengunggah file... mohon
                        tunggu.</div>
                    @error('file_ktp')
                        <span class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-full">
                    <label class="block text-sm font-semibold mb-2">Scan KK (PDF, Maks 2MB)</label>
                    <input type="file" wire:model="file_kk"
                        class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm p-2 cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-gray-700 dark:file:text-gray-200">
                    <div wire:loading wire:target="file_kk"
                        class="text-sm text-blue-600 dark:text-blue-400 mt-2 font-medium">Mengunggah file... mohon
                        tunggu.</div>
                    @error('file_kk')
                        <span class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-full">
                    <label class="block text-sm font-semibold mb-2">Scan Kartu KIP/PKH/KJP/SP penghasilan orang tua
                        (PDF, Maks 2MB)</label>
                    <input type="file" wire:model="file_kip"
                        class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm p-2 cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-gray-700 dark:file:text-gray-200">
                    <div wire:loading wire:target="file_kip"
                        class="text-sm text-blue-600 dark:text-blue-400 mt-2 font-medium">Mengunggah file... mohon
                        tunggu.</div>
                    @error('file_kip')
                        <span class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </section>
        @if ($errors->any())
            <div
                class="p-4 mb-4 text-sm text-red-800 bg-red-100 rounded-lg dark:bg-red-900 dark:text-red-100 font-medium">
                Terjadi kesalahan pada isian Anda:
                <ul class="list-disc pl-5 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold">Kirim
            Pendaftaran</button>
    </form>
</div>
