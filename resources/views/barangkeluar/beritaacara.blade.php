<!DOCTYPE html>
<html>
<head>
    <title>Berita Acara</title>
</head>
<body>
    PT PLN (Persero)</br>
    Unit Induk Jawa Timur</br>
    DIV STI Ops Jatim</br>
    Perihal: Pengajuan Peminjaman Barang</br>
    Nomor: {{ $No_SuratJalanBK }}

    <h3 style="text-align: center; padding-top:20px; text-decoration: underline">BERITA ACARA SERAH TERIMA BARANG</h3>

    <p>Pada hari ini, Tanggal {{ $tanggal_peminjamanbarang }} telah diserahkan dari PT PLN (PERSERO)
        DIV STI OPS JATIM kepada {{ $Nama_PihakPeminjam }} dengan kategori peminjaman {{$Kategori}}, Berikut ini merupakan keterangan atau informasi barang yang anda pinjam dari PT PLN (PERSERO) DIV STI OPS JATIM</p>

    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kuantitas</th>
                <th>Kategori Barang</th>
                <th>Jenis Barang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangKeluarList as $barang)
                <tr>
                    <td>{{ $barang['Kode_Barang'] }}</td>
                    <td>{{ $barang['Nama_Barang'] }}</td>
                    <td>{{ $barang['Jumlah_Barang'] }}</td>
                    <td>{{ $barang['Kategori_Barang'] }}</td>
                    <td>{{ $barang['Jenis_Barang'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table></br>

    Catatan:</br>
    {{$Catatan}}</br>

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
