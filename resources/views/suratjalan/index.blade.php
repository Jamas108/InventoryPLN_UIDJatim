@extends('layouts.app')
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
                                id="ProductTable">
                                <thead style="background-color: rgb(1, 1, 95);">
                                    <tr style="color: white">
                                        <th scope="col" style="width: 450px;">Nama Perusahaan Pengirim</th>
                                        <th scope="col" style="width: 450px;">No Surat Jalan</th>
                                        <th scope="col" style="width: 450px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangMasuks as $barangMasuk)
                                        <tr>
                                            <td>{{ $barangMasuk->NamaPerusahaan_Pengirim }}</td>
                                            <td>{{ $barangMasuk->No_Surat }}</td>
                                            <td>
                                                <a href="{{ Vite::asset('storage/app/' . $barangMasuk->File_SuratJalan) }}"
                                                    target="_blank" class="btn btn-primary">
                                                    Lihat Detail
                                                </a>
                                                <a href="{{asset('storage/app/' . $barangMasuk->File_SuratJalan) }}"
                                                    download class="btn btn-secondary">
                                                    Download
                                                </a>
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
