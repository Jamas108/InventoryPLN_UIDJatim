@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">

                <div class="d-sm-flex align-items-center justify-content-center mb-4"
                    style="background-color:  rgb(1, 1, 95);">
                    <h2 class="h3 mb-0 text-white"><strong>FORM BARANG KELUAR REGULER</strong></h2>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-3">
                        <form action="{{ route('barangkeluar.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                {{-- PIHAK PERTAMA --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <p style="font-weight:bolder ">PIHAK PERTAMA</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="No Surat Jalan">NAMA</label>
                                        <input type="text" class="form-control" placeholder="Masukan Nama"
                                            id="namapertama" name="namapertama" aria-label="Nama Pertama"
                                            aria-describedby="addon-wrapping">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="namapt">JABATAN</label>
                                        <input type="text" class="form-control" placeholder="Masukan Jabatan"
                                            id="jabatan" name="jabatan" aria-label="Jabatan"
                                            aria-describedby="addon-wrapping">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="namapt">KODE PEMINJAMAN</label>
                                        <input type="text" class="form-control" placeholder="Masukan Kode Peminjaman"
                                            id="kodepeminjaman" name="kodepeminjaman" aria-label="Kode Peminjaman"
                                            aria-describedby="addon-wrapping">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr style="border: 1px solid #000;">
                                </div>
                                {{-- PIHAK KEDUA --}}
                                <div class="col-md-12 mt-2">
                                    <div class="form-group">
                                        <p style="font-weight:bolder ">PIHAK KEDUA</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tanggal">NAMA</label>
                                        <input type="text" class="form-control" placeholder="Masukan Nama" id="namakedua"
                                            name="namakedua" aria-label="Nama Kedua" aria-describedby="addon-wrapping">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pengirim">ASAL</label>
                                        <input type="text" class="form-control" placeholder="Masukan Asal" id="pengirim"
                                            name="pengirim" aria-label="Pengirim" aria-describedby="addon-wrapping">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pengirim">ALAMAT</label>
                                        <input type="text" class="form-control" placeholder="Masukan Alamat"
                                            id="alamat" name="alamat" aria-label="Alamat"
                                            aria-describedby="addon-wrapping">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr style="border: 1px solid #000;">
                                </div>
                                {{-- SURAT JALANN --}}
                                <div class="col-md-12 mt-2">
                                    <div class="form-group">
                                        <p style="font-weight:bolder ">SURAT JALAN</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tanggal">NO SURAT JALAN</label>
                                        <input type="text" class="form-control" placeholder="Masukan Nomor Surat"
                                            id="nosuratjalankeluar" name="nosuratjalankeluar" aria-label="No Surat Jalan Keluar"
                                            aria-describedby="addon-wrapping">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pengirim">TANGGAL PINJAM</label>
                                        <input type="text" class="form-control" placeholder="Masukan Tanggal"
                                            id="tanggalpinjam" name="tanggalpinjam" aria-label="Tanggal Pinjam"
                                            aria-describedby="addon-wrapping">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pengirim">TANGGAL PENGEMBALIAN</label>
                                        <input type="text" class="form-control" placeholder="Masukan Tanggal"
                                            id="tanggalpengembalian" name="tanggalpengembalian"
                                            aria-label="Tanggal Pengembalian" aria-describedby="addon-wrapping">
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="kategoriPeminjaman">KATEGORI PEMINJAMAN</label>
                                        <select class="custom-select" style="font-weight: bolder" id="kategoriPeminjaman"
                                            name="kategoriPeminjaman">
                                            <option selected disabled>Reguler</option>
                                            {{-- <option value="reguler">Reguler</option>
                                            <option value="insidentil">Insidentil</option> --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="beritaAcara">BERITA ACARA</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="beritaAcara"
                                                name="beritaAcara" accept="application/pdf">
                                            <label class="custom-file-label" for="beritaAcara">Pilih file PDF</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="suratJalan">SURAT JALAN</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="suratJalan"
                                                name="suratJalan" accept="application/pdf">
                                            <label class="custom-file-label" for="suratJalan">Pilih file PDF</label>
                                        </div>
                                    </div>
                                </div>

                                {{-- BUTTON --}}
                                <div class="col-md-12 d-flex justify-content-end">
                                    <a href="{{ route('barangkeluar.index') }}"
                                        class="mt-3 mr-3 btn btn-danger btn-icon-split" style="width: 15%">
                                        <span class="text">Batal</span>
                                    </a>
                                    <button type="submit" class="mt-3 mr-3 btn btn-primary btn-icon-split"
                                        style="width: 15%;">
                                        <span class="text">Save</span>
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
