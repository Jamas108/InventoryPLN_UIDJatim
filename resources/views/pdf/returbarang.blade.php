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
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kategori Retur</th>
                <th>Jumlah Retur</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $retur)
                <tr>
                    <td>{{ $retur['Kode_Barang'] }}</td>
                    <td>{{ $retur['Nama_Barang'] }}</td>
                    <td>{{ $retur['Kategori_Retur'] }}</td>
                    <td>{{ $retur['Jumlah_Barang'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
