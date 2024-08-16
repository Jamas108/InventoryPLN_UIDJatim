@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Laporan Inventory</h1>
                </div>

                <!-- Tombol untuk menampilkan tabel -->
                <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex">
                        <button class="btn btn-primary btn-md mx-1" id="btnBarangMasuk">
                            <i class="fas fa-box-open"></i> Tampilkan Barang Masuk
                        </button>
                        <button class="btn btn-secondary btn-md mx-1" id="btnBarangKeluar">
                            <i class="fas fa-box"></i> Tampilkan Barang Keluar
                        </button>
                        <button class="btn btn-info btn-md mx-1" id="btnReturBarang">
                            <i class="fas fa-undo-alt"></i> Tampilkan Retur Barang
                        </button>
                    </div>
                
                    <button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#pdfDownloadModal">
                        <i class="fas fa-download fa-sm text-white"></i> Download PDF
                    </button>
                </div>
                
                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white rounded shadow p-4">
                        <div class="table-responsive mb-4">
                            <h4>Stok Barang</h4>
                            <br>
                            
                            <table class="table text-center align-middle table-bordered table-hover mb-0 datatable"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 200px; color:white">Kategori Barang</th>
                                        <th scope="col" style="width: 150px; color:white">Kode Barang</th>
                                        <th scope="col" style="width: 250px; color:white">Nama Barang</th>
                                        <th scope="col" style="width: 150px; color:white">Barang Masuk</th>
                                        <th scope="col" style="width: 150px; color:white">Barang Keluar</th>
                                        <th scope="col" style="width: 150px; color:white">Bekas Handal</th>
                                        <th scope="col" style="width: 150px; color:white">Bekas Bergaransi</th>
                                        <th scope="col" style="width: 150px; color:white">Barang Rusak</th>
                                        <th scope="col" style="width: 150px; color:white">Stok Barang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stokBarang as $stok)
                                        <tr>
                                            <td>{{ $stok['kategori_barang'] }}</td>
                                            <td>{{ $stok['kode_barang'] }}</td>
                                            <td>{{ $stok['nama_barang'] }}</td>
                                            <td>{{ $stok['jumlah_barang_masuk'] }}</td>
                                            <td>{{ $stok['jumlah_barang_keluar'] }}</td>
                                            <td>{{ $stok['jumlah_retur_handal'] ?? 0 }}</td>
                                            <td>{{ $stok['jumlah_retur_bergaransi'] ?? 0 }}</td>
                                            <td>{{ $stok['jumlah_retur_rusak'] ?? 0 }}</td>
                                            <td>{{ $stok['selisih'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>



                        <!-- Tabel Barang Masuk -->
                        <div class="table-responsive mb-4" id="tableBarangMasuk" style="display: none;">
                            <h4>Barang Masuk</h4>
                            <br>
                            <table class="table text-center align-middle table-bordered table-hover mb-0 datatable"
                                id="ProductTable" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 300px; color:white">Kategori Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Kode Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Nama Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Kondisi</th>
                                        <th scope="col" style="width: 300px; color:white">Jumlah Barang Masuk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangMasuk as $id => $data)
                                        @foreach ($data['barang'] as $barang)
                                            <tr>
                                                <td>{{ $barang['kategori_barang'] }}</td>
                                                <td>{{ $barang['kode_barang'] }}</td>
                                                <td>{{ $barang['nama_barang'] }}</td>
                                                <td>{{ $barang['jenis_barang'] }}</td>
                                                <td>{{ $barang['jumlah_barang'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Tabel Barang Keluar -->
                        <div class="table-responsive mb-4" id="tableBarangKeluar" style="display: none;">
                            <h4>Barang Keluar</h4>
                            <br>
                            <table class="table text-center align-middle table-bordered table-hover mb-0 datatable"
                                id="BarangKeluarTable" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 300px; color:white">Kategori Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Kode Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Nama Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Kondisi</th>
                                        <th scope="col" style="width: 300px; color:white">Jumlah Barang Keluar</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangKeluar as $id => $data)
                                        @foreach ($data['barang'] as $barang)
                                            <tr>
                                                <td>{{ $barang['kategori_barang'] }}</td>
                                                <td>{{ $barang['kode_barang'] }}</td>
                                                <td>{{ $barang['nama_barang'] }}</td>
                                                <td>{{ $barang['jenis_barang'] ?? 'N/A' }}</td>
                                                <td>{{ $barang['jumlah_barang'] }}</td>
                                                
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Tabel Retur Barang -->
                        <div class="table-responsive mb-4" id="tableReturBarang" style="display: none;">
                            <h4>Retur Barang</h4>
                            <table class="table text-center align-middle table-bordered table-hover mb-0 datatable"
                                id="ReturBarangTable" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 300px; color:white">Kategori Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Kode Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Nama Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Kondisi Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Jumlah Barang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (is_array($returBarang) || is_object($returBarang))
                                        @foreach ($returBarang as $id => $data)
                                            <tr>
                                                <td>{{ $data['kategori_barang'] }}</td>
                                                <td>{{ $data['kode_barang'] }}</td>
                                                <td>{{ $data['nama_barang'] }}</td>
                                                <td>{{ $data['Kategori_Retur'] }}</td>
                                                <td>{{ $data['jumlah_barang'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="pdfDownloadModal" tabindex="-1" role="dialog" aria-labelledby="pdfDownloadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfDownloadModalLabel">Pilih Tabel untuk Diunduh</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('reports.barangmasuk.pdf') }}"
                                    class="btn btn-primary w-45 mr-2" id="downloadBarangMasuk">
                                    <i class="fas fa-box-open"></i> Barang Masuk
                                </a>
                                <a href="{{ route('reports.barangkeluar.pdf') }}"
                                    class="btn btn-secondary w-45 ml-2" id="downloadBarangKeluar">
                                    <i class="fas fa-box"></i> Barang Keluar
                                </a>
                                <a href="{{ route('reports.returbarang.pdf') }}"
                                    class="btn btn-info w-45 ml-2" id="downloadReturBarang">
                                    <i class="fas fa-undo-alt"></i> Retur Barang
                                </a>
                                <a href="{{ route('reports.stokbarang.pdf') }}"
                                    class="btn btn-success w-45 ml-2" id="downloadStokBarang">
                                    <i class="fas fa-archive"></i> Stok Barang
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pdfDownloadModal" tabindex="-1" role="dialog" aria-labelledby="pdfDownloadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfDownloadModalLabel">Pilih Tabel untuk Diunduh</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('reports.barangmasuk.pdf', ['year' => request('year'), 'condition' => request('condition')]) }}"
                                    class="btn btn-primary w-45 mr-2" id="downloadBarangMasuk">
                                    <i class="fas fa-box-open"></i> Barang Masuk
                                </a>
                                <a href="{{ route('reports.barangkeluar.pdf', ['year' => request('year'), 'condition' => request('condition')]) }}"
                                    class="btn btn-secondary w-45 ml-2" id="downloadBarangKeluar">
                                    <i class="fas fa-box"></i> Barang Keluar
                                </a>
                                <a href="{{ route('reports.returbarang.pdf', ['year' => request('year'), 'condition' => request('condition')]) }}"
                                    class="btn btn-info w-45 ml-2" id="downloadReturBarang">
                                    <i class="fas fa-undo-alt"></i> Retur Barang
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('btnBarangMasuk').addEventListener('click', function() {
            const table = document.getElementById('tableBarangMasuk');
            table.style.display = (table.style.display === 'none' || table.style.display === '') ? 'block' : 'none';
        });

        document.getElementById('btnBarangKeluar').addEventListener('click', function() {
            const table = document.getElementById('tableBarangKeluar');
            table.style.display = (table.style.display === 'none' || table.style.display === '') ? 'block' : 'none';
        });

        document.getElementById('btnReturBarang').addEventListener('click', function() {
            const table = document.getElementById('tableReturBarang');
            table.style.display = (table.style.display === 'none' ||
                table.style.display === '') ? 'block' : 'none';
        });
    </script>
@endsection
