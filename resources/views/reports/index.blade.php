@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Report anti repot rodok ngepot</h1>
                    <ul class="list-inline mb-0 float-start">
                        <li class="list-inline-item flex-end">
                            <a href="{{ route('reports.barangmasuk.pdf', ['year' => request('year'), 'condition' => request('condition')]) }}"
                                class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                                <i class="fas fa-download fa-sm text-white-50"></i> Download PDF
                             </a>
                        </li>
                    </ul>
                </div>
                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white rounded shadow p-4">

                        <div class="table-responsive mb-4">
                            <h4>Barang Masuk</h4>
                            <table class="table text-center align-middle table-bordered table-hover mb-0 datatable"
                                id="ProductTable" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 300px; color:white">Kategori Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Kode Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Nama Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Kondisi</th>
                                        <th scope="col" style="width: 300px; color:white">Jumlah Barang Masuk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangMasuk as $id => $data)
                                        @foreach ($data['barang'] as $barang)
                                            <tr>
                                                <td>{{ $barang['kategori_barang'] }}</td>
                                                <td>{{ $barang['kode_barang'] }}</td>
                                                <td>{{ $barang['nama_barang'] }}</td>
                                                <td>{{ $barang['jenis_barang'] }}</td>
                                                <td>{{ $barang['jumlah_barang'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive">
                            <h4>Barang Keluar</h4>
                            <table class="table text-center align-middle table-bordered table-hover mb-0 datatable"
                                id="BarangKeluarTable" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 300px; color:white">Kategori Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Kode Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Nama Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Kondisi</th>
                                        <th scope="col" style="width: 300px; color:white">Jumlah barang Keluar</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangKeluar as $id => $data)
                                        @foreach ($data['barang'] as $barang)
                                            <tr>
                                                <td>{{ $barang['kategori_barang'] }}</td>
                                                <td>{{ $barang['kode_barang'] }}</td>
                                                <td>{{ $barang['nama_barang'] }}</td>
                                                <td>{{ $barang['jenis_barang'] ?? 'N/A' }}</td>
                                                <td>{{ $barang['jumlah_barang'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="table-responsive">
                            <h4>Retur Barang</h4>
                            <table class="table text-center align-middle table-bordered table-hover mb-0 datatable"
                                id="ReturBarangTable" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 300px; color:white">Kategori Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Kode Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Nama Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Kondisi Brang</th>
                                        <th scope="col" style="width: 300px; color:white">Jumlah Barang</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if(is_array($returBarang) || is_object($returBarang))
                                        @foreach ($returBarang as $id => $data)
                                            <tr>
                                                <td>{{ $data['Kategori_Barang'] }}</td>
                                                <td>{{ $data['Kode_Barang'] }}</td>
                                                <td>{{ $data['Nama_Barang'] }}</td>
                                                <td>{{ $data['Kategori_Retur'] }}</td>
                                                <td>{{ $data['Jumlah_Barang'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection