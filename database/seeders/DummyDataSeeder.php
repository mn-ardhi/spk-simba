<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Penilaian;
use App\Models\Periode;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Buat Akun Super Admin Otomatis
        User::firstOrCreate(
            ['email' => 'admin@kampus.com'],
            [
                'name' => 'Super Admin Rektorat',
                'password' => Hash::make('rahasia123'),
                'role' => 'admin'
            ]
        );

        // 2. BUAT DATA PERIODE
        // Membuat 1 periode dummy agar Foreign Key tidak error
        $periode = Periode::firstOrCreate(
            ['id' => 1], // Paksa ID menjadi 1
            [
                'nama_periode' => 'Ganjil 2026/2027',
                'tanggal_mulai' => now(),                     // <-- TAMBAHAN BARU
                'tanggal_akhir' => now()->addMonths(6)        // <-- TAMBAHAN BARU (Opsional, jaga-jaga jika wajib)
            ]
        );

        for ($i = 1; $i <= 20; $i++) {

            // 3. Buat Akun Login Mahasiswa
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
            ]);

            // 4. Buat Data Pendaftaran
            $mahasiswa = Mahasiswa::create([
                'user_id' => $user->id,
                'periode_id' => $periode->id, // Menggunakan ID Periode yang sah dari langkah 2
                'nim' => $faker->unique()->numerify('202###0###'),
                'nama_lengkap' => $user->name,
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'prodi' => $faker->randomElement(['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi', 'Hukum']),
                'status_berkas' => 'valid',
            ]);

            // 5. Buat Nilai Acak untuk Kriteria (C1 - C7)
            Penilaian::create([
                'mahasiswa_id' => $mahasiswa->id,
                'c1' => $faker->randomElement([60, 70, 80, 90, 100]),
                'c2' => $faker->randomElement([60, 80, 100]),
                'c3' => $faker->numberBetween(1000000, 5000000),
                'c4' => $faker->randomElement([60, 80, 100]),
                'c5' => $faker->randomElement([20, 60, 80, 100]),
                'c6' => $faker->numberBetween(1, 6),
                'c7' => $faker->randomElement([20, 60, 80, 100]),
            ]);
        }
    }
}
