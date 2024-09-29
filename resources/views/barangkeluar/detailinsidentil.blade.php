@extends('layouts.app')
<script type="module">
    $(document).ready(function() {
        $('#detailinsidentiltable').DataTable();
    });
</script>

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Detail Barang Keluar</h1>
                    <a href="{{ route('barangkeluar.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
                <div class="bg-white rounded shadow p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Nama Pihak Peminjam</label>
                            <input type="text" class="form-control" value="{{ $barangKeluar['Nama_PihakPeminjam'] }}"
                                readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label>Kategori Peminjaman</label>
                            <input type="text" class="form-control" value="{{ $barangKeluar['Kategori_Peminjaman'] }}"
                                readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label>Jenis Barang Dipinjam</label>
                            <input type="text" class="form-control" value="{{ count($barangKeluar['barang']) }}"
                                readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label>Tanggal Peminjaman</label>
                            <input type="text" class="form-control"
                                value="{{ $barangKeluar['tanggal_peminjamanbarang'] }}" readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label>Batas Tanggal Pengembalian</label>
                            <input type="text" class="form-control"
                                value="{{ $barangKeluar['Tanggal_PengembalianBarang'] }}" readonly>
                        </div>
                        <div class="col-md-6 mt-4">
                            @if (!empty($barangKeluar['File_Surat']))
                                <a class="btn btn-primary col-md-12" href="{{ $barangKeluar['File_Surat'] }}"
                                    target="_blank">Lihat Surat
                                    Jalan</a>
                            @else
                                <span>Tidak Ada</span>
                            @endif
                        </div>
                        <div class="col-md-6 mt-4">
                            @if (!empty($barangKeluar['File_BeritaAcara']))
                                <a class="btn btn-primary col-md-12" href="{{ $barangKeluar['File_BeritaAcara'] }}"
                                    target="_blank">Lihat Berita Acara</a>
                            @else
                            <div class="text-center mt-2">
                                <span>Belum Dibuat</span>
                        </div>
                            @endif
                        </div>

                        <div class="col-md-12 mt-4">
                            <h5>Detail Barang</h5>
                            <table class="table table-bordered mt-2" id="detailinsidentiltable">
                                <thead>
                                    <tr>
                                        <th style="color: white">No</th>
                                        <th style="color: white">Nama Barang</th>
                                        <th style="color: white">Kode Barang</th>
                                        <th style="color: white">Kategori Barang</th>
                                        <th style="color: white">Jumlah Barang</th>
                                        <th style="color: white">Jenis Barang</th>
                                        <th style="color: white">Garansi Awal</th>
                                        <th style="color: white">Garansi Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangKeluar['barang'] as $barang)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $barang['nama_barang'] }}</td>
                                            <td>{{ $barang['kode_barang'] }}</td>
                                            <td>{{ $barang['kategori_barang'] }}</td>
                                            <td>{{ $barang['jumlah_barang'] }}</td>
                                            <td>{{ $barang['jenis_barang'] }}</td>
                                            <td>{{ $barang['garansi_barang_awal'] }}</td>
                                            <td>{{ $barang['garansi_barang_akhir'] }}</td>
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
