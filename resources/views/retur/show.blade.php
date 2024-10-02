@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Detail Barang Retur</h1>
                    <a href="{{ route('retur.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
                <div class="bg-white rounded shadow p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Pihak Pemohon</label>
                            <input type="text" class="form-control" value="{{ $BarangRetur['Pihak_Pemohon'] }}" readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control" value="{{ $BarangRetur['nama_barang'] }}" readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label>Kode Barang</label>
                            <input type="text" class="form-control" value="{{ $BarangRetur['kode_barang'] }}" readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label>Jumlah Barang Diretur</label>
                            <input type="text" class="form-control" value="{{ $BarangRetur['jumlah_barang'] }}" readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label>Kategori Barang</label>
                            <input type="text" class="form-control" value="{{ $BarangRetur['kategori_barang'] }}"
                                readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label>Deskripsi Retur</label>
                            <input type="text" class="form-control" value="{{ $BarangRetur['Deskripsi'] }}" readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label>Waktu Retur</label>
                            <input type="text" class="form-control" value="{{ $BarangRetur['Tanggal_Retur'] }}" readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label>Status Retur</label>
                            <input type="text" class="form-control" value="{{ $BarangRetur['status'] }}" readonly>
                        </div>
                        <div class="col-md-6 mt-4">
                            @if (!empty($BarangRetur['Surat_Retur']))
                                <a class="btn btn-primary col-md-12" href="{{ $BarangRetur['Surat_Retur'] }}"
                                    target="_blank">Lihat Surat
                                    Retur</a>
                            @else
                                <div class="justify-content-center align-items-center">
                                    <span>Tidak Ada</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 mt-4">
                            @if (!empty($BarangRetur['Gambar_Retur']))
                                <a class="btn btn-primary col-md-12" href="{{ $BarangRetur['Gambar_Retur'] }}"
                                    target="_blank">Lihat Gambar
                                    Retur</a>
                            @else
                                <div class="justify-content-center align-items-center">
                                    <span>Tidak Ada</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
