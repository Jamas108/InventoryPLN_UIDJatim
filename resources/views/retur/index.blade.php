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

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="col-lg-12 mt-lg-0 d-flex align-items-stretch mx-auto" data-aos="fade-up"
                            data-aos-delay="200">
                            <!-- Update table in resources/views/barang_rusak.blade.php -->
                            <table class="table text-center align-middle table-bordered table-hover mb-0 datatable"
                                id="ProductTable" style="90%">
                                <thead style=" background-color: rgb(1, 1, 95);">
                                    <tr style="color: white">
                                        <th scope="col" style="width: 150px; color:white">No</th>
                                        <th scope="col" style="width: 150px; color:white">Pemohon</th>
                                        <th scope="col" style="width: 200px; color:white">Kode Barang</th>
                                        <th scope="col" style="width: 150px; color:white">Nama Barang</th>
                                        <th scope="col" style="width: 150px; color:white">Jumlah Barang</th>
                                        <th scope="col" style="width: 150px; color:white">Kategori</th>
                                        <th scope="col" style="width: 150px; color:white">Deskripsi</th>
                                        <th scope="col" style="width: 250px; color:white">Tanggal Retur</th>
                                        <th scope="col" style="width: 150px; color:white">Status</th>
                                        <th scope="col" style="width: 150px; color:white">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($returBarangData as $key => $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item['Pihak_Pemohon'] }}</td>
                                            <td>{{ $item['kode_barang'] }}</td>
                                            <td>{{ $item['nama_barang'] }}</td>
                                            <td>{{ $item['jumlah_barang'] }}</td>
                                            <td>{{ $item['kategori_barang'] }}</td>
                                            <td>{{ $item['Deskripsi'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item['Tanggal_Retur'])->format('d-m-Y') }}</td>
                                            <td>{{ $item['status'] }}</td>
                                            <td>
                                                <a href="{{ route('retur.edit', ['id' => $item['id']]) }}"
                                                    class="btn btn-info btn-sm">Kelola</a>
                                                {{-- <a href="#" class="btn btn-danger btn-sm">Delete</a> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
