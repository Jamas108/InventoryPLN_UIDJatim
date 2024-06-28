@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Networking</h1>
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            <a href="{{ route('stokbarang.index') }}"
                                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                    class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Barang </a>
                        </li>
                    </ul>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-bordered table-hover mb-0 datatable"
                                id="ProductTable" style="90%">
                                <thead style=" background-color: rgb(1, 1, 95);">
                                    <tr style="color: white">
                                        <th scope="col" style="width: 300px;">ITEM NAME</th>
                                        <th scope="col" style="width: 300px;"> </th>
                                        <th scope="col" style="width: 300px;">QUANTITY</th>
                                        <th scope="col" style="width: 300px;">DATE ADDED</th>
                                        <th scope="col" style="width: 250px;">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td>FOTO</td>
                                    <td>DESKRIPSI</td>
                                    <td>JUMLAH</td>
                                    <td>TANGGAL</td>
                                    <td>AKSI</td>
                                </tbody>
                                <tbody>
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
@endsection
