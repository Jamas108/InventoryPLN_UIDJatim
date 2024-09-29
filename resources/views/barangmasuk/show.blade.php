@extends('layouts.app')
@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $('#detailbarangmasuk').DataTable();
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
                    <h1 class="h3 mb-0 text-gray-800">Detail Barang Masuk</h1>
                    <a href="{{ route('barangmasuk.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
                <div class="bg-white rounded shadow p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Perusahaan Pengirim</label>
                            <input type="text" class="form-control" value="{{ $BarangMasuk['NamaPerusahaan_Pengirim'] }}"
                                readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label>No Surat</label>
                            <input type="text" class="form-control" value="{{ $BarangMasuk['No_Surat'] }}"
                                readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label>Petugas</label>
                            <input type="text" class="form-control" value="{{ $BarangMasuk['Id_Petugas'] }}"
                                readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label>Jumlah Jenis Barang Masuk</label>
                            <input type="text" class="form-control" value="{{ count($BarangMasuk['barang']) }}"
                                readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label>Total Semua Barang Masuk</label>
                            <input type="text" class="form-control" value="{{ $BarangMasuk['Jumlah_BarangMasuk']}}"
                                readonly>
                        </div>
                        <div class="col-md-6 mt-4">
                            @if (!empty($barangKeluar['File_SuratJalan']))
                                <a class="btn btn-primary col-md-12" href="{{ $BarangMasuk['File_SuratJalan'] }}"
                                    target="_blank">Lihat Surat
                                    Jalan</a>
                            @else
                                <div class="justify-content-center align-items-center">
                                    <span>Tidak Ada</span>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-12 mt-4">
                            <h5>Detail Barang</h5>
                            <table class="table table-bordered mt-2" id="detailbarangmasuk">
                                <thead>
                                    <tr>
                                        <th style="color: white" class="align-middle text-center">No</th>
                                        <th style="color: white" class="align-middle text-center">Nama Barang</th>
                                        <th style="color: white" class="align-middle text-center">Kode Barang</th>
                                        <th style="color: white" class="align-middle text-center">Kategori Barang</th>
                                        <th style="color: white" class="align-middle text-center">Status</th>
                                        <th style="color: white" class="align-middle text-center">Stok Awal</th>
                                        <th style="color: white" class="align-middle text-center">Stok Sekarang</th>
                                        <th style="color: white" class="align-middle text-center">Jenis Barang</th>
                                        <th style="color: white" class="align-middle text-center">Garansi Awal</th>
                                        <th style="color: white" class="align-middle text-center">Garansi Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($BarangMasuk['barang'] as $barang)
                                        <tr>
                                            <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                            <td class="align-middle text-center">{{ $barang['nama_barang'] }}</td>
                                            <td class="align-middle text-center">{{ $barang['kode_barang'] }}</td>
                                            <td class="align-middle text-center">{{ $barang['kategori_barang'] }}</td>
                                            <td class="align-middle text-center">{{ $barang['Status'] }}</td>
                                            <td class="align-middle text-center">{{ $barang['inisiasi_stok'] }}</td>
                                            <td class="align-middle text-center">{{ $barang['jumlah_barang'] }}</td>
                                            <td class="align-middle text-center">{{ $barang['jenis_barang'] }}</td>
                                            <td class="align-middle text-center">{{ $barang['garansi_barang_awal'] }}</td>
                                            <td class="align-middle text-center">{{ $barang['garansi_barang_akhir'] }}</td>
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
