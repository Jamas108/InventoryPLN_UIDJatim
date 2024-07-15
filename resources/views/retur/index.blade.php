@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')

            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Retur</h1>
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download PDF</a>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download Excel</a>
                        </li>
                    </ul>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-bordered table-hover mb-3 datatable"
                                id="ProductTable" style="width: 100%;">
                                <thead>
                                    <tr >
                                        <th scope="col" style="width: 250px; color:white">Jenis Retur</th>
                                        <th scope="col" style="width: 250px; color:white">Perusahaan Pemohon</th>
                                        <th scope="col" style="width: 250px; color:white">Pemohon</th>
                                        <th scope="col" style="width: 250px; color:white">Approval Status</th>
                                        <th scope="col" style="width: 200px; color:white">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-toggle="collapse" data-target="#detail1" class="accordion-toggle">
                                        <td>Bekas Handal</td>
                                        <td>UP3 Surabaya Selatan</td>
                                        <td>Aryasaty Kirana</td>
                                        <td><span class="badge badge-success">Approved</span></td>
                                        <td><button class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#detail1"><i class="fas fa-plus"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="mb-3">
                                            <div class="collapse" id="detail1">
                                                <table class="table mb-0 text-center">
                                                    <thead>
                                                        <tr style="background-color: rgb(191, 191, 198)">
                                                            <th style="width: 300px;">Kode Barang</th>
                                                            <th style="width: 300px;">Nama Barang</th>
                                                            <th style="width: 300px;">Kuantitas</th>
                                                            <th style="width: 300px;">Approval Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>CBL00192</td>
                                                            <td>Cable</td>
                                                            <td>2</td>
                                                            <td><span class="badge badge-success">Approved</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>SWI00921</td>
                                                            <td>Switch</td>
                                                            <td>2</td>
                                                            <td><span class="badge badge-success">Approved</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>RT029182</td>
                                                            <td>Router</td>
                                                            <td>1</td>
                                                            <td><span class="badge badge-success">Approved</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr data-toggle="collapse" data-target="#detail2" class="accordion-toggle">
                                        <td>Barang Rusak</td>
                                        <td>UP3 Surabaya Timur</td>
                                        <td>Aryasaty Kirana</td>
                                        <td><span class="badge badge-success">Approved</span></td>
                                        <td><button class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#detail2"><i class="fas fa-plus"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="mb-3">
                                            <div class="collapse" id="detail2">
                                                <table class="table mb-0 text-center">
                                                    <thead>
                                                        <tr style="background-color: rgb(191, 191, 198)">
                                                            <th style="width: 300px;">Kode Barang</th>
                                                            <th style="width: 300px;">Nama Barang</th>
                                                            <th style="width: 300px;">Kuantitas</th>
                                                            <th style="width: 300px;">Approval Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>CBL00192</td>
                                                            <td>Cable</td>
                                                            <td>2</td>
                                                            <td><span class="badge badge-success">Approved</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>SWI00921</td>
                                                            <td>Switch</td>
                                                            <td>2</td>
                                                            <td><span class="badge badge-success">Approved</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>RT029182</td>
                                                            <td>Router</td>
                                                            <td>1</td>
                                                            <td><span class="badge badge-success">Approved</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
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
