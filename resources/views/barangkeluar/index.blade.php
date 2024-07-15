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
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="openModalBtn"><i
                                    class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Product</a>
                        </li>
                    </ul>
                </div>
                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-bordered table-hover mb-0 datatable"
                                id="ProductTable" style="100%">
                                <thead style="background-color: rgb(1, 1, 95);">
                                    <tr>
                                        <th scope="col" style="color:white">Kode</th>
                                        <th scope="col" style="color:white">Kategori</th>
                                        <th scope="col" style="color:white">Durasi</th>
                                        <th scope="col" style="color:white">Penanggung Jawab</th>
                                        <th scope="col" style="color:white">Status</th>
                                        <th scope="col" style="color:white">Keterangan</th>
                                        <th scope="col" style="color:white">Action</th>
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
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <h5>Silakan pilih jenis produk yang ingin ditambahkan:</h5>
                    <div class="d-flex justify-content-center align-items-center mt-2">
                        <button id="insidentilBtn" class="btn btn-info m-2">Insidentil</button>
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

        // Show modal when 'Tambahkan Product' button is clicked
        document.getElementById('openModalBtn').addEventListener('click', function() {
            $('#productModal').modal('show');
        });
    </script>
@endsection
