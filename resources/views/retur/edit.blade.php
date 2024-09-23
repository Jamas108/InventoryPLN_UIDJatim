@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Kelola Retur Barang</h1>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white rounded shadow pt-4 px-4">
                        <h1 class="text-center h3 mb-0 text-gray-800">Informasi Barang Retur</h1>

                        <!-- Container for Image and Form Fields -->

                        <!-- Form Fields Section -->
                        <div class="flex-grow-1 mt-3">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="Pihak_Pemohon">Pemohon</label>
                                    <input type="text" class="form-control" id="Pihak_Pemohon" name="Pihak_Pemohon"
                                        value="{{ $returBarang['Pihak_Pemohon'] }}" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="Nama_Barang">Nama Barang</label>
                                    <input type="text" class="form-control" id="Nama_Barang" name="Nama_Barang"
                                        value="{{ $returBarang['nama_barang'] }}" readonly>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="Kode_Barang">Kode Barang</label>
                                    <input type="text" class="form-control" id="Kode_Barang" name="Kode_Barang"
                                        value="{{ $returBarang['kode_barang'] }}" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="Kategori_Barang">Kategori Barang</label>
                                    <input type="text" class="form-control" id="Kategori_Barang" name="Kategori_Barang"
                                        value="{{ $returBarang['kategori_barang'] }}" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="Jumlah_Barang">Jumlah Barang</label>
                                    <input type="number" class="form-control" id="Jumlah_Barang" name="Jumlah_Barang"
                                        value="{{ $returBarang['jumlah_barang'] }}" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="Tanggal_Retur">Tanggal Retur</label>
                                    <input type="date" class="form-control" id="Tanggal_Retur" name="Tanggal_Retur"
                                        value="{{ $returBarang['Tanggal_Retur'] }}" readonly>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="Sisa_Garansi">Sisa Garansi</label>
                                    <input type="text" class="form-control" id="Sisa_Garansi" name="Sisa_Garansi"
                                        value="{{ $sisaGaransi }}" readonly>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="Deskripsi">Deskripsi</label>
                                    <textarea class="form-control" id="Deskripsi" name="Deskripsi" readonly>{{ $returBarang['Deskripsi'] }}</textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <a href="{{ route('retur.showImage', ['id' => $returBarang['id']]) }}"
                                        class="btn btn-secondary col-md-12">Lihat Gambar</a>
                                </div>
                                <div class="form-group col-md-6">
                                    <a href="{{ route('retur.showSuratJalan', ['id' => $returBarang['id']]) }}"
                                        class="btn btn-primary col-md-12">Lihat Surat Jalan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white rounded shadow p-4">
                        <h1 class="text-center h3 mb-0 text-gray-800">Action Retur Barang</h1>
                        <form action="{{ route('retur.update', ['id' => $returBarang['id']]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="Jumlah_Barang">Jumlah Barang</label>
                                    <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang"
                                        value="{{ $returBarang['jumlah_barang'] }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Kategori_Retur">Kategori Retur</label>
                                    <select name="Kategori_Retur" id="Kategori_Retur" class="form-control">
                                        <option value="" disabled>Select Kategori Retur</option>
                                        <option value="Bekas Handal"
                                            {{ $returBarang['Kategori_Retur'] == 'Bekas Handal' ? 'selected' : '' }}>Bekas
                                            Handal</option>
                                        <option value="Barang Rusak"
                                            {{ $returBarang['Kategori_Retur'] == 'Barang Rusak' ? 'selected' : '' }}>Barang
                                            Rusak</option>
                                        <option value="Bekas Bergaransi"
                                            {{ $returBarang['Kategori_Retur'] == 'Bekas Bergaransi' ? 'selected' : '' }}>
                                            Bekas
                                            Bergaransi</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="status ">Status Retur</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="" disabled>Select Kategori Retur</option>
                                        <option value="Pending"
                                            {{ $returBarang['status'] == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Accepted"
                                            {{ $returBarang['status'] == 'Accepted' ? 'selected' : '' }}>Accept</option>
                                        <option value="Rejected"
                                            {{ $returBarang['status'] == 'Rejected' ? 'selected' : '' }}>
                                            Reject
                                        </option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success col-md-12">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
