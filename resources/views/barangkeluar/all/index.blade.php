@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">All Barang Keluar</h1>
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download PDF</a>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download Excel</a>
                        </li>
                    </ul>
                </div>
                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-bordered table-hover mb-0 datatable"
                                id="ProductTable" style="100%">
                                <thead style="background-color: rgb(1, 1, 95);">
                                    <tr>
                                        <th scope="col" style="width: 300px; color:white">No. Surat Jalan</th>
                                        <th scope="col" style="width: 300px; color:white">Berita Acara</th>
                                        <th scope="col" style="width: 300px; color:white">Pihak Peminjam</th>
                                        <th scope="col" style="width: 300px; color:white">Tanggal Peminjaman</th>
                                        <th scope="col" style="width: 300px; color:white">Total Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Approval Status</th>
                                        <th scope="col" style="width: 300px; color:white">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupedBarangKeluars as $kodeBarangKeluar => $barangKeluarGroup)
                                        @php
                                            // Mendapatkan item pertama dalam grup untuk menampilkan detail utama
                                            $firstItem = $barangKeluarGroup->first();
                                        @endphp
                                        <tr>
<td>{{str_replace('\\', '/', $firstItem->No_SuratJalanBK) }}</td>
                                            <td>
                                                @if (!empty($firstItem->File_BeritaAcara))
                                                    <a href="{{ asset('storage/' . $firstItem->File_BeritaAcara) }}"
                                                        class="btn btn-sm btn-info" target="_blank">Lihat Berita Acara</a>
                                                @else
                                                    <span>Tidak Ada</span>
                                                @endif
                                            </td>
                                            <td>{{ $firstItem->Nama_PihakPeminjam }}</td>
                                            <td>{{ $firstItem->Tanggal_BarangKeluar }}</td>
                                            <td>{{ $barangKeluarGroup->sum('Jumlah_Barang') }}</td>
                                            <td>Approved</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-{{ $kodeBarangKeluar }}"
                                                    aria-expanded="false"
                                                    aria-controls="collapse-{{ $kodeBarangKeluar }}">
                                                    +
                                                </button>
                                            </td>
                                        </tr>
                                        <tr id="collapse-{{ $kodeBarangKeluar }}" class="collapse"
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
                                                                <th>Status Barang</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($barangKeluarGroup as $barangKeluar)
                                                                <tr>
                                                                    <td>{{ $barangKeluar->Kode_Barang }}</td>
                                                                    <td>{{ $barangKeluar->barangMasuk->Nama_Barang }}</td>
                                                                    <td>{{ $barangKeluar->Jumlah_Barang }}</td>
                                                                    <td>{{ $barangKeluar->Kategori_Barang }}</td>
                                                                    <td> - </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
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
