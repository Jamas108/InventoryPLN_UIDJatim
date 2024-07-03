@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Barang Masuk</h1>
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download PDF</a>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download Excel</a>
                            <a href="{{ route('barangmasuk.create') }}"
                                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                    class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Barang </a>
                        </li>
                    </ul>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            @forelse ($groupedBarangMasuks as $noSurat => $barangMasuks)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-{{ $noSurat }}" aria-expanded="false"
                                            aria-controls="collapse-{{ $noSurat }}">
                                            No Surat: {{ $noSurat }}
                                        </button>
                                    </h2>
                                    <div id="collapse-{{ $noSurat }}" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Kode Barang</th>
                                                        <th>Nama Barang</th>
                                                        <th>Kuantitas</th>
                                                        <th>Kategori Barang</th>
                                                        <th>Status Barang</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($barangMasuks as $barangMasuk)
                                                        <tr>
                                                            <td>{{ $barangMasuk->Kode_Barang }}</td>
                                                            <td>{{ $barangMasuk->Nama_Barang }}</td>
                                                            <td>{{ $barangMasuk->JumlahBarang_Masuk }}</td>
                                                            <td>{{ $barangMasuk->kategoriBarang->Nama_Kategori_Barang }}
                                                            </td>
                                                            <td>
                                                                <form action="{{ route('barangmasuk.update', $barangMasuk->id) }}" method="POST"
                                                                    class="d-flex align-items-center">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <select name="Id_Status_Barang" class="form-select form-select-sm me-1"
                                                                        aria-label="Ubah Status">
                                                                        @foreach($statusBarangs as $statusBarang)
                                                                        <option value="{{ $statusBarang->id }}"
                                                                            {{ $barangMasuk->Id_Status_Barang == $statusBarang->id ? 'selected' : '' }}>
                                                                            {{ $statusBarang->Nama_Status }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <button type="submit" class="btn btn-sm btn-primary"><i
                                                                            class="fas fa-save"></i></button>
                                                                </form>
                                                            </td>
                                                            <td>
                                                                <a href="" class="btn btn-primary btn-sm">Edit Barang Masuk</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>Tidak ada barang masuk.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
