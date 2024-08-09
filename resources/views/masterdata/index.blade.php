@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Master Data</h1>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-center align-middle mb-0 datatable" id="ProductTable" style="width: 100%;">
                                <thead style="background-color: #01015F;">
                                    <tr style="color: white;">
                                        <th scope="col" style="width: 15%; color: white">Nama Barang</th>
                                        <th scope="col" style="width: 25%; color: white">Foto Barang</th>
                                        <th scope="col" style="width: 15%; color: white">DETAILS</th>
                                        <th scope="col" style="width: 15%; color: white">DATE ADDED</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangMasuks as $item)
                                        <tr>
                                            <td class="text-center align-middle"><h6 class="card-title">{{ $item->Nama_Barang }}</h6></td>
                                            <td class="text-center align-middle">
                                                <img src="{{ Vite::asset('storage/app/' . $item->Gambar_Barang) }}"
                                                    class="img-fluid rounded" alt="{{ $item->Nama_Barang }}"
                                                    style="max-width: 300px; max-height: 250px; object-fit: cover;">
                                            </td>
                                            <td class="text-start align-middle">
                                                <div class="card-body p-0">
                                                    <p class="mb-1"><strong>Kode Barang:</strong> {{ $item->Kode_Barang }}</p>
                                                    <p class="mb-1"><strong>Kategori Barang:</strong> {{ $item->kategoriBarang->Nama_Kategori_Barang }}</p>
                                                    <p class="mb-1"><strong>Perusahaan Pengirim:</strong> {{ $item->NamaPerusahaan_Pengirim }}</p>
                                                    <p class="mb-0"><strong>Jumlah:</strong> {{ $item->JumlahBarang_Masuk }}</p>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">{{ $item->TanggalPengiriman_Barang }}</td>
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
