@extends('layouts.app')
@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $('#suratjalantable').DataTable();

            // Event listener untuk tombol retur
            $(".datatable").on("click", ".btn-retur", function(e) {
                e.preventDefault();

                var id = $(this).data("id"); // Ambil ID dari tombol retur

                // Redirect ke rute create retur berdasarkan ID
                window.location.href = `/retur/create/${id}`;
            });

            $(".datatable").on("click", ".btn-delete", function(e) {
                e.preventDefault();

                var form = $(this).closest("form");
                var name = $(this).data("name");

                Swal.fire({
                    title: "Apakah Anda Yakin Ingin Menghapus Peminjaman Atas Nama \n" + name + "?",
                    text: "Data Akan Terhapus Secara Permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "bg-primary",
                    confirmButtonText: "Ya, Hapus Sekarang!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Surat Jalan</h1>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white rounded shadow p-4 d-flex justify-content-center">
                        <div class="table-responsive" style="width: 100%;">
                            <table class="table text-center align-middle table-bordered table-hover mb-0 datatable"
                                id="suratjalantable">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 450px; color:white">Nama Perusahaan Pengirim</th>
                                        <th scope="col" style="width: 450px; color:white">No Surat Jalan</th>
                                        <th scope="col" style="width: 450px; color:white">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangMasuks as $barangMasuk)
                                        <tr>
                                            <td>{{ $barangMasuk->NamaPerusahaan_Pengirim }}</td>
                                            <td>{{ $barangMasuk->No_Surat }}</td>
                                            <td>
                                                @if ($barangMasuk->File_SuratJalan_URL)
                                                    <a href="{{ $barangMasuk->File_SuratJalan_URL }}" target="_blank"
                                                        class="btn btn-primary">
                                                        Lihat Detail
                                                    </a>
                                                @else
                                                    <span class="text-danger">File tidak ditemukan</span>
                                                @endif
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
    @endsection
