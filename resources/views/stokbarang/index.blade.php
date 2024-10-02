@extends('layouts.app')
@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $('#stoktable').DataTable();
        });

        $(".datatable").on("click", ".btn-delete", function(e) {
            e.preventDefault();

            var form = $(this).closest("form");
            var name = $(this).data("name");

            Swal.fire({
                title: "Apakah yakin menghapus barang?",
                text: "Data yang dihapus tidak dapat kembali!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonClass: "bg-primary",
                confirmButtonText: "Ya, hapus barang",
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endpush
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Stok Barang</h1>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="col-lg-12 mt-lg-0 d-flex align-items-stretch mx-auto" data-aos="fade-up"
                            data-aos-delay="200">
                            <!-- Update table in resources/views/barang_rusak.blade.php -->
                            <table class="table text-center align-middle table-bordered table-hover mb-0 datatable"
                                id="stoktable" style="90%">
                                <thead style="background-color: rgb(1, 1, 95);">
                                    <tr style="color: white">
                                        <th class="align-middle" scope="col" style="width: 150px; color:white">No</th>
                                        <th class="align-middle" scope="col" style="width: 150px; color:white">Gambar Barang</th>
                                        <th class="align-middle" scope="col" style="width: 200px; color:white">Kode Barang</th>
                                        <th class="align-middle" scope="col" style="width: 150px; color:white">Nama Barang</th>
                                        <th class="align-middle" scope="col" style="width: 150px; color:white">Stok Awal Barang</th>
                                        <th class="align-middle" scope="col" style="width: 150px; color:white">Sisa Stok Barang</th>
                                        <th class="align-middle" scope="col" style="width: 150px; color:white">Kategori</th>
                                        <th class="align-middle" scope="col" style="width: 150px; color:white">Garansi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupedBarangMasuks as $barang)
                                        <tr>
                                            <td class="align-middle">{{ $loop->iteration }}</td>
                                            <td class="align-middle">
                                                @if ($barang['gambar_barang'])
                                                    <img src="{{ $barang['gambar_barang'] }}" alt="Gambar Barang"
                                                        width="100">
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td class="align-middle">{{ $barang['kode_barang'] }}</td>
                                            <td class="align-middle">{{ $barang['nama_barang'] }}</td>
                                            <td class="align-middle">{{ $barang['inisiasi_stok'] }}</td>
                                            <td class="align-middle">{{ $barang['jumlah_barang'] }}</td>
                                            <td class="align-middle">{{ $barang['kategori'] }}</td>
                                            <td class="align-middle">{{ $barang['sisa_hari_garansi'] }}</td>
                                        
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
