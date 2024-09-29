@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid p-2">
                <form action="{{ route('barangkeluar.storeBeritaAcaraReguler', ['id' => $id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="container-fluid">
                        <div class="d-sm-flex align-items-center justify-content-center"
                            style="background-color: rgb(1, 1, 95);">
                            <h3 class="h3 mb-0 text-white"><strong>BUAT BERITA ACARA</strong></h3>
                        </div>
                        <div class="bg-white justify-content-between rounded-bottom shadow p-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="nomor_beritaacara"
                                            name="nomor_beritaacara" value="Nomor Berita Acara"
                                            style="background-color: rgb(1, 1, 95); color : white" readonly>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <input type="text" class="form-control text-center" id="no_berita_acara"
                                            name="no_berita_acara" value="{{ $nextNumber }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control text-center" id="pembuat_no_berita_acara"
                                            name="pembuat_no_berita_acara" value="STI-JATIM" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control text-center" id="kategori_no_berita_acara"
                                            name="kategori_no_berita_acara" value="REG" readonly>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <input type="text" class="form-control text-center" id="bulan_no_berita_acara"
                                            name="bulan_no_berita_acara" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control text-center" id="tahun_no_berita_acara"
                                            name="tahun_no_berita_acara" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="text_pihak_peminjam"
                                            name="text_pihak_peminjam" value="Nama Pihak Peminjam"
                                            style="background-color: rgb(1, 1, 95); color : white" readonly>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ $Nama_PihakPeminjam }}"
                                            id="Nama_PihakPeminjam" name="Nama_PihakPeminjam" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="text_pihak_peminjam"
                                            name="text_pihak_peminjam" value="Tanggal Peminjaman"
                                            style="background-color: rgb(1, 1, 95); color : white" readonly>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="date" class="form-control" id="tanggal_peminjamanbarang"
                                            name="tanggal_peminjamanbarang" value="{{ $tanggal_peminjamanbarang }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="text_catatan" name="text_catatan"
                                            value="Catatan" style="background-color: rgb(1, 1, 95); color : white" readonly>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <textarea class="form-control" id="Catatan" name="Catatan"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <input type="text" name="Kode_BarangKeluar" value="{{ $id }}"
                                            hidden>
                                    </div>
                                </div>
                                <div class="p-3 col-md-12">
                                    <button type="submit" class="btn btn-success col-md-12">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Mengatur Tahun dan Bulan Secara Otomatis
                const date = new Date();
                const year = date.getFullYear();
                const month = ("0" + (date.getMonth() + 1)).slice(-2); // Bulan dalam format 2 digit

                document.getElementById('tahun_no_berita_acara').value = year;
                document.getElementById('bulan_no_berita_acara').value = month;

                
            });
        </script>
    @endpush
@endsection
