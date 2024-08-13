<!DOCTYPE html>
<html>

<head>
    <title>Berita Acara</title>
</head>

<body>
    <h1>PT PLN (Persero)</h1>
    <h2>Unit Induk Jawa Timur</h2>
    <h3>DIV STI Ops Jatim</h3>

    <h3 style="text-align: center;">BERITA ACARA SERAH TERIMA BARANG</h3>

    <p>Pada hari ini, Tanggal {{ $Tanggal_Keluar }} telah diserahkan dari PT PLN (PERSERO)
        DIV STI OPS JATIM kepada {{ $Nama_PihakPeminjam }} dan harus dikembalikan kepada PT PLN (PERSERO) DIV STI OPS
        JATIM sebelum tanggal dengan rincian
        sebagai berikut :</p>

    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kuantitas</th>
                <th>Kategori Barang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangKeluarList as $barang)
                <tr>
                    <td>{{ $barang['Kode_Barang'] }}</td>
                    <td>{{ $barang['Nama_Barang'] }}</td>
                    <td>{{ $barang['Jumlah_Barang'] }}</td>
                    <td>{{ $barang['Kategori_Barang'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>Demikian Berita Acara Serah Terima Barang ini dibuat untuk dipergunakan seperlunya.</p>

    <table style="width: 100%; margin-top: 100px;">
        <tr>
            <th>Diserahkan Oleh</th>
            <th>Diterima Oleh</th>
        </tr>
        <tr>
            <td style="padding-top: 100px;"></td>
            <td style="padding-top: 100px;"></td>
        </tr>
        <tr>
            <td style="text-align: center;">PT PLN (PERSERO) DIV STI OPS JATIM</td>
            <td style="text-align: center; text-transform: uppercase;">{{ $Nama_PihakPeminjam }}</td>
        </tr>
    </table>
</body>

</html>
