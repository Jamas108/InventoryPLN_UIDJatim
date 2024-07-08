@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')

            <div class="container mt-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Detail Barang Rusak</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title">{{ $barangrusak->nama }}</h4>
                                
                                <hr>
                                <p><strong>Merk:</strong> {{ $barangrusak->merk }}</p>
                                <p><strong>No. Seri:</strong> {{ $barangrusak->no_seri }}</p>
                                <p><strong>Tipe:</strong> {{ $barangrusak->tipe }}</p>
                                <p><strong>Keterangan:</strong> {{ $barangrusak->keterangan }}</p>
                            </div>
                            <div class="col-md-6 d-flex justify-content-center align-items-center">
                                <img src="{{ Vite::asset('resources/assets/' . $barangrusak->image) }}" alt="{{ $barangrusak->nama }}" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('barangrusak.index') }}" class="btn btn-secondary">
                            Close
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
