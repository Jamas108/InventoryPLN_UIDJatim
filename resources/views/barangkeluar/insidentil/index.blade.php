@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Barang Keluar</h1>
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                                <i class="fas fa-download fa-sm text-white-50"></i> Download PDF</a>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                                <i class="fas fa-download fa-sm text-white-50"></i> Download Excel</a>
                            <a href="{{ route('barangkeluar.insidentil.create') }}"
                               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Barang Keluar </a>
                        </li>
                    </ul>
                </div>
                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-center align-middle table-hover mb-0" id="ProductTable"
                                   style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 300px; color:white">No. Surat Jalan</th>
                                        <th  scope="col" style="width: 300px; color:white">Berita Acara</th>
                                        <th  scope="col" style="width: 300px; color:white">Pihak Peminjam</th>
                                        <th  scope="col" style="width: 300px; color:white">Tanggal Peminjaman</th>
                                        <th  scope="col" style="width: 300px; color:white">Total Barang</th>
                                        <th  scope="col" style="width: 300px; color:white">Approval Status</th>
                                        <th  scope="col" style="width: 300px; color:white">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($groupedBarangKeluars as $Kode_GrupBarangKeluar => $barangKeluars)
                                        <tr>
                                            <td>{{ $barangKeluars->No_SuratJalanBK }}</td>
                                            <td>
                                                @if (!empty($barangKeluars->File_BeritaAcara))
                                                    <a href="{{ asset('storage/' . $barangKeluars->File_BeritaAcara) }}" class="btn btn-sm btn-info" target="_blank">Lihat Berita Acara</a>
                                                @else
                                                    <span>Tidak Ada</span>
                                                @endif
                                            </td>
                                            <td>{{ $barangKeluars->Nama_PihakPeminjam }}</td>
                                            <td>{{ $barangKeluars->first()->Tanggal_BarangKeluar }}</td>
                                            <td>{{ $barangKeluars->Jumlah_Barang }}</td>
                                            <td>Approved</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-{{ $Kode_GrupBarangKeluar }}"
                                                    aria-expanded="false"
                                                    aria-controls="collapse-{{ $Kode_GrupBarangKeluar }}">
                                                    +
                                                </button>
                                                <a href="{{ route('barangkeluar.buat-berita-acara-insidentil', $Kode_GrupBarangKeluar) }}"
                                                    class="btn btn-primary btn-sm">Buat Berita Acara</a>
                                            </td>
                                        </tr>
                                        <tr id="collapse-{{ $Kode_GrupBarangKeluar }}" class="collapse"
                                            data-bs-parent="#ProductTable">
                                            <td colspan="7">
                                                <div class="accordion-body">
                                                    <table class="table inner-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Kode Barang</th>
                                                                <th>Nama Barang</th>
                                                                <th>Kuantitas</th>
                                                                <th>Kategori Barang</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($barangKeluars as $barangKeluar)
                                                                <tr>
                                                                    <td>{{ $barangKeluar->Kode_Barang }}</td>
                                                                    <td>{{ $barangKeluar->barangMasuk->Nama_Barang }}</td>
                                                                    <td>{{ $barangKeluar->Jumlah_Barang }}</td>
                                                                    <td>{{ $barangKeluar->Kategori_Barang }}</td>
                                                                    <td>
                                                                        <a href="{{ route('retur.create', ['id' => $barangKeluar->id, 'kode_barang' => $barangKeluar->Kode_Barang, 'nama_barang' => $barangKeluar->barangMasuk->Nama_Barang, 'pihak_peminjam' => $barangKeluars->Nama_PihakPeminjam, 'kategori_barang' => $barangKeluar->Kategori_Barang]) }}"
                                                                            class="btn btn-warning btn-sm">Retur Barang</a>
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
                                            <td colspan="10">Tidak ada barang masuk.</td>
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
