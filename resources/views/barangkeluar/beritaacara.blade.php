<!DOCTYPE html>
<html>

<head>
    <title>Berita Acara</title>
</head>

<body>
    PT PLN (Persero)</br>
    Unit Induk Jawa Timur</br>
    DIV STI Ops Jatim</br>
    Perihal: Pengajuan Peminjaman Barang Insidentil</br>

    <h3 style="text-align: center; padding-top:20px; text-decoration: underline">BERITA ACARA SERAH TERIMA BARANG</h3>
    <p style="text-align: center; margin-top: -15px;">Nomor: {{ $No_SuratJalanBK }}</p>

    <p>Pada hari ini, Tanggal {{ $Tanggal_Keluar_BeritaAcara }} telah diserahkan dari PT PLN (PERSERO)
        DIV STI OPS JATIM kepada {{ $Nama_PihakPeminjam }} dengan kategori peminjaman Insidentil. Tanggal peminjaman barang anda mulai berlaku pada tanggal {{ $tanggal_peminjamanbarang }} hingga tanggal {{ $Tanggal_PengembalianBarang }} . Berikut ini merupakan
        keterangan atau informasi barang yang anda pinjam dari PT PLN (PERSERO) DIV STI OPS JATIM</p>

    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
        <thead>
            <tr>
                <th>No</th>
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
                    <td style="text-align: center">{{ $loop->iteration }}</td>
                    <td style="text-align: center">{{ $barang['Kode_Barang'] }}</td>
                    <td style="text-align: center">{{ $barang['Nama_Barang'] }}</td>
                    <td style="text-align: center">{{ $barang['Jumlah_Barang'] }}</td>
                    <td style="text-align: center">{{ $barang['Kategori_Barang'] }}</td>
                    <td style="text-align: center">{{ $barang['Jenis_Barang'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table></br>

    Catatan:</br>
    {{ $Catatan }}</br>

    <p>Demikian Berita Acara Serah Terima Barang ini dibuat untuk dipergunakan seperlunya.</p>

    <table style="width: 100%; margin-top: 100px;">
        <tr>
            <th>Diserahkan Oleh</th>
            <th>Diterima Oleh</th>
        </tr>
        <tr>
            <td style="text-align: center;"><img src="../resources/assets/qrcode.png" alt="" width="100px" height="100px"></td> 
            <td style="padding-top: 100px;"></td>
        </tr>
        <tr>
            <td style="text-align: center;">PT PLN (PERSERO) DIV STI OPS JATIM</td>
            <td style="text-align: center; text-transform: uppercase;">{{ $Nama_PihakPeminjam }}</td>
        </tr>
    </table>
</body>

</html>
