@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-center mb-4" style="background-color: rgb(1, 1, 95);">
                    <h2 class="h3 mb-0 text-white"><strong>FORM BARANG KELUAR Reguler</strong></h2>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <form action="{{ route('barangkeluar.reguler.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="bg-white justify-content-between rounded shadow p-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <p style="font-weight:bolder">PENGAJUAN PEMINJAMAN BARANG</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_peminjamanbarang">TANGGAL PEMINJAMAN BARANG</label>
                                        <input type="date" class="form-control" placeholder="Masukan Rencana Tanggal Peminjaman Barang" id="tanggal_peminjamanbarang" name="tanggal_peminjamanbarang">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Id_Kategori_Peminjaman">Kategori Peminjaman</label>
                                        <select class="form-control @error('Id_Kategori_Peminjaman') is-invalid @enderror" id="Id_Kategori_Peminjaman" name="Id_Kategori_Peminjaman">
                                            @foreach ($kategoriPeminjamans as $kategoriPeminjaman)
                                                <option value="{{ $kategoriPeminjaman->id }}">{{ $kategoriPeminjaman->Nama_Kategori_Peminjaman }}</option>
                                            @endforeach
                                        </select>
                                        @error('Id_Kategori_Peminjaman')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="items-container" class="p-2">
                            <div class="barang-item bg-white justify-content-between rounded shadow p-3 mt-4">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <p style="font-weight:bolder">Input Barang yang Akan Dipinjam</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nama_barang">Nama Barang</label>
                                            <select class="form-control @error('nama_barang.*') is-invalid @enderror" id="nama_barang" name="nama_barang[]">
                                                @foreach ($Barangs as $barang)
                                                    <option value="{{ $barang->id }}" data-kode="{{ $barang->Kode_Barang }}" data-kategori="{{ $barang->kategoriBarang->Nama_Kategori_Barang }}">{{ $barang->Nama_Barang }}</option>
                                                @endforeach
                                            </select>
                                            @error('nama_barang.*')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="kode_barang">Kode Barang</label>
                                            <input type="text" class="form-control" id="kode_barang" name="kode_barang[]" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Kategori_Barang">Kategori Barang</label>
                                            <input type="text" class="form-control" id="Kategori_Barang" name="Kategori_Barang[]" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="jumlah_barang">Jumlah Barang</label>
                                            <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang[]" min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-primary" id="add-item">Tambah Barang</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const itemsContainer = document.getElementById('items-container');
            const addItemButton = document.getElementById('add-item');
            const barangSelectElements = document.querySelectorAll('select[name="nama_barang[]"]');

            function updateFields(selectElement) {
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                const kodeBarangField = selectElement.closest('.barang-item').querySelector('input[name="kode_barang[]"]');
                const kategoriBarangField = selectElement.closest('.barang-item').querySelector('input[name="Kategori_Barang[]"]');

                kodeBarangField.value = selectedOption.getAttribute('data-kode');
                kategoriBarangField.value = selectedOption.getAttribute('data-kategori');
            }

            barangSelectElements.forEach(function(selectElement) {
                selectElement.addEventListener('change', function() {
                    updateFields(this);
                });

                updateFields(selectElement);
            });

            addItemButton.addEventListener('click', function() {
                const newItem = itemsContainer.children[0].cloneNode(true);
                newItem.querySelectorAll('input').forEach(input => input.value = '');
                newItem.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

                itemsContainer.appendChild(newItem);

                const newBarangSelectElement = newItem.querySelector('select[name="nama_barang[]"]');
                newBarangSelectElement.addEventListener('change', function() {
                    updateFields(this);
                });

                updateFields(newBarangSelectElement);
            });
        });
    </script>
@endsection
