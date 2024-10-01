@extends('layouts.app')
@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $('#handalTable').DataTable();
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
                    <h1 class="h3 mb-0 text-gray-800">Bekas Handal</h1>

                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-center align-middle table-bordered table-hover mb-0 datatable"
                                id="handalTable" style="90%">
                                <thead style=" background-color: rgb(1, 1, 95);">
                                    <tr style="color: white">
                                        <th class="align-middle" scope="col" style="width: 150px; color:white">No</th>
                                        <th class="align-middle" scope="col" style="width: 150px; color:white">Nama
                                            Barang</th>
                                        <th class="align-middle" scope="col" style="width: 200px; color:white">Kode
                                            Barang</th>
                                        <th class="align-middle" scope="col" style="width: 150px; color:white">Jumlah
                                            Barang</th>
                                        <th class="align-middle" scope="col" style="width: 150px; color:white">Kategori
                                            Barang</th>
                                        <th class="align-middle" scope="col" style="width: 150px; color:white">Garansi
                                            Mulai</th>
                                        <th class="align-middle" scope="col" style="width: 150px; color:white">Garansi
                                            Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bekasHandals as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item['nama_barang'] }}</td>
                                            <td>{{ $item['kode_barang'] }}</td>
                                            <td>{{ $item['jumlah_barang'] }}</td>
                                            <td>{{ $item['kategori_barang'] }}</td>
                                            <td>{{ $item['garansi_barang_awal'] }}</td>
                                            <td>{{ $item['garansi_barang_akhir'] }}</td>
                                           

                                        </tr>
                                    @empty
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
