<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void // Typo diperbaiki
    {
        $data = [
            ['kode' => 'C1', 'nama_kriteria' => 'Potensi Akademik', 'atribut' => 'benefit', 'bobot' => 0.20],
            ['kode' => 'C2', 'nama_kriteria' => 'Prestasi Non-Akademik', 'atribut' => 'benefit', 'bobot' => 0.10],
            ['kode' => 'C3', 'nama_kriteria' => 'Penghasilan Orang Tua', 'atribut' => 'cost', 'bobot' => 0.25],
            ['kode' => 'C4', 'nama_kriteria' => 'Status Kesejahteraan', 'atribut' => 'benefit', 'bobot' => 0.15],
            ['kode' => 'C5', 'nama_kriteria' => 'Kondisi Khusus', 'atribut' => 'benefit', 'bobot' => 0.10],
            ['kode' => 'C6', 'nama_kriteria' => 'Jumlah Tanggungan', 'atribut' => 'benefit', 'bobot' => 0.10],
            ['kode' => 'C7', 'nama_kriteria' => 'Nilai Kepesantrenan', 'atribut' => 'benefit', 'bobot' => 0.10],
        ];

        foreach ($data as $item) {
            \App\Models\Kriteria::create($item);
        }
    }
}
