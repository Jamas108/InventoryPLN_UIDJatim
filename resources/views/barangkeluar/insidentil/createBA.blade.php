@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <h1 class="h3 mb-4 text-gray-800">Buat Berita Acara</h1>

                <form action="{{ route('barangkeluar.storeBeritaAcara') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="Kode_BarangKeluar" value="{{ $Kode_BarangKeluar }}">
                    <input type="text" name="Total_BarangDipinjam" value="{{ $totalBarangDipinjam }}">

                    <div class="mb-3">
                        <label for="Nama_PihakPeminjam" class="form-label">Nama Pihak Peminjam</label>
                        <input type="text" class="form-control" id="Nama_PihakPeminjam" name="Nama_PihakPeminjam" required>
                    </div>

                    <div class="mb-3">
                        <label for="Catatan" class="form-label">Catatan</label>
                        <textarea class="form-control" id="Catatan" name="Catatan"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="File_BeritaAcara" class="form-label">File Berita Acara</label>
                        <input type="file" class="form-control" id="File_BeritaAcara" name="File_BeritaAcara">
                    </div>

                    <div class="mb-3">
                        <label for="File_SuratJalan" class="form-label">File Surat Jalan</label>
                        <input type="file" class="form-control" id="File_SuratJalan" name="File_SuratJalan">
                    </div>

                    <div class="mb-3">
                        <label for="Tanggal_Keluar" class="form-label">Tanggal Keluar</label>
                        <input type="date" class="form-control" id="Tanggal_Keluar" name="Tanggal_Keluar" required>
                    </div>

                    <div class="mb-3">
                        <label for="Tanggal_Kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control" id="Tanggal_Kembali" name="Tanggal_Kembali">
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
