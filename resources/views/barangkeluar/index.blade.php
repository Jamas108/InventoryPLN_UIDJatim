{{-- @extends('layouts.app')
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
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download PDF</a>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download Excel</a>
                            <a href="{{ route('barangkeluar.create') }}"
                                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                    class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Product</a>
                        </li>
                    </ul>
                </div>
                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-bordered table-hover mb-0 datatable"
                                id="ProductTable" style="90%">
                                <thead style="background-color:  rgb(1, 1, 95);">
                                    <tr style="color: white">
                                        <th scope="col" style="width: 150px;">Kode</th>
                                        <th scope="col" style="width: 200px;">Kategori</th>
                                        <th scope="col" style="width: 150px;">Durasi</th>
                                        <th scope="col" style="width: 400px;">Penanggung Jawab</th>
                                        <th scope="col" style="width: 200px;">Status</th>
                                        <th scope="col" style="width: 300px;">Keterangan</th>
                                        <th scope="col" style="width: 200px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td>aa</td>
                                    <td>aa</td>
                                    <td>aa</td>
                                    <td>aa</td>
                                    <td>aa</td>
                                    <td>aa</td>
                                    <td>aa</td>
                                </tbody>
                                <tbody>
                                    <td>aa</td>
                                    <td>aa</td>
                                    <td>aa</td>
                                    <td>aa</td>
                                    <td>aa</td>
                                    <td>aa</td>
                                    <td>aa</td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection --}}

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
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download PDF</a>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download Excel</a>
                            <a href="#" data-toggle="modal" data-target="#productModal"
                                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                    class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Product</a>
                        </li>
                    </ul>
                </div>
                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-bordered table-hover mb-0 datatable"
                                id="ProductTable" style="90%">
                                <thead style="background-color:  rgb(1, 1, 95);">
                                    <tr style="color: white">
                                        <th scope="col">Kode</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Durasi</th>
                                        <th scope="col">Penanggung Jawab</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>aa</td>
                                        <td>aa</td>
                                        <td>aa</td>
                                        <td>aa</td>
                                        <td>aa</td>
                                        <td>aa</td>
                                        <td>aa</td>
                                    </tr>
                                    <tr>
                                        <td>aa</td>
                                        <td>aa</td>
                                        <td>aa</td>
                                        <td>aa</td>
                                        <td>aa</td>
                                        <td>aa</td>
                                        <td>aa</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Pilih Jenis Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Silakan pilih jenis produk yang ingin ditambahkan:</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <button id="insidentilBtn" class="btn btn-danger m-2">Insidentil</button>
                        <button id="regulerBtn" class="btn btn-primary m-2">Reguler</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('insidentilBtn').addEventListener('click', function() {
            window.location.href = "{{ route('barangkeluar.create', ['type' => 'insidentil']) }}";
        });

        document.getElementById('regulerBtn').addEventListener('click', function() {
            window.location.href = "{{ route('barangkeluar.create', ['type' => 'reguler']) }}";
        });
    </script>
@endsection
