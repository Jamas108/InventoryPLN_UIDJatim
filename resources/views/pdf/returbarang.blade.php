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
        h2 {
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <h1>Retur Barang</h1>

    <h2>Networking</h2>
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
                @if($retur['status'] == 'Accept')
                    @foreach($retur['barang'] as $item)
                        @if($item['kategori_barang'] == 'Networking') <!-- Filter Networking -->
                            <tr>
                                <td>{{ $item['kategori_barang'] }}</td>
                                <td>{{ $item['kode_barang'] }}</td>
                                <td>{{ $item['nama_barang'] }}</td>
                                <td>{{ $item['Kategori_Retur'] }}</td>
                                <td>{{ $item['jumlah_barang'] }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>

    <h2>Hardware</h2>
    <table>
        <thead>
            <tr>
                <th>Kategori Barang</th>
                <th>Kode Barang</th>
                <th>Gambar Barang</th>
                <th>Nama Barang</th>
                <th>Kondisi Barang</th>
                <th>Jumlah Barang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $retur)
                @if($retur['status'] == 'Accept')
                    @foreach($retur['barang'] as $item)
                        @if($item['kategori_barang'] == 'Hardware') <!-- Filter Hardware -->
                            <tr>
                                <td>{{ $item['kategori_barang'] }}</td>
                                <td>{{ $item['kode_barang'] }}</td>
                                <td>gambar</td>
                                <td>{{ $item['nama_barang'] }}</td>
                                <td>{{ $item['Kategori_Retur'] }}</td>
                                <td>{{ $item['jumlah_barang'] }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>
