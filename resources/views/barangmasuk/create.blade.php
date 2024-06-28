@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">

                <div class="d-sm-flex align-items-center justify-content-center mb-4" style="background-color:  rgb(1, 1, 95);">
                    <h1 class="h3 mb-0 text-white"><strong>Masuk</strong></h1>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <form action="{{ route('barangmasuk.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="No Surat Jalan">No Surat jalan</label>
                                        <input type="text" class="form-control" placeholder="Masukan Nomor Surat" id="nosuratjalan" name="nosuratjalan" aria-label="No Surat Jalan" aria-describedby="addon-wrapping">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="namapt">NAMA PT</label>
                                        <input type="text" class="form-control" placeholder="Masukan Nama PT" id="namapt" name="namapt" aria-label="Nama PT" aria-describedby="addon-wrapping">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal">TANGGAL</label>
                                        <input type="text" class="form-control" placeholder="Masukan Tanggal" id="tanggal" name="tanggal" aria-label="Tanggal" aria-describedby="addon-wrapping">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pengirim">PENGIRIM</label>
                                        <input type="text" class="form-control" placeholder="Masukan Nama Pengirim" id="pengirim" name="pengirim" aria-label="Pengirim" aria-describedby="addon-wrapping">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="mt-3 mr-3 btn btn-primary btn-icon-split" style="width: 49%">
                                        <span class="text">Tambahkan Produk</span>
                                    </button>
                                    <a href="#" class="mt-3 btn btn-secondary btn-icon-split" style="width: 49%">
                                        <span class="text">Batal Tambahkan Produk</span>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
