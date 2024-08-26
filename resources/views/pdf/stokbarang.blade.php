<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Stok Barang</h1>
    <table>
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kategori Barang</th>
                <th>Jumlah Barang Masuk</th>
                <th>Jumlah Barang Keluar</th>
                <th>Jumlah Retur Handal</th>
                <th>Jumlah Retur Bergaransi</th>
                <th>Jumlah Retur Rusak</th>
                <th>Stok Barang</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($data as $stok)
                <tr>
                    <tr>
                        <td>{{ $stok['kategori_barang'] }}</td>
                        <td>{{ $stok['kode_barang'] }}</td>
                        <td>{{ $stok['nama_barang'] }}</td>
                        <td>{{ $stok['jumlah_barang_masuk'] }}</td>
                        <td>{{ $stok['jumlah_barang_keluar'] }}</td>
                        <td>{{ $stok['jumlah_retur_handal'] ?? 0 }}</td>
                        <td>{{ $stok['jumlah_retur_bergaransi'] ?? 0 }}</td>
                        <td>{{ $stok['jumlah_retur_rusak'] ?? 0 }}</td>
                        <td>{{ $stok['selisih'] }}</td>
                    </tr>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
