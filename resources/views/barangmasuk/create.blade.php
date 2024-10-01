@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid p-2">
                <form action="{{ route('barangmasuk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="container-fluid ">
                        <div class="d-sm-flex align-items-center justify-content-center rounded-top mb-0"
                            style="background-color: rgb(1, 1, 95);">
                            <h1 class="h3 mb-0 text-white"><strong>Masuk</strong></h1>
                        </div>

                        <div class="bg-white justify-content-between rounded-bottom shadow p-4">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="No_Surat">No Surat Jalan</label>
                                        <input type="text" class="form-control @error('No_Surat') is-invalid @enderror"
                                            placeholder="Masukan Nomor Surat" id="No_Surat" name="No_Surat"
                                            value="{{ old('No_Surat') }}">
                                        @error('No_Surat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="NamaPerusahaan_Pengirim">Nama PT</label>
                                        <input type="text"
                                            class="form-control @error('NamaPerusahaan_Pengirim') is-invalid @enderror"
                                            placeholder="Masukan Nama PT" id="NamaPerusahaan_Pengirim"
                                            name="NamaPerusahaan_Pengirim" value="{{ old('NamaPerusahaan_Pengirim') }}">
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
                                        <label for="TanggalPengiriman_Barang">Tanggal</label>
                                        <input type="date"
                                            class="form-control @error('TanggalPengiriman_Barang') is-invalid @enderror"
                                            placeholder="Masukan Tanggal" id="TanggalPengiriman_Barang"
                                            name="TanggalPengiriman_Barang" value="{{ old('TanggalPengiriman_Barang') }}">
                                        @error('TanggalPengiriman_Barang')
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
                                        <label for="Jumlah_barang">Jumlah Barang</label>
                                        <input type="text"
                                            class="form-control @error('Jumlah_barang') is-invalid @enderror"
                                            id="Jumlah_barang" name="jumlah_barangmasuk"
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
                                        <label for="File_SuratJalan">Surat Jalan</label>
                                        <input type="file"
                                            class="form-control @error('File_SuratJalan') is-invalid @enderror"
                                            id="File_SuratJalan" name="File_SuratJalan">
                                        @error('File_SuratJalan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="items-container" class="p-2">
                            <div class="row mb-3 bg-white justify-content-between rounded-bottom shadow mt-4">
                                <div class="barang-item d-sm-flex align-items-center justify-content-center  rounded-top mb-4 "
                                    style="background-color: rgb(1, 1, 95); height:50px">
                                    <h5 class="h5 mb-0 text-white">Barang 1</h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Kode_Barang">Kode Barang</label>
                                        <input type="text"
                                            class="form-control @error('Kode_Barang.0') is-invalid @enderror" id="Kode_Barang[]"
                                            name="Kode_Barang[]" value="{{ old('Kode_Barang.0') }}" placeholder="Masukan Kode Barang">
                                        @error('Kode_Barang.0')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Nama_Barang">Nama Barang</label>
                                        <input type="text"
                                            class="form-control @error('Nama_Barang.0') is-invalid @enderror" id="Nama_Barang[]"
                                            name="Nama_Barang[]" value="{{ old('Nama_Barang.0') }}" placeholder="Masukan Nama Barang">
                                        @error('Nama_Barang.0')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Id_Kategori_Barang">Kategori Barang</label>
                                        <select name="Kategori_Barang[]" id="Kategori_Barang[]" class="form-control">
                                            <option value="Hardware">Hardware</option>
                                            <option value="Networking">Networking</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="JumlahBarang_Masuk">Jumlah Barang Masuk</label>
                                    <div class="form-group">
                                        <input type="number"
                                            class="form-control @error('JumlahBarang_Masuk.0') is-invalid @enderror jumlah-barang-masuk"
                                            id="JumlahBarang_Masuk[]" name="JumlahBarang_Masuk[]"
                                            value="{{ old('JumlahBarang_Masuk.0') }}" placeholder="Masukan Jumlah Barang">
                                        @error('JumlahBarang_Masuk.0')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Garansi_Barang">Tanggal Garansi Awal</label>
                                        <input type="date"
                                            class="form-control @error('Garansi_Barang_Awal.0') is-invalid @enderror"
                                            id="Garansi_Barang_Awal[]" name="Garansi_Barang_Awal[]"
                                            value="{{ old('Garansi_Barang_Awal.0') }}" placeholder="Masukan Garansi Barang Awal">
                                        @error('Garansi_Barang_Awal.0')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Garansi_Barang">Tanggal Garansi Akhir</label>
                                        <input type="date"
                                            class="form-control @error('Garansi_Barang_Akhir.0') is-invalid @enderror"
                                            id="Garansi_Barang_Akhir[]" name="Garansi_Barang_Akhir[]"
                                            value="{{ old('Garansi_Barang_Akhir.0') }}" placeholder="Masukan Garansi Barang Akhir">
                                        @error('Garansi_Barang_Akhir.0')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Tanggal_Masuk">Tanggal Masuk</label>
                                        <input type="date"
                                            class="form-control @error('Tanggal_Masuk.0') is-invalid @enderror"
                                            id="Tanggal_Masuk[]" name="Tanggal_Masuk[]"
                                            value="{{ old('Tanggal_Masuk.0') }}">
                                        @error('Tanggal_Masuk.0')
                                            <span class="invalid-feedback" role="alert" placeholder="Masukan Tanggal Masuk Barang">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Gambar_Barang">Gambar Barang</label>
                                        <input type="file"
                                            class="form-control @error('Gambar_Barang.0') is-invalid @enderror"
                                            id="Gambar_Barang[]" name="Gambar_Barang[]">
                                        @error('Gambar_Barang.0')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="Kondisi_Barang[]"
                                            name="Kondisi_Barang[]" value="Baru" hidden>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="Status[]" name="Status[]"
                                            value="Pending" hidden>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text"
                                            class="form-control @error('Jenis_Barang') is-invalid @enderror"
                                            id="Jenis_Barang[]" name="Jenis_Barang[]"
                                            value="Baru" hidden>
                                        @error('Jenis_Barang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 d-flex justify-content-start">
                        <button type="button" class="btn btn-secondary" id="add-item">Tambah Barang</button>
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
        document.getElementById('add-item').addEventListener('click', function() {
            const container = document.getElementById('items-container');
            const itemCount = container.getElementsByClassName('barang-item').length;

            if (itemCount < 20) {
                const newItem = container.firstElementChild.cloneNode(true);
                newItem.querySelector('h5').textContent = 'Barang ' + (itemCount + 1);
                newItem.querySelectorAll('input').forEach(input => input.value = '');
                newItem.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
                container.appendChild(newItem);
            } else {
                alert('Anda hanya dapat menambahkan hingga 20 barang.');
            }
        });

        function updateJumlahBarang() {
            let total = 0;
            document.querySelectorAll('.jumlah-barang-masuk').forEach(input => {
                const jumlah = parseInt(input.value);
                if (!isNaN(jumlah)) {
                    total += jumlah;
                }
            });
            document.getElementById('Jumlah_barang').value = total;
        }

        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('jumlah-barang-masuk')) {
                updateJumlahBarang();
            }
        });
    </script>
@endpush
@endsection
