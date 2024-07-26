// resources/views/pdf/suratjalan.blade.php
<!DOCTYPE html>
<html>
<head>
    <title>Surat Jalan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Surat Jalan</h1>
    <table>
        <thead>
            <tr>
                <th>Nama Perusahaan Pengirim</th>
                <th>No Surat Jalan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangMasuks as $barangMasuk)
                <tr>
                    <td>{{ $barangMasuk->NamaPerusahaan_Pengirim }}</td>
                    <td>{{ $barangMasuk->No_Surat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
