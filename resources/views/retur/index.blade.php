@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Retur Barang</h1>
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download PDF</a>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download Excel</a>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                    class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Product</a> --}}
                        </li>
                    </ul>
                </div>
                <div class="container-fluid pt-2 px-2 vh-50 d-grid" style="grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                    <div class="card p-0" style="background-color: transparent; border: none;">
                        <img src="{{ Vite::asset('../resources/assets/hardware.jpg') }}" class="rounded" alt="Autumn Logo"
                            style="object-fit: cover; width: 100%; height: 50vh;">
                        <div class="card-img-overlay d-flex justify-content-between flex-column">
                            <div style="align-self: flex-start; color:white">
                                <h6 class="card-text">CATALOG</h6>
                                <h3 class="card-title" style="font-weight: 800">Bekas Bergaransi</h3>
                            </div>
                            <a href="{{ route('retur.bergaransi.index') }}" class="btn btn-primary" style="align-self: flex-end;">See Details</a>
                        </div>
                    </div>

                    <div class="card p-0" style="background-color: transparent; border: none;">
                        <img src="{{ Vite::asset('../resources/assets/network.jpg') }}" class="rounded" alt="Autumn Logo"
                            style="object-fit: cover; width: 100%; height: 50vh;">
                        <div class="card-img-overlay d-flex justify-content-between flex-column">
                            <div style="align-self: flex-start; color:white">
                                <h6 class="card-text">CATALOG</h6>
                                <h3 class="card-title" style="font-weight: 800">Bekas Handal</h3>
                            </div>
                            <a href="{{ route('retur.handal.index') }}" class="btn btn-primary" style="align-self: flex-end;">See Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
