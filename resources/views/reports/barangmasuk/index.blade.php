@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">

                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Report Barang Masuk</h1>
                    <ul class="list-inline mb-0 float-start">
                        <li class="list-inline-item flex-end">
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                                <i class="fas fa-download fa-sm text-white-50"></i> Download PDF
                            </a>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                                <i class="fas fa-download fa-sm text-white-50"></i> Download Excel
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white rounded shadow p-4">

                        <form method="GET" action="{{ route('indexbarangmasuk') }}" class="mb-4">
                            <div class="row mb-3">
                                <div class="col-md-5 mb-2">
                                    <label for="year" class="form-label">Filter by Year</label>
                                    <select class="form-select" id="year" name="year">
                                        <option value="" {{ request('year') == '' ? 'selected' : '' }}>All Years
                                        </option>
                                        @for ($year = now()->year; $year >= 2000; $year--)
                                            <option value="{{ $year }}"
                                                {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="condition" class="form-label">Filter by Condition</label>
                                    <select class="form-select" id="condition" name="condition">
                                        <option value="" {{ request('condition') == '' ? 'selected' : '' }}>All
                                            Conditions</option>
                                        <option value="baru" {{ request('condition') == 'baru' ? 'selected' : '' }}>Baru
                                        </option>
                                        <option value="bekas" {{ request('condition') == 'bekas' ? 'selected' : '' }}>Bekas
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-1 mb-2 d-flex align-items-end">
                                    <button class="btn btn-primary" type="submit">Filter</button>
                                </div>
                            </div>
                        </form>


                        <div class="table-responsive">
                            <table class="table text-center align-middle table-bordered table-hover mb-0 datatable"
                                id="ProductTable" style="width: 100%">
                                <thead style="background-color: rgb(1, 1, 95);">
                                    <tr style="color: white">
                                        <th scope="col" style="width: 300px;">Nama Barang</th>
                                        <th scope="col" style="width: 300px;">Tanggal Masuk</th>
                                        <th scope="col" style="width: 300px;">Kondisi</th>
                                        <th scope="col" style="width: 300px;">Jumlah Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($groupedBarangMasuks as $noSurat => $barangMasuks)
                                        @foreach ($barangMasuks as $barangMasuk)
                                            <tr>
                                                <td>{{ $barangMasuk->Nama_Barang }}</td>
                                                <td>{{ $barangMasuk->Tanggal_Masuk }}</td>
                                                <td>{{ $barangMasuk->Kondisi_Barang }}</td>
                                                <td>{{ $barangMasuk->JumlahBarang_Masuk }}</td>
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="4">Tidak ada barang masuk.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
