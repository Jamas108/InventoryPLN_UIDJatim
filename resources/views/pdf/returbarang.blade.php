<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retur Barang</title>
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
    <h1>Retur Barang</h1>
    <table>
        <thead>
            <tr>
                <th>Kategori Barang</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kondisi Barang</th>
                <th>Jumlah Barang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $retur)
                <tr>
                    <td>{{ $retur['kategori_barang'] }}</td>
                    <td>{{ $retur['kode_barang'] }}</td>
                    <td>{{ $retur['nama_barang'] }}</td>
                    <td>{{ $retur['Kategori_Retur'] }}</td>
                    <td>{{ $retur['jumlah_barang'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
