@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')

            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Bekas Handal</h1>

                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-center align-middle table-bordered table-hover mb-0 datatable"
                                id="ProductTable" style="90%">
                                <thead style=" background-color: rgb(1, 1, 95);">
                                    <tr style="color: white">
                                        <th scope="col" style="width: 150px; color:white">No</th>
                                        <th scope="col" style="width: 150px; color:white">Nama Barang</th>
                                        <th scope="col" style="width: 200px; color:white">Kode Barang</th>
                                        <th scope="col" style="width: 150px; color:white">Jumlah Barang</th>
                                        <th scope="col" style="width: 150px; color:white">Kategori Barang</th>
                                        <th scope="col" style="width: 150px; color:white">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bekasHandals as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item['Nama_Barang'] }}</td>
                                            <td>{{ $item['Kode_Barang'] }}</td>
                                            <td>{{ $item['Jumlah_Barang'] }}</td>
                                            <td>{{ $item['Kategori_Barang'] }}</td>

                                            <td></td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">Tidak ada barang retur dengan kategori Bekas Handal.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
