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

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
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
    <h1>Barang Keluar</h1>

    <h2>Networking</h2>
    <table>
        <thead>
            <tr>
                <th>Kategori Barang</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kondisi</th>
                <th>Jumlah Barang Keluar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $id => $barangKeluar)
                @if (isset($barangKeluar['status']) && $barangKeluar['status'] == 'Accepted')
                    @foreach ($barangKeluar['barang'] as $barang)
                        @if ($barang['kategori_barang'] == 'Networking')
                            <tr>
                                <td>{{ $barang['kategori_barang'] }}</td>
                                <td>{{ $barang['kode_barang'] }}</td>
                                <td>{{ $barang['nama_barang'] }}</td>
                                <td>{{ $barang['jenis_barang'] ?? 'N/A' }}</td>
                                <td>{{ $barang['jumlah_barang'] }}</td>
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
                <th>Kondisi</th>
                <th>Jumlah Barang Keluar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $id => $barangKeluar)
                @if (isset($barangKeluar['status']) && $barangKeluar['status'] == 'Accepted')
                    @foreach ($barangKeluar['barang'] as $barang)
                        @if ($barang['kategori_barang'] == 'Hardware')
                            <tr>
                                <td>{{ $barang['kategori_barang'] }}</td>
                                <td>{{ $barang['kode_barang'] }}</td>
                                <td>gambar</td>
                                <td>{{ $barang['nama_barang'] }}</td>
                                <td>{{ $barang['jenis_barang'] ?? 'N/A' }}</td>
                                <td>{{ $barang['jumlah_barang'] }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>

</body>

</html>
