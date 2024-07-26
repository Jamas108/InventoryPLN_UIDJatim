<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Barang Rusak</title>
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
    <h2>Report Barang Rusak</h2>
    <table>
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kategori Barang</th>
                <th>Jumlah Barang</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($groupedBarangRusaks as $kode => $barangRusakGroup)
                @foreach ($barangRusakGroup as $barangRusak)
                    <tr>
                        <td>{{ $barangRusak->Kode_Barang }}</td>
                        <td>{{ $barangRusak->Nama_Barang }}</td>
                        <td>{{ $barangRusak->Kategori_Barang }}</td>
                        <td>{{ $barangRusak->Jumlah_Barang }}</td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="4">Tidak ada barang rusak.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
