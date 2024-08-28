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
    </style>
</head>

<body>
    <h1>Stok Barang</h1>

    <h4>Stok Barang Networking</h4>
    <table>
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Gambar Barang</th>
                <th>Barang Masuk</th>
                <th>Barang Keluar</th>
                <th>Bekas Handal</th>
                <th>Retur Bergaransi</th>
                <th>Barang Rusak</th>
                <th>Stok Barang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stokBarangNetworking as $stok)
                <tr>
                    <td>{{ $stok['kode_barang'] }}</td>
                    <td>{{ $stok['nama_barang'] }}</td>
                    <td>
                        gambar
                    </td>
                    <td>{{ $stok['jumlah_barang_masuk'] }}</td>
                    <td>{{ $stok['jumlah_barang_keluar'] }}</td>
                    <td>{{ $stok['jumlah_retur_handal'] }}</td>
                    <td>{{ $stok['jumlah_retur_bergaransi'] }}</td>
                    <td>{{ $stok['jumlah_retur_rusak'] }}</td>
                    <td>{{ $stok['selisih'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Stok Barang Hardware</h4>
    <table>
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Gambar Barang</th>
                <th>Barang Masuk</th>
                <th>Barang Keluar</th>
                <th>Bekas Handal</th>
                <th>Retur Bergaransi</th>
                <th>Barang Rusak</th>
                <th>Stok Barang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stokBarangHardware as $stok)
                <tr>
                    <td>{{ $stok['kode_barang'] }}</td>
                    <td>{{ $stok['nama_barang'] }}</td>
                    <td>
                        gambar
                    </td>

                    <td>{{ $stok['jumlah_barang_masuk'] }}</td>
                    <td>{{ $stok['jumlah_barang_keluar'] }}</td>
                    <td>{{ $stok['jumlah_retur_handal'] }}</td>
                    <td>{{ $stok['jumlah_retur_bergaransi'] }}</td>
                    <td>{{ $stok['jumlah_retur_rusak'] }}</td>
                    <td>{{ $stok['selisih'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
