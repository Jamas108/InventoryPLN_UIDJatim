@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Barang Keluar</h1>
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            {{-- Uncomment these lines if you have download functionalities
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                                <i class="fas fa-download fa-sm text-white-50"></i> Download PDF
                            </a>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                                <i class="fas fa-download fa-sm text-white-50"></i> Download Excel
                            </a>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Product
                            </a>
                            --}}
                        </li>
                    </ul>
                </div>
                <div class="container-fluid pt-2 px-2 d-grid gap-4" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
                    <div class="card p-0 bg-transparent border-0">
                        <img src="{{ Vite::asset('../resources/assets/Box.jpg') }}" class="card-img rounded" alt="All">
                        <div class="card-img-overlay d-flex flex-column justify-content-between">
                            <div class="text-white">
                                <h6 class="card-text">CATALOG</h6>
                                <h3 class="card-title font-weight-bold">All</h3>
                            </div>
                            <a href="{{ route('barangkeluar.all.index') }}" class="btn btn-primary">See Details</a>
                        </div>
                    </div>

                    <div class="card p-0 bg-transparent border-0">
                        <img src="{{ Vite::asset('../resources/assets/Box.jpg') }}" class="card-img rounded" alt="Reguler">
                        <div class="card-img-overlay d-flex flex-column justify-content-between">
                            <div class="text-white">
                                <h6 class="card-text">CATALOG</h6>
                                <h3 class="card-title font-weight-bold">Reguler</h3>
                            </div>
                            <a href="{{ route('barangkeluar.reguler.index') }}" class="btn btn-primary">See Details</a>
                        </div>
                    </div>

                    <div class="card p-0 bg-transparent border-0">
                        <img src="{{ Vite::asset('../resources/assets/Box.jpg') }}" class="card-img rounded" alt="Insidentil">
                        <div class="card-img-overlay d-flex flex-column justify-content-between">
                            <div class="text-white">
                                <h6 class="card-text">CATALOG</h6>
                                <h3 class="card-title font-weight-bold">Insidentil</h3>
                            </div>
                            <a href="{{ route('barangkeluar.insidentil.index') }}" class="btn btn-primary">See Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
