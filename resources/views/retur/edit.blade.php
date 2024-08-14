@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Edit Retur Barang</h1>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white rounded shadow p-4">
                        <form action="{{ route('retur.update', ['id' => $returBarang['id']]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="Pihak_Pemohon">Pemohon</label>
                                <input type="text" class="form-control" id="Pihak_Pemohon" name="Pihak_Pemohon"
                                    value="{{ $returBarang['Pihak_Pemohon'] }}" required>
                            </div>
                            <div class="form-group">
                                <label for="Nama_Barang">Nama Barang</label>
                                <input type="text" class="form-control" id="Nama_Barang" name="Nama_Barang"
                                    value="{{ $returBarang['Nama_Barang'] }}" required>
                            </div>
                            <div class="form-group">
                                <label for="Kode_Barang">Kode Barang</label>
                                <input type="text" class="form-control" id="Kode_Barang" name="Kode_Barang"
                                    value="{{ $returBarang['Kode_Barang'] }}" required>
                            </div>
                            <div class="form-group">
                                <label for="Kategori_Barang">Kategori Barang</label>
                                <input type="text" class="form-control" id="Kategori_Barang" name="Kategori_Barang"
                                    value="{{ $returBarang['Kategori_Barang'] }}" required>
                            </div>
                            <div class="form-group">
                                <label for="Jumlah_Barang">Jumlah Barang</label>
                                <input type="number" class="form-control" id="Jumlah_Barang" name="Jumlah_Barang"
                                    value="{{ $returBarang['Jumlah_Barang'] }}" required>
                            </div>
                            <div class="form-group">
                                <label for="Deskripsi">Deskripsi</label>
                                <textarea class="form-control" id="Deskripsi" name="Deskripsi">{{ $returBarang['Deskripsi'] }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="Tanggal_Retur">Tanggal Retur</label>
                                <input type="date" class="form-control" id="Tanggal_Retur" name="Tanggal_Retur"
                                    value="{{ $returBarang['Tanggal_Retur'] }}" required>
                            </div>
                            <div class="form-group">
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
                                        {{ $returBarang['Kategori_Retur'] == 'Bekas Bergaransi' ? 'selected' : '' }}>Bekas
                                        Bergaransi</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
