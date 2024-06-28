@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">

                <div class="d-sm-flex align-items-center justify-content-center mb-4"
                    style="background-color:  rgb(1, 1, 95);">
                    <h1 class="h3 mb-0 text-white"><strong>Masuk</strong></h1>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <form action="{{ route('barangmasuk.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="No Surat Jalan">No Surat jalan</label>
                                        <input type="text" class="form-control" placeholder="Masukan Nomor Surat"
                                            id="nosuratjalanmasuk" name="nosuratjalanmasuk"
                                            aria-label="No Surat Jalan masuk" aria-describedby="addon-wrapping">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="namapt">NAMA PT</label>
                                        <input type="text" class="form-control" placeholder="Masukan Nama PT"
                                            id="namaptmasuk" name="namaptmasuk" aria-label="Nama PT Masuk"
                                            aria-describedby="addon-wrapping">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal">TANGGAL</label>
                                        <input type="text" class="form-control" placeholder="Masukan Tanggal"
                                            id="tanggalmasuk" name="tanggalmasuk" aria-label="Tanggal Masuk"
                                            aria-describedby="addon-wrapping">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pengirim">PENGIRIM</label>
                                        <input type="text" class="form-control" placeholder="Masukan Nama Pengirim"
                                            id="pengirim" name="pengirim" aria-label="Pengirim"
                                            aria-describedby="addon-wrapping">
                                    </div>
                                </div>

                                <div class="col-md-12 mt-2">
                                    <div class="form-group">
                                        <p style="font-weight:bolder ">ITEM-ITEM DIKIRIM</p>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table text-start align-middle table-bordered table-hover mb-0 datatable"
                                        id="ProductTable" style="90%">
                                        <thead style=" background-color: rgba(173, 171, 169, 0.938);">
                                            <tr style="color: white">
                                                <th scope="col" style="width: 300px;">Nama Barang</th>
                                                <th scope="col" style="width: 300px;">Detail Barang</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td>Barang1</td>
                                            <td>Listrik</td>
                                        </tbody>
                                        <tbody>
                                            <td>Barang2</td>
                                            <td>Tower</td>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6 mt-4">
                                    <div class="form-group">
                                        <label for="suratJalan">SURAT JALAN</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="suratJalan"
                                                name="suratJalan" accept="application/pdf">
                                            <label class="custom-file-label" for="suratJalan">Pilih file PDF</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 d-flex justify-content-end">
                                    <a href="{{ route('barangmasuk.index') }}"
                                        class="mt-3 mr-3 btn btn-secondary btn-icon-split" style="width: 15%">
                                        <span class="text">Batal</span>
                                    </a>
                                    <button type="submit" class="mt-3 mr-3 btn btn-primary btn-icon-split"
                                        style="width: 15%;">
                                        <span class="text">Next</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
