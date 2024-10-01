@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid p-2">
                <form action="{{ route('barangmasuk.update', $barangMasuk->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="container-fluid ">
                        <div class="d-sm-flex align-items-center justify-content-center rounded-top mb-0"
                            style="background-color: rgb(1, 1, 95);">
                            <h1 class="h3 mb-0 text-white"><strong>Masuk</strong></h1>
                        </div>

                        <div class="bg-white justify-content-between rounded-bottom shadow p-4">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_surat">No Surat Jalan</label>
                                        <input type="text" class="form-control @error('No_Surat') is-invalid @enderror"
                                            placeholder="Masukan Nomor Surat" id="no_surat" name="no_surat"
                                            value="{{ $barangMasuk->No_Surat }}">
                                        @error('No_Surat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="namaperusahaan_pengirim">Nama PT</label>
                                        <input type="text"
                                            class="form-control @error('namaperusahaan_pengirim') is-invalid @enderror"
                                            placeholder="Masukan Nama PT" id="namaperusahaan_pengirim"
                                            name="namaperusahaan_pengirim"
                                            value="{{ $barangMasuk->NamaPerusahaan_Pengirim }}">
                                        @error('NamaPerusahaan_Pengirim')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_pengirimanbarang">Tanggal</label>
                                        <input type="date"
                                            class="form-control @error('tanggal_pengirimanbarang') is-invalid @enderror"
                                            placeholder="Masukan Tanggal" id="tanggal_pengirimanbarang"
                                            name="tanggal_pengirimanbarang"
                                            value="{{ $barangMasuk->TanggalPengiriman_Barang }}">
                                        @error('tanggal_pengirimanbarang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="Id_Petugas">Petugas</label>
                                        <input type="text" class="form-control @error('Id_Petugas') is-invalid @enderror"
                                            id="Id_Petugas" name="Id_Petugas" value="{{ auth()->user()->Nama }}" readonly>
                                        @error('TanggalPengiriman_Barang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Jumlah_barang">Jumlah Barang </label>
                                        <input type="text"
                                            class="form-control @error('Jumlah_barang') is-invalid @enderror"
                                            id="jumlah_barangmasuk" name="jumlah_barangmasuk"
                                            value="{{ old('jumlah_barangmasuk') }}" readonly>
                                        @error('Jumlah_barang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="file_suratjalan">Surat Jalan</label>
                                        <!-- Menampilkan file surat jalan lama jika ada -->
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input @error('file_suratjalan') is-invalid @enderror"
                                                id="file_suratjalan" name="file_suratjalan" accept="application/pdf" value="{{$barangMasuk->File_SuratJalan}}">
                                            <label class="custom-file-label" for="file_suratjalan">Pilih file PDF</label>
                                            @error('file_suratjalan')
                                                <div class="text-danger"><small>{{ $message }}</small></div>
                                            @enderror
                                        </div>


                                        <p>Surat Jalan Lama: <a href="{{ $barangMasuk->File_SuratJalan }}"
                                                target="_blank">Lihat File</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach ($barangMasuk->barang as $barang)
                            <div id="items-container" class="p-2">
                                <div class="row mb-3 bg-white justify-content-between rounded-bottom shadow mt-4">
                                    <div class="barang-item d-sm-flex align-items-center justify-content-center  rounded-top mb-4 "
                                        style="background-color: rgb(1, 1, 95); height:50px">
                                        <h5 class="h5 mb-0 text-white">Barang 1</h5>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="kode_barang">Kode Barang</label>
                                            <input type="text"
                                                class="form-control @error('kode_barang') is-invalid @enderror"
                                                id="kode_barang" value="{{ $barang->kode_barang }}"
                                                name="barang[{{ $loop->index }}][kode_barang]">
                                            @error('kode_barang')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nama_barang">Nama Barang</label>
                                            <input type="text"
                                                class="form-control @error('nama_barang') is-invalid @enderror"
                                                id="nama_barang" name="barang[{{ $loop->index }}][nama_barang]"
                                                value="{{ $barang->nama_barang }}">
                                            @error('nama_barang')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="kategori_barang">Kategori Barang</label>
                                            <select name="barang[{{ $loop->index }}][kategori_barang]" id="kategori_barang" class="form-control">
                                                <option value="Hardware">Hardware</option>
                                                <option value="Networking">Networking</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inisiasi_stok">Stok Awal</label>
                                        <div class="form-group">
                                            <input type="number"
                                                class="form-control @error('inisiasi_stok') is-invalid @enderror jumlah-barang-masuk"
                                                id="inisiasi_stok" value="{{ $barang->inisiasi_stok }}"
                                                name="barang[{{ $loop->index }}][inisiasi_stok]">
                                            @error('inisiasi_stok')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <label for="jumlah_barang">Jumlah Barang Saat Ini</label>
                                        <div class="form-group">
                                            <input type="number"
                                                class="form-control @error('jumlah_barang') is-invalid @enderror jumlah-barang-masuk"
                                                id="jumlah_barang" value="{{ $barang->jumlah_barang }}"
                                                name="barang[{{ $loop->index }}][jumlah_barang]">
                                            @error('jumlah_barang')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="garansi_barang_awal">Tanggal Garansi Awal</label>
                                            <input type="date"
                                                class="form-control @error('garansi_barang_awal') is-invalid @enderror"
                                                id="garansi_barang_awal" value="{{ $barang->garansi_barang_awal }}"
                                                name="barang[{{ $loop->index }}][garansi_barang_awal]">
                                            @error('garansi_barang_awal')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="garansi_barang_akhir">Tanggal Garansi Akhir</label>
                                            <input type="date"
                                                class="form-control @error('garansi_barang_akhir') is-invalid @enderror"
                                                id="garansi_barang_akhir" value="{{ $barang->garansi_barang_akhir }}"
                                                name="barang[{{ $loop->index }}][garansi_barang_akhir]">
                                            @error('garansi_barang_akhir')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="tanggal_masuk">Tanggal Masuk</label>
                                            <input type="date"
                                                class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                                id="tanggal_masuk" value="{{ $barang->tanggal_masuk }}"
                                                name="barang[{{ $loop->index }}][tanggal_masuk]">
                                            @error('tanggal_masuk')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <img src="{{ $barang->url_gambar }}" alt="Gambar Barang" width="100">
                                        <div class="form-group">
                                            <label for="gambar_barang">Gambar Barang</label>
                                            <input type="file"
                                                class="form-control @error('gambar_barang') is-invalid @enderror"
                                                id="gambar_barang" name="barang[{{ $loop->index }}][gambar_barang]">
                                            @error('gambar_barang')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="kondisi_barang"
                                                name="barang[{{ $loop->index }}][kondisi_barang]" value="Baru" hidden>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="status" name="barang[{{ $loop->index }}][status]"
                                                value="{{ $barang->Status }}" hidden>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text"
                                                class="form-control @error('jenis_barang') is-invalid @enderror"
                                                id="jenis_barang" name="barang[{{ $loop->index }}][jenis_barang]"
                                                value="{{ $barang->jenis_barang }}" hidden>
                                            @error('jenis_barang')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <div class="col-md-12 d-flex justify-content-end">
                        <a href="{{ route('barangmasuk.index') }}" class="mb-3 mr-3 btn btn-secondary btn-icon-split"
                            style="width: 15%">
                            <span class="text">Batal</span>
                        </a>
                        <button type="submit" class="mb-3 mr-3 btn btn-primary btn-icon-split" style="width: 15%;">
                            <span class="text">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            // Fungsi untuk menghitung total jumlah barang
            function calculateTotalJumlahBarang() {
                let total = 0;

                // Ambil semua elemen input yang memiliki class 'jumlah-barang-masuk'
                document.querySelectorAll('.jumlah-barang-masuk').forEach(function(input) {
                    let jumlah = parseInt(input.value) || 0;
                    total += jumlah;
                });

                // Set nilai dari input field jumlah_barangmasuk
                document.getElementById('jumlah_barangmasuk').value = total;
            }

            // Tambahkan event listener ke setiap input 'jumlah-barang-masuk' untuk menghitung ulang saat nilainya berubah
            document.querySelectorAll('.jumlah-barang-masuk').forEach(function(input) {
                input.addEventListener('input', calculateTotalJumlahBarang);
            });

            // Hitung total saat halaman dimuat pertama kali
            calculateTotalJumlahBarang();
        </script>
    @endpush
@endsection
