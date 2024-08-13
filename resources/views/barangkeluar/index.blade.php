@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Barang Keluar</h1>
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                                <i class="fas fa-download fa-sm text-white-50"></i> Download PDF</a>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                                <i class="fas fa-download fa-sm text-white-50"></i> Download Excel</a>
                            <a href="{{ route('barangkeluar.create') }}"
                                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Barang Keluar </a>
                        </li>
                    </ul>
                </div>
                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-center align-middle table-hover mb-0" id="ProductTable"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 300px; color:white">Surat Jalan</th>
                                        <th scope="col" style="width: 300px; color:white">Berita Acara</th>
                                        <th scope="col" style="width: 300px; color:white">Pihak Peminjam</th>
                                        <th scope="col" style="width: 300px; color:white">Tanggal Peminjaman</th>
                                        <th scope="col" style="width: 300px; color:white">Total Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Deadline</th>
                                        <th scope="col" style="width: 300px; color:white">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($groupedBarangKeluars as $group)
                                        <tr>
                                            <td>
                                                @if (!empty($group['File_SuratJalan']))
                                                    <a href="{{ $group['File_SuratJalan'] }}" target="_blank">Lihat Surat
                                                        Jalan</a>
                                                @else
                                                    <span>Tidak Ada</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($group['File_BeritaAcara']))
                                                    <a href="{{ $group['File_BeritaAcara'] }}" target="_blank"
                                                        class="btn btn-sm btn-info">Lihat Berita Acara</a>
                                                @else
                                                    <span>Tidak Ada</span>
                                                @endif
                                            </td>

                                            <td>{{ $group['Nama_PihakPeminjam'] }}</td>
                                            <td>{{ $group['tanggal_peminjamanbarang'] }}</td>
                                            <td>{{ $group['total_barang'] }}</td>
                                            <td>
                                                <span id="countdown-{{ $group['tanggal_peminjamanbarang'] }}"></span>
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        function getRemainingTime(startDate, returnDate) {
                                                            const now = new Date();
                                                            const end = new Date(returnDate);
                                                            const start = new Date(startDate);
                                                            let timeDiff = end - now;
                                                            if (now > end) return "Expired";
                                                            const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                                                            timeDiff -= days * (1000 * 60 * 60 * 24);
                                                            const hours = Math.floor(timeDiff / (1000 * 60 * 60));
                                                            timeDiff -= hours * (1000 * 60 * 60);
                                                            const minutes = Math.floor(timeDiff / (1000 * 60));
                                                            timeDiff -= minutes * (1000 * 60);
                                                            const seconds = Math.floor(timeDiff / 1000);
                                                            return `${days} days ${hours} hours ${minutes} minutes ${seconds} seconds`;
                                                        }

                                                        function updateCountdown() {
                                                            const startDate = "{{ $group['tanggal_peminjamanbarang'] }}";
                                                            const returnDate = "{{ $group['Tanggal_PengembalianBarang'] }}";
                                                            const countdownElement = document.getElementById(
                                                                'countdown-{{ $group['tanggal_peminjamanbarang'] }}');
                                                            countdownElement.innerText = getRemainingTime(startDate, returnDate);
                                                        }

                                                        updateCountdown();
                                                        setInterval(updateCountdown, 1000);
                                                    });
                                                </script>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-{{ $group['tanggal_peminjamanbarang'] }}"
                                                    aria-expanded="false"
                                                    aria-controls="collapse-{{ $group['tanggal_peminjamanbarang'] }}">
                                                    +
                                                </button>
                                                <a href="{{ route('barangkeluar.createBeritaAcara', ['id' => $group['id']]) }}"
                                                    class="btn btn-primary">Buat Berita Acara</a>


                                            </td>
                                        </tr>
                                        <tr id="collapse-{{ $group['tanggal_peminjamanbarang'] }}" class="collapse"
                                            data-bs-parent="#ProductTable">
                                            <td colspan="7">
                                                <div class="accordion-body">
                                                    <table class="table inner-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Kode Barang</th>
                                                                <th>Nama Barang</th>
                                                                <th>Kuantitas</th>
                                                                <th>Kategori Barang</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($group['items'] as $item)
                                                                <tr>
                                                                    <td>{{ $item->kode_barang }}</td>
                                                                    <td>{{ $item->nama_barang }}</td>
                                                                    <td>{{ $item->jumlah_barang }}</td>
                                                                    <td>{{ $item->kategori_barang }}</td>
                                                                    {{-- <td>
                                                                        <a href="{{ route('retur.create', ['id' => $item->id, 'kode_barang' => $item->kode_barang, 'nama_barang' => $item->nama_barang, 'pihak_peminjam' => $group['Nama_PihakPeminjam'], 'kategori_barang' => $item->kategori_barang]) }}"
                                                                            class="btn btn-warning btn-sm">Retur Barang</a>
                                                                    </td> --}}
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">Tidak ada barang keluar.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
