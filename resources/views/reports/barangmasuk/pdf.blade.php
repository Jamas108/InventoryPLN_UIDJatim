<!DOCTYPE html>
<html>
<head>
    <title>Report Barang Masuk</title>
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
    <h2>Report Barang Masuk</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Tanggal Masuk</th>
                <th>Kondisi</th>
                <th>Jumlah Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($groupedBarangMasuks as $noSurat => $barangMasuks)
                @foreach ($barangMasuks as $barangMasuk)
                    <tr>
                        <td>{{ $barangMasuk->Nama_Barang }}</td>
                        <td>{{ $barangMasuk->Tanggal_Masuk }}</td>
                        <td>{{ $barangMasuk->Kondisi_Barang }}</td>
                        <td>{{ $barangMasuk->JumlahBarang_Masuk }}</td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="4">Tidak ada barang masuk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
