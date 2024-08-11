<!DOCTYPE html>
<html>

<head>
    <title>Berita Acara</title>
</head>

<body>
    <h2>Berita Acara Barang Keluar</h2>
    <p>No Surat Jalan: {{ $No_SuratJalanBK }}</p>
    <p>Nama Pihak Peminjam: {{ $Nama_PihakPeminjam }}</p>
    <p>Catatan: {{ $Catatan }}</p>
    <p>Tanggal Keluar: {{ $Tanggal_Keluar }}</p>

    <h3>Detail Barang:</h3>
    <table border="1" cellpadding="5" cellspacing="0">
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
</body>

</html>
