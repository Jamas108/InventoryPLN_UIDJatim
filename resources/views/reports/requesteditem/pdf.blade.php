<!DOCTYPE html>
<html>
<head>
    <title>Requested Items Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Requested Items Report - {{ $filterYear ?? 'All Years' }}</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Kode Barang</th>
                <th>Total Request</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requestedItems as $item)
                <tr>
                    <td>{{ $item->barangMasuk->Nama_Barang }}</td>
                    <td>{{ $item->Kode_Barang }}</td>
                    <td>{{ $item->total_request }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
