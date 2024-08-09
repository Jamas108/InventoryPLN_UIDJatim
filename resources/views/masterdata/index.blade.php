@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-3">
                    <h1 class="h3 mb-0 text-gray-800 mr-5">Master Data</h1>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-bordered table-hover mb-0 datatable" id="ProductTable" style="width: 100%;">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col" style="width: 200px; color:white">ITEM NAME</th>
                                        <th scope="col" style="width: 500px; color:white">DETAILS</th>
                                        <th scope="col" style="width: 150px; color:white">DATE ADDED</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangMasuks as $item)
                                        <tr>
                                            <td>{{ $item->Nama_Barang }}</td>
                                            <td>
                                                Kode Barang : {{ $item->Kode_Barang }}<br>
                                                Kategori Barang : {{ $item->kategoriBarang->Nama_Kategori_Barang }}<br>
                                                Perusahaan Pengirim : {{ $item->NamaPerusahaan_Pengirim }}<br>
                                                Jumlah : {{ $item->JumlahBarang_Masuk }}
                                            </td>
                                            <td class="text-center align-middle">{{ $item->TanggalPengiriman_Barang}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
