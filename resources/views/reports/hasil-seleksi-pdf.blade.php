<!DOCTYPE html>
<html>
<head>
    <title>Laporan Hasil Seleksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2 f2 f2; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN HASIL SELEKSI BEASISWA KIP KULIAH</h2>
        <p>Periode: {{ $periode }} | Tanggal Cetak: {{ $date }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%; text-align: center;">Rank</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Program Studi</th>
                <th style="text-align: center;">Skor Akhir (V)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasil as $h)
            <tr>
                <td style="text-align: center;">{{ $h->peringkat }}</td>
                <td>{{ $h->mahasiswa->nama_lengkap }}</td>
                <td>{{ $h->mahasiswa->nim }}</td>
                <td>{{ $h->mahasiswa->prodi }}</td>
                <td style="text-align: center;">{{ number_format($h->skor_akhir, 4) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak secara sistematis oleh SIPENA</p>
        <br><br>
        <p>( __________________________ )</p>
        <p>Bagian Kemahasiswaan</p>
    </div>
</body>
</html>