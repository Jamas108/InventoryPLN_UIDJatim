@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            <a href="{{ route('stokbarang.index') }}" class="btn-lg">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <h1 class="h3 mb-0 text-gray-800 mr-5" style="font-weight: bold">Networking</h1>
                </div>
                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <!-- Filter form -->
                        <form method="GET" action="{{ route('stokbarang.networking.index') }}" class="mb-4">
                            <div class="input-group">
                                <select name="filter" class="form-select" aria-label="Filter">
                                    <option value="">All</option>
                                    <option value="available">Available</option>
                                    <option value="low-stock">Low Stock</option>
                                    <option value="last-stock">Last Stock</option>
                                </select>
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table text-center align-middle  mb-0 datatable"
                                id="ProductTable" style="width: 100%;">
                                <thead style="background-color: rgb(1, 1, 95);">
                                    <tr style="color: white">
                                        <th scope="col" width="400px">ITEM NAME</th>
                                        <th scope="col">QUANTITY</th>
                                        <th scope="col">DATE ADDED</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($networkingBarangMasuks as $barang)
                                        <tr >
                                            <td class="d-flex justify-content-center align-items-center">
                                                <div class="card" style="display: flex; flex-direction: row; align-items: center; width:100%; background-color:transparent; border-color:transparent;">
                                                    <img src="{{ Vite::asset('storage/app/' . $barang->Gambar_Barang) }}"
                                                         class="card-img-top ml-2 rounded" alt="{{ $barang->Nama_Barang }}"
                                                         style="width: 150px; height:120px; object-fit: cover;">
                                                    <div class="card-body" style="margin-left: 10px; text-align: left;">
                                                        <h5 class="card-title"><strong>{{ $barang->Nama_Barang }}</strong></h5>
                                                        Kategori: {{ $barang->kategoriBarang->Nama_Kategori_Barang }}<br>
                                                        Kode: {{ $barang->Kode_Barang }}<br>
                                                        Kondisi: {{ $barang->Kondisi_Barang }}<br>
                                                        Garansi: {{ $barang->Garansi_Barang }} Bulan<br>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle" >
                                                @if ($barang->JumlahBarang_Masuk > 50)
                                                    <span class="badge bg-success" >{{ $barang->JumlahBarang_Masuk }} Available</span>
                                                @elseif($barang->JumlahBarang_Masuk > 20)
                                                    <span class="badge bg-warning" >{{ $barang->JumlahBarang_Masuk }} Low Stock</span>
                                                @else
                                                    <span class="badge bg-danger" >{{ $barang->JumlahBarang_Masuk }} Last Stock</span>
                                                @endif
                                            </td>

                                            <td class="text-center align-middle">{{ $barang->Tanggal_Masuk }}</td>
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
