<!DOCTYPE html>
<html>
<head>
    <title>Report Barang Keluar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Report Barang Keluar</h2>
    <table>
        <thead>
            <tr>
                <th>No Surat Jalan</th>
                <th>Nama Barang</th>
                <th>Nama Pihak Peminjam</th>
                <th>Tanggal Keluar</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($groupedBarangKeluars as $noSuratJalanBK => $barangKeluars)
                @foreach ($barangKeluars as $barangKeluar)
                    <tr>
                        <td>{{ $barangKeluar->No_SuratJalanBK }}</td>
                        <td>{{ $barangKeluar->barangMasuk->Nama_Barang }}</td>
                        <td>{{ $barangKeluar->Nama_PihakPeminjam }}</td>
                        <td>{{ $barangKeluar->Tanggal_BarangKeluar }}</td>
                        <td>{{ $barangKeluar->Jumlah_Barang }}</td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="6">Tidak ada barang keluar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
