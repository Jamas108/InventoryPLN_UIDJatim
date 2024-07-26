@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')

            <div class="container mt-4">
                <div class="card shadow">
                    <div class="card-header text-white text-center" style="background-color: rgb(1, 1, 95);">
                        <h3 class="mb-0">Detail Barang Rusak</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h2 class="font-weight-bold">{{ $barangrusak->Nama_Barang }}</h2>
                            <h4 class="text-muted">{{ $barangrusak->Kategori_Barang }}</h4>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-md-5 d-flex justify-content-center align-items-center">
                                <img src="{{ asset('images/' . $barangrusak->Gambar) }}" alt="{{ $barangrusak->Nama_Barang }}" class="img-fluid rounded" style="width: 300px;">
                            </div>
                            <div class="col-md-7 mt-4 ">
                                <div class="mb-3">
                                    <h5 class="font-weight-bold">Pihak Pemohon: {{ $barangrusak->Pihak_Pemohon }}</h5>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <h5 class="font-weight-bold">Jumlah Barang: {{ $barangrusak->Jumlah_Barang }} </h5>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <h5 class="font-weight-bold">Tanggal Pengembalian: {{ $barangrusak->Tanggal_Retur }}</h5>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <h5 class="font-weight-bold">Deskripsi: {{ $barangrusak->Deskripsi }}</h5>
                                </div>
                                <hr>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('barangrusak.index') }}" class="btn btn-secondary">
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
