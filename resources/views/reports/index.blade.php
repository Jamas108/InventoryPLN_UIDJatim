@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')

            <div class="container-fluid">

                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Reports</h1>
                </div>
                <div class="container-fluid pt-2 px-2">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <a href="{{ route('reports.barangmasuk.index') }}" style="text-decoration: none">
                                <div class="card shadow-sm">
                                    <div class="card-body text-center">
                                        <i class="fas fa-box-open fa-3x" style="color: blue;"></i>
                                        <p class="mt-3">Barang Masuk</p>
                                    </div>
                                </div>
                            </a>

                        </div>
                        <div class="col-md-3 mb-4">
                            <a href="{{ route('indexbarangkeluar') }}" style="text-decoration: none">
                                <div class="card shadow-sm">
                                    <div class="card-body text-center">
                                        <i class="fas fa-dolly fa-3x" style="color: teal;"></i>
                                        <p class="mt-3">Barang Keluar</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-4">
                            <a href="{{ route('indexbarangrusak') }}" style="text-decoration: none">
                                <div class="card shadow-sm">
                                    <div class="card-body text-center">
                                        <i class="fas fa-exclamation-triangle fa-3x" style="color: red;"></i>
                                        <p class="mt-3">Barang Rusak</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-4">
                            <a href="{{ route('indexrequesteditem') }}" style="text-decoration: none">
                                <div class="card shadow-sm">
                                    <div class="card-body text-center">
                                        <i class="fas fa-clipboard-list fa-3x" style="color: orange;"></i>
                                        <p class="mt-3">Requested Item</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection
