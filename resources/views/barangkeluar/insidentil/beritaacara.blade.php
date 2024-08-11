<!DOCTYPE html>
<html>

<head>
    <title>Berita Acara</title>
</head>

<body>
    PT PLN (Persero)</br>
    Unit Induk Jawa Timur</br>
    DIV STI Ops Jatim</br>

    <h3 style="text-align: center; text-decoration: underline; padding-top: 20px">BERITA ACARA SERAH TERIMA BARANG</h3>

    <p style="text-align: justify;">Pada hari ini, Tanggal {{ $Tanggal_Keluar }} telah diserahkan dari PT PLN (PERSERO)
        DIV STI OPS
        JATIM kepada {{ $Nama_PihakPeminjam }} dan harus dikembalikan kepada PT PLN (PERSERO) DIV STI OPS JATIM sebelum tanggal {{ $Tanggal_PengembalianBarang }} dengan rincian
        sebagai berikut :</p>

    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; padding-top: 20px">
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
                    <td>{{ $barang->Kode_Barang }}</td>
                    <td>{{ $barang->barangMasuk->Nama_Barang }}</td> <!-- Properti dari relasi barangMasuk -->
                    <td>{{ $barang->Jumlah_Barang }}</td>
                    <td>{{ $barang->Kategori_Barang }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>

    <p style="text-align: justify; padding-top: 20px">Demikian Berita Acara Serah Terima Barang ini
        dibuat untuk dipergunakan seperlunya. </p>

    <table style="width: 100%; margin-top: 100px">
        <tr>
            <th>Diserahkan Oleh</th>
            <th>Diterima Oleh</th>
        </tr>
        <tr>
            <td style="padding-top: 100px"></td>
            <td style="padding-top: 100px"></td>
        </tr>
        <tr>
            <td style="text-align: center; width: 50%">PT PLN (PERSERO) DIV STI OPS JATIM</td>
            <td style="text-align: center; width: 50%; text-transform: uppercase">{{ $Nama_PihakPeminjam }}</td>
        </tr>
    </table>

    {{-- <h2>Berita Acara Barang Keluar</h2>
    <p>No Surat Jalan: {{ $No_SuratJalanBK }}</p>
    <p>Catatan: {{ $Catatan }}</p>
    <p>Tanggal Keluar: {{ $Tanggal_Keluar }}</p>

    <h3>Detail Barang:</h3> --}}

</body>

</html>
