<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Keluar</title>
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
    <h1>Barang Keluar</h1>
    <table>
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kategori Barang</th>
                <th>Jumlah Barang Keluar</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $barang)
                @if(isset($barang['barang']))
                    @foreach($barang['barang'] as $item)
                        <tr>
                            <td>{{ $item['kode_barang'] }}</td>
                            <td>{{ $item['nama_barang'] }}</td>
                            <td>{{ $item['kategori_barang'] }}</td>
                            <td>{{ $item['jumlah_barang'] }}</td>
                            <td>{{ $item['jenis_barang'] ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>
