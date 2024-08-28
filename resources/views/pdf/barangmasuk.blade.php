<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Masuk</title>
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

        img {
            width: 100px; /* Ukuran gambar dalam PDF */
            height: auto;
        }
    </style>
</head>

<body>
    <h1>Barang Masuk</h1>

    <h2>Networking</h2>
    <table>
        <thead>
            <tr>
                <th>Kategori Barang</th>
                <th>Kode Barang</th>
                <th>Gambar Barang</th>
                <th>Nama Barang</th>
                <th>Kondisi</th>
                <th>Jumlah Barang Masuk</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $barangMasuk)
                @if (isset($barangMasuk['barang']) && is_array($barangMasuk['barang']))
                    @foreach ($barangMasuk['barang'] as $item)
                        @if (isset($item['Status']) && $item['Status'] === 'Accept' && $item['kategori_barang'] == 'Networking')
                            <!-- Filter Networking -->
                            <tr>
                                <td>{{ $item['kategori_barang'] }}</td>
                                <td>{{ $item['kode_barang'] }}</td>
                                <td>
                                    @if (isset($item['gambar_barang']) && $item['gambar_barang'])
                                        <img src="{{ $item['gambar_barang'] }}" alt="Gambar Barang">
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $item['nama_barang'] }}</td>
                                <td>{{ $item['jenis_barang'] }}</td>
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
                <th>Kondisi</th>
                <th>Jumlah Barang Masuk</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $barangMasuk)
                @if (isset($barangMasuk['barang']) && is_array($barangMasuk['barang']))
                    @foreach ($barangMasuk['barang'] as $item)
                        @if (isset($item['Status']) && $item['Status'] === 'Accept' && $item['kategori_barang'] == 'Hardware')
                            <!-- Filter Hardware -->
                            <tr>
                                <td>{{ $item['kategori_barang'] }}</td>
                                <td>{{ $item['kode_barang'] }}</td>
                                <td><img src="{{ asset('path/to/image/' . $item['gambar_barang']) }}" alt="Gambar Barang" style="width: 100px; height: auto;"></td>

                                <td>{{ $item['nama_barang'] }}</td>
                                <td>{{ $item['jenis_barang'] }}</td>
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
