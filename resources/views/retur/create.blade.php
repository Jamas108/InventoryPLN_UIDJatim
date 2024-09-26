@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-center rounded-top mb-0"
                    style="background-color: rgb(1, 1, 95);">
                    <h1 class="h3 mb-0 text-white"><strong>Form Retur Barang</strong></h1>
                </div>

                <div class="card shadow mb-4">

                    <div class="card-body">
                        <form action="{{ route('retur.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="Id_User" class="form-label">ID User</label>
                                    <input type="text" class="form-control" id="Id_User" name="Id_User"
                                        value="{{ Auth::user()->id }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Pihak_Pemohon" class="form-label">Pihak Pemohon</label>
                                    <input type="text" class="form-control" id="Pihak_Pemohon" name="Pihak_Pemohon"
                                        value="{{ $barangKeluar->Nama_PihakPeminjam ?? 'N/A' }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Nama_Barang" class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" id="Nama_Barang" name="Nama_Barang"
                                        value="{{ $nama_barang }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Kode_Barang" class="form-label">Kode Barang</label>
                                    <input type="text" class="form-control" id="Kode_Barang" name="Kode_Barang"
                                        value="{{ $kode_barang }}" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="Kategori_Barang" class="form-label">Kategori Barang</label>
                                    <input type="text" class="form-control" id="Kategori_Barang" name="Kategori_Barang"
                                        value="{{ $kategori_barang }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Nama_Barang" class="form-label">Jumlah Barang Dipinjam</label>
                                    <input type="text" class="form-control" id="test" name="test"
                                        value="{{ $jumlah_barang }}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="Tanggal_Retur" class="form-label">Tanggal Retur</label>
                                    <input type="date" class="form-control" id="Tanggal_Retur" name="Tanggal_Retur"
                                        value="{{ old('Tanggal_Retur', date('Y-m-d')) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Jumlah_Barang" class="form-label">Jumlah Barang Diretur</label>
                                    <input type="number" class="form-control" id="Jumlah_Barang" name="Jumlah_Barang"
                                        value="{{ old('Jumlah_Barang') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="Gambar" class="form-label">Upload Surat Jalan Retur</label>
                                    <input type="file" class="form-control" id="Surat_Retur" name="Surat_Retur">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Gambar" class="form-label">Upload Gambar Barang Diretur</label>
                                    <input type="file" class="form-control" id="Gambar_Retur" name="Gambar_Retur">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="Deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="Deskripsi" name="Deskripsi" rows="3">{{ old('Deskripsi') }}</textarea>
                                </div>
                            </div>
                            {{-- Hidden Form  --}}
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="garansi_barang_awal"
                                    name="garansi_barang_awal" value="{{ $garansi_barang_awal }}" hidden>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="garansi_barang_akhir"
                                    name="garansi_barang_akhir" value="{{ $garansi_barang_akhir }}" hidden>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="barangId" name="barangId"
                                    value="{{ $barangId }}" hidden>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="status" name="status"
                                    value="Pending" hidden>
                            </div>
                            {{-- end hidden form --}}
                    </div>
                    <div class="row ">
                        <div class="col-md-12 mb-3 ml-3">
                            <a href="{{ route('barangkeluar.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection