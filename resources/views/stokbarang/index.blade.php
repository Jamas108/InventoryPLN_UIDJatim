@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Stok Barang</h1>
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
                                <thead style="background-color: rgb(1, 1, 95);">
                                    <tr style="color: white">
                                        <th scope="col" style="width: 150px; color:white">No</th>
                                        <th scope="col" style="width: 150px; color:white">Gambar Barang</th>
                                        <th scope="col" style="width: 200px; color:white">Kode Barang</th>
                                        <th scope="col" style="width: 150px; color:white">Nama Barang</th>
                                        <th scope="col" style="width: 150px; color:white">Jumlah Barang</th>
                                        <th scope="col" style="width: 150px; color:white">Kategori</th>
                                        <th scope="col" style="width: 150px; color:white">Garansi</th>
                                        <th scope="col" style="width: 150px; color:white">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupedBarangMasuks as $barang)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($barang['gambar_barang'])
                                                    <img src="{{ $barang['gambar_barang'] }}" alt="Gambar Barang"
                                                        width="100">
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $barang['kode_barang'] }}</td>
                                            <td>{{ $barang['nama_barang'] }}</td>
                                            <td>{{ $barang['jumlah_barang'] }}</td>
                                            <td>{{ $barang['kategori'] }}</td>
                                            <td>{{ $barang['sisa_hari_garansi'] }}</td>
                                            <td>
                                                <a href="#" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="#" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
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
