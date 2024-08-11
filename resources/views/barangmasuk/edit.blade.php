@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="barang-item d-sm-flex align-items-center justify-content-center rounded-top mb-0"
                    style="background-color: rgb(1, 1, 95);height:50px">
                    <h1 class="h3 mb-0 text-white">Edit Barang Masuk</h1>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white rounded shadow p-4">
                        <form action="{{ route('barangmasuk.update', $barangMasuks->first()->No_Surat) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="No_Surat" class="form-label">No. Surat Jalan</label>
                                        <input type="text" class="form-control" id="No_Surat" name="No_Surat"
                                            value="{{ $barangMasuks->first()->No_Surat }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Id_Petugas" class="form-label">Petugas</label>
                                        <select id="Id_Petugas" name="Id_Petugas" class="form-select" required>
                                            @foreach ($staffGudangs as $staffGudang)
                                                <option value="{{ $staffGudang->id }}">{{ $staffGudang->Nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="NamaPerusahaan_Pengirim" class="form-label">Nama Perusahaan
                                            Pengirim</label>
                                        <input type="text" class="form-control" id="NamaPerusahaan_Pengirim"
                                            name="NamaPerusahaan_Pengirim"
                                            value="{{ $barangMasuks->first()->NamaPerusahaan_Pengirim }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="TanggalPengiriman_Barang" class="form-label">Tanggal Pengiriman
                                            Barang</label>
                                        <input type="date" class="form-control" id="TanggalPengiriman_Barang"
                                            name="TanggalPengiriman_Barang"
                                            value="{{ $barangMasuks->first()->TanggalPengiriman_Barang }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Jumlah_barang" class="form-label">Jumlah Barang</label>
                                        <input type="number" class="form-control" id="Jumlah_barang" name="Jumlah_barang"
                                            value="{{ $barangMasuks->first()->Jumlah_barang }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="File_SuratJalan" class="form-label">File Surat Jalan</label>
                                        <input type="file" class="form-control" id="File_SuratJalan"
                                            name="File_SuratJalan">
                                        {{ Storage::url($barangMasuks->first()->File_SuratJalan) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                            <!-- Detail Barang Masuk -->
                            <div id="items-container" class="p-2">
                                @foreach ($barangMasuks as $index => $barangMasuk)
                                    <div class="row mb-3 bg-white justify-content-between rounded-bottom shadow mt-4">
                                        <div class="barang-item d-sm-flex align-items-center justify-content-center rounded-top mb-4"
                                            style="background-color: rgb(1, 1, 95); height:50px">
                                            <h3 class="h3 mb-0 text-white">Barang {{ $index + 1 }}</h3>
                                        </div>

                                        <div class="col">
                                            <div class="barang-section mb-4">
                                                <h5>Barang {{ $index + 1 }}</h5>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="Kode_Barang_{{ $index }}" class="form-label">Kode
                                                            Barang</label>
                                                        <input type="text" class="form-control"
                                                            id="Kode_Barang_{{ $index }}" name="Kode_Barang[]"
                                                            value="{{ $barangMasuk->Kode_Barang }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="Nama_Barang_{{ $index }}" class="form-label">Nama
                                                            Barang</label>
                                                        <input type="text" class="form-control"
                                                            id="Nama_Barang_{{ $index }}" name="Nama_Barang[]"
                                                            value="{{ $barangMasuk->Nama_Barang }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="Jenis_Barang_{{ $index }}" class="form-label">Jenis
                                                            Barang</label>
                                                        <input type="text" class="form-control"
                                                            id="Jenis_Barang_{{ $index }}" name="Jenis_Barang[]"
                                                            value="{{ $barangMasuk->Jenis_Barang }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="Id_Kategori_Barang_{{ $index }}"
                                                            class="form-label">Kategori Barang</label>
                                                        <select id="Id_Kategori_Barang_{{ $index }}"
                                                            name="Id_Kategori_Barang[]" class="form-select">
                                                            @foreach ($kategoriBarangs as $kategoriBarang)
                                                                <option value="{{ $kategoriBarang->id }}"
                                                                    {{ $barangMasuk->Id_Kategori_Barang == $kategoriBarang->id ? 'selected' : '' }}>
                                                                    {{ $kategoriBarang->Nama_Kategori_Barang }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="JumlahBarang_Masuk_{{ $index }}"
                                                            class="form-label">Jumlah Barang Masuk</label>
                                                        <input type="number" class="form-control"
                                                            id="JumlahBarang_Masuk_{{ $index }}"
                                                            name="JumlahBarang_Masuk[]"
                                                            value="{{ $barangMasuk->JumlahBarang_Masuk }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="Garansi_Barang_{{ $index }}"
                                                            class="form-label">Garansi Barang</label>
                                                        <input type="number" class="form-control"
                                                            id="Garansi_Barang_{{ $index }}" name="Garansi_Barang[]"
                                                            value="{{ $barangMasuk->Garansi_Barang }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="Kondisi_Barang_{{ $index }}"
                                                            class="form-label">Kondisi Barang</label>
                                                        <input type="text" class="form-control"
                                                            id="Kondisi_Barang_{{ $index }}" name="Kondisi_Barang[]"
                                                            value="{{ $barangMasuk->Kondisi_Barang }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="Tanggal_Masuk_{{ $index }}" class="form-label">Tanggal
                                                            Masuk</label>
                                                        <input type="date" class="form-control"
                                                            id="Tanggal_Masuk_{{ $index }}" name="Tanggal_Masuk[]"
                                                            value="{{ $barangMasuk->Tanggal_Masuk }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="Gambar_Barang_{{ $index }}"
                                                            class="form-label">Gambar Barang</label>
                                                        <input type="file" class="form-control"
                                                            id="Gambar_Barang_{{ $index }}" name="Gambar_Barang[]">
                                                        {{ $barangMasuk->Gambar_Barang }}"
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="Id_Status_Barang_{{ $index }}"
                                                            class="form-label">Status Barang</label>
                                                        <select id="Id_Status_Barang_{{ $index }}"
                                                            name="Id_Status_Barang[]" class="form-select">
                                                            @foreach ($statusBarangs as $statusBarang)
                                                                <option value="{{ $statusBarang->id }}"
                                                                    {{ $barangMasuk->Id_Status_Barang == $statusBarang->id ? 'selected' : '' }}>
                                                                    {{ $statusBarang->Nama_Status }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Fungsi untuk menghitung total jumlah barang
                function calculateTotalJumlahBarang() {
                    let total = 0;
                    document.querySelectorAll('input[name="JumlahBarang_Masuk[]"]').forEach(function(input) {
                        total += parseInt(input.value) || 0;
                    });
                    document.getElementById('Jumlah_barang').value = total;
                }

                // Panggil fungsi ini saat halaman dimuat
                calculateTotalJumlahBarang();

                // Panggil fungsi ini setiap kali ada perubahan pada input jumlah barang masuk
                document.querySelectorAll('input[name="JumlahBarang_Masuk[]"]').forEach(function(input) {
                    input.addEventListener('input', calculateTotalJumlahBarang);
                });
            });
        </script>
    @endpush
@endsection
