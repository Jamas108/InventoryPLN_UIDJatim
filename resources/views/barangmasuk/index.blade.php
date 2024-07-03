@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Barang Masuk</h1>
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download PDF</a>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download Excel</a>
                            <a href="{{ route('barangmasuk.create') }}"
                                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                    class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Barang </a>
                        </li>
                    </ul>
                </div>
                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-center align-middle table-bordered table-hover mb-0 datatable" id="ProductTable" style="width: 100%">
                                <thead style="background-color: rgb(1, 1, 95);">
                                    <tr style="color: white">
                                        <th scope="col" style="width: 300px;">No. Surat Jalan</th>
                                        <th scope="col" style="width: 300px;">Nama PT</th>
                                        <th scope="col" style="width: 300px;">Total Barang</th>
                                        <th scope="col" style="width: 300px;">Approval Status</th>
                                        <th scope="col" style="width: 250px;">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($groupedBarangMasuks as $noSurat => $barangMasuks)
                                        <tr>
                                            <td>{{ $noSurat }}</td>
                                            <td>{{ $barangMasuks->first()->NamaPerusahaan_Pengirim }}</td>
                                            <td>{{ $barangMasuks->sum('Jumlah_barang') }}</td>
                                            <td>Approved</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $noSurat }}" aria-expanded="false" aria-controls="collapse-{{ $noSurat }}">
                                                    +
                                                </button>
                                            </td>
                                        </tr>
                                        <tr id="collapse-{{ $noSurat }}" class="collapse" data-bs-parent="#ProductTable">
                                            <td colspan="5">
                                                <div class="accordion-body">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Kode Barang</th>
                                                                <th>Nama Barang</th>
                                                                <th>Kuantitas</th>
                                                                <th>Kategori Barang</th>
                                                                <th>Status Barang</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($barangMasuks as $barangMasuk)
                                                                <tr>
                                                                    <td>{{ $barangMasuk->Kode_Barang }}</td>
                                                                    <td>{{ $barangMasuk->Nama_Barang }}</td>
                                                                    <td>{{ $barangMasuk->JumlahBarang_Masuk }}</td>
                                                                    <td>{{ $barangMasuk->kategoriBarang->Nama_Kategori_Barang }}</td>
                                                                    <td>
                                                                        <form action="{{ route('barangmasuk.update', $barangMasuk->id) }}" method="POST" class="d-flex align-items-center">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <select name="Id_Status_Barang" class="form-select form-select-sm me-1" aria-label="Ubah Status">
                                                                                @foreach($statusBarangs as $statusBarang)
                                                                                <option value="{{ $statusBarang->id }}" {{ $barangMasuk->Id_Status_Barang == $statusBarang->id ? 'selected' : '' }}>
                                                                                    {{ $statusBarang->Nama_Status }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i></button>
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <a href="" class="btn btn-primary btn-sm">Edit Barang Masuk</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">Tidak ada barang masuk.</td>
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
