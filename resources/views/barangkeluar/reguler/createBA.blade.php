
@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid p-2">

                <form action="{{ route('barangkeluar.storeBeritaAcaraReguler') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="container-fluid">
                        <div class="d-sm-flex align-items-center justify-content-center rounded-top" style="background-color: rgb(1, 1, 95);">
                            <h3 class="h3 mb-0 text-white"><strong>BUAT BERITA ACARA</strong></h3>
                        </div>

                        <div class="bg-white justify-content-between rounded-bottom shadow p-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{-- <label for="Kode_BarangKeluar" class="form-label">Kode Barang Keluar</label> --}}
                                        <input type="text" name="Kode_BarangKeluar" value="{{ $Kode_BarangKeluar }}" hidden>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="No_SuratJalanBK" class="form-label">Nomor Surat Jalan</label>
                                        <input type="text" class="form-control" id="No_SuratJalanBK" name="No_SuratJalanBK">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Nama_PihakPeminjam" class="form-label">Nama Pihak Peminjam</label>
                                        <input type="text" class="form-control" id="Nama_PihakPeminjam" name="Nama_PihakPeminjam" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Catatan" class="form-label">Catatan</label>
                                        <textarea class="form-control" id="Catatan" name="Catatan"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="File_BeritaAcara" class="form-label">File Berita Acara</label>
                                        <input type="file" class="form-control" id="File_BeritaAcara" name="File_BeritaAcara">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="File_SuratJalan" class="form-label">File Surat Jalan</label>
                                        <input type="file" class="form-control" id="File_SuratJalan" name="File_SuratJalan">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Tanggal_Keluar" class="form-label">Tanggal Keluar</label>
                                        <input type="date" class="form-control" id="Tanggal_Keluar" name="Tanggal_Keluar" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-3">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
