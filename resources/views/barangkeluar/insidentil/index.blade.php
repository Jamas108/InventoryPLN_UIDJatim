@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Barang Keluar Insidentil</h1>
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download PDF</a>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download Excel</a>
                            <a href=""
                                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                    class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Barang </a>
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
@endsection
