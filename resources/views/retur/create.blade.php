@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <h1 class="h3 mb-4 text-gray-800">Create Retur Barang</h1>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Retur Barang</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('retur.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="Id_Barang_Keluar" class="form-label">ID Barang Keluar</label>
                                <input type="text" class="form-control" id="Id_Barang_Keluar" name="Id_Barang_Keluar"
                                    value="{{ old('Id_Barang_Keluar', request()->query('id')) }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="Id_User" class="form-label">ID User</label>
                                <input type="text" class="form-control" id="Id_User" name="Id_User"
                                    value="{{ Auth::user()->id }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="Id_Status_Retur" class="form-label">Status Retur</label>
                                <select class="form-control" id="Id_Status_Retur" name="Id_Status_Retur">
                                    @foreach ($statusRetur as $status)
                                        <option value="{{ $status->id }}">{{ $status->Nama_Status }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="Id_Jenis_Retur" class="form-label">Jenis Retur</label>
                                <select class="form-control" id="Id_Jenis_Retur" name="Id_Jenis_Retur">
                                    @foreach ($jenisRetur as $jenis)
                                        <option value="{{ $jenis->id }}">{{ $jenis->Jenis_Retur }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="Pihak_Pemohon" class="form-label">Pihak Pemohon</label>
                                <input type="text" class="form-control" id="Pihak_Pemohon" name="Pihak_Pemohon"
                                    value="{{ old('Pihak_Pemohon', request()->query('pihak_peminjam')) }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="Nama_Barang" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" id="Nama_Barang" name="Nama_Barang"
                                    value="{{ old('Nama_Barang', request()->query('nama_barang')) }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="Kode_Barang" class="form-label">Kode Barang</label>
                                <input type="text" class="form-control" id="Kode_Barang" name="Kode_Barang"
                                    value="{{ old('Kode_Barang', request()->query('kode_barang')) }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="Kategori_Barang" class="form-label">Kategori Barang</label>
                                <input type="text" class="form-control" id="Kategori_Barang" name="Kategori_Barang"
                                    value="{{ old('Kategori_Barang', request()->query('kategori_barang')) }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="Jumlah_Barang" class="form-label">Jumlah Barang</label>
                                <input type="number" class="form-control" id="Jumlah_Barang" name="Jumlah_Barang"
                                    value="{{ old('Jumlah_Barang') }}">
                            </div>

                            <div class="mb-3">
                                <label for="Deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="Deskripsi" name="Deskripsi" rows="3">{{ old('Deskripsi') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="Tanggal_Retur" class="form-label">Tanggal Retur</label>
                                <input type="date" class="form-control" id="Tanggal_Retur" name="Tanggal_Retur"
                                    value="{{ old('Tanggal_Retur', date('Y-m-d')) }}">
                            </div>

                            <div class="mb-3">
                                <label for="gambar" class="form-label">Upload Gambar</label>
                                <input type="file" class="form-control" id="Gambar" name="Gambar">
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
