@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid p-2">
                <form action="{{ route('barangkeluar.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="container-fluid">
                        <div class="d-sm-flex align-items-center justify-content-center rounded-top"
                            style="background-color: rgb(1, 1, 95);">
                            <h3 class="h4 mb-0 text-white"><strong>PENGAJUAN PEMINJAMAN BARANG</strong></h3>
                        </div>

                        <div class="bg-white justify-content-between rounded-bottom shadow p-4">
                            <div class="row">
                                <input type="text" class="form-control" id="status" name="status" value="Pending"
                                    hidden>
                                <div class="col-md-6" id="peminjaman-input">
                                    <div class="form-group">
                                        <label for="tanggal_peminjamanbarang">Tanggal Peminjaman</label>
                                        <input type="date"
                                            class="form-control @error('tanggal_peminjamanbarang') is-invalid @enderror"
                                            placeholder="Masukan Rencana Tanggal Peminjaman Barang"
                                            id="tanggal_peminjamanbarang" name="tanggal_peminjamanbarang">
                                        @error('tanggal_peminjamanbarang')
                                            <div class="text-danger"><small>{{ $message }}</small></div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6" id="tanggal-pengembalian-container">
                                    <div class="form-group">
                                        <label for="Tanggal_PengembalianBarang">Tanggal Pengembalian</label>
                                        <input type="date"
                                            class="form-control @error('Tanggal_PengembalianBarang') is-invalid @enderror"
                                            placeholder="Masukan Rencana Tanggal Peminjaman Barang"
                                            id="Tanggal_PengembalianBarang" name="Tanggal_PengembalianBarang">
                                        @error('Tanggal_PengembalianBarang')
                                            <div class="text-danger"><small>{{ $message }}</small></div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Kategori">Kategori</label>
                                        <select name="Kategori" id="Kategori" class="form-control">
                                            <option value="Insidentil">Insidentil</option>
                                            <option value="Reguler">Reguler</option>
                                        </select>
                                    </div>
                                    @error('Kategori')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="suratJalan">Surat Jalan</label>
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input @error('File_Surat') is-invalid @enderror"
                                                id="File_Surat" name="File_Surat" accept="application/pdf">
                                            <label class="custom-file-label" for="suratJalan">Pilih file PDF</label>
                                            @error('File_Surat')
                                                <div class="text-danger"><small>{{ $message }}</small></div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="items-container" class="p-2">
                            <div class="row mb-3 bg-white justify-content-between rounded-bottom shadow mt-4 barang-item">
                                <div class="d-sm-flex align-items-center justify-content-center rounded-top mb-4"
                                    style="background-color: rgb(1, 1, 95); height:50px">
                                    <h5 class="h5 mb-0 text-white">Barang 1</h5>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_barang">Nama Barang</label>
                                        <select class="form-control @error('nama_barang.*') is-invalid @enderror"
                                            id="nama_barang" name="nama_barang[]">
                                            @foreach ($allItems as $item)
                                                <option value="{{ $item->nama_barang }}"
                                                    data-kode="{{ $item->kode_barang }}"
                                                    data-jenis="{{ $item->kode_barang }}"
                                                    data-garansi-awal="{{ $item->garansi_barang_awal }}"
                                                    data-garansi-akhir="{{ $item->garansi_barang_akhir }}"
                                                    data-kategori="{{ $item->kategori_barang }}">
                                                    {{ $item->nama_barang }}</option>
                                            @endforeach
                                        </select>


                                        @error('nama_barang.*')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <input type="text" class="form-control" id="kode_barang" name="jenis_barang[]" hidden>
                                <input type="text" class="form-control" id="kode_barang" name="garansi_barang_awal[]"
                                    hidden>
                                <input type="text" class="form-control" id="kode_barang" name="garansi_barang_akhir[]"
                                    hidden>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kode_barang">Kode Barang</label>
                                        <input type="text" class="form-control" id="kode_barang" name="kode_barang[]"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Kategori_Barang">Kategori Barang</label>
                                        <input type="text" class="form-control" id="Kategori_Barang"
                                            name="Kategori_Barang[]" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jumlah_barang">Jumlah Barang</label>
                                        <input type="number"
                                            class="form-control @error('jumlah_barang.*') is-invalid @enderror"
                                            id="jumlah_barang" name="jumlah_barang[]" min="1">
                                        @error('jumlah_barang.*')
                                            <div class="text-danger"><small>{{ $message }}</small></div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-3">
                        <button type="button" class="btn btn-primary" id="add-item">Tambah Barang</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const itemsContainer = document.getElementById('items-container');
            const addItemButton = document.getElementById('add-item');
            const kategoriSelect = document.getElementById('Kategori');
            const tanggalPengembalianContainer = document.getElementById('tanggal-pengembalian-container');
            const peminjamanInput = document.getElementById('peminjaman-input');

            function updateFields(selectElement) {
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                const barangItem = selectElement.closest('.barang-item');
                const kodeBarangField = barangItem.querySelector('input[name="kode_barang[]"]');
                const kategoriBarangField = barangItem.querySelector('input[name="Kategori_Barang[]"]');
                const jenisbarangField = barangItem.querySelector('input[name="jenis_barang[]"]');
                const garansiawalField = barangItem.querySelector('input[name="garansi_barang_awal[]"]');
                const garansiakhirField = barangItem.querySelector('input[name="garansi_barang_akhir[]"]');

                kodeBarangField.value = selectedOption.getAttribute('data-kode');
                kategoriBarangField.value = selectedOption.getAttribute('data-kategori');
                jenisbarangField.value = selectedOption.getAttribute('data-jenis');
                garansiawalField.value = selectedOption.getAttribute('data-garansi-awal');
                garansiakhirField.value = selectedOption.getAttribute('data-garansi-akhir');
            }

            function initializeSelects(container) {
                const barangSelectElements = container.querySelectorAll('select[name="nama_barang[]"]');

                barangSelectElements.forEach(function(selectElement) {
                    selectElement.addEventListener('change', function() {
                        updateFields(this);
                    });

                    updateFields(selectElement);
                });
            }

            function toggleTanggalPengembalian() {
                if (kategoriSelect.value === 'Reguler') {
                    tanggalPengembalianContainer.style.display = 'none';
                    peminjamanInput.classList.remove('col-md-6');
                    peminjamanInput.classList.add('col-md-12');
                } else {
                    tanggalPengembalianContainer.style.display = 'block';
                    peminjamanInput.classList.remove('col-md-12');
                    peminjamanInput.classList.add('col-md-6');
                }
            }

            kategoriSelect.addEventListener('change', toggleTanggalPengembalian);

            // Initialize the display based on the current selection
            toggleTanggalPengembalian();

            addItemButton.addEventListener('click', function() {
                const newItem = itemsContainer.querySelector('.barang-item').cloneNode(true);
                newItem.querySelector('h5').textContent = 'Barang ' + (itemsContainer.children.length + 1);
                newItem.querySelectorAll('input').forEach(input => input.value = '');
                newItem.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

                itemsContainer.appendChild(newItem);

                initializeSelects(newItem);
            });

            initializeSelects(document);
        });
    </script>
@endsection
