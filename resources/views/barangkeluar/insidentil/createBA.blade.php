
@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid p-2">

                <form action="{{ route('barangkeluar.storeBeritaAcara') }}" method="POST" enctype="multipart/form-data">
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
                                <div class="col-md-12">
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Tanggal_Keluar" class="form-label">Tanggal Keluar</label>
                                        <input type="date" class="form-control" id="Tanggal_Keluar" name="Tanggal_Keluar" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Tanggal_Kembali" class="form-label">Tanggal Kembali</label>
                                        <input type="date" class="form-control" id="Tanggal_Kembali" name="Tanggal_Kembali">
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
