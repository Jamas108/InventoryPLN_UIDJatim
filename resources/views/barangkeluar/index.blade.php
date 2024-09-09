@extends('layouts.app')

@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $('#barangkeluarTable').DataTable();
        });
    </script>
@endpush

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
                            <table class="table table-bordered table-hover mb-0 bg-white" id="barangkeluarTable"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col" style="width: 30px; color:white">No</th>
                                        <th class="text-center" scope="col" style="width: 300px; color:white">Surat Jalan
                                        </th>
                                        <th class="text-center" scope="col" style="width: 300px; color:white">Berita
                                            Acara</th>
                                        <th class="text-center" scope="col" style="width: 300px; color:white">Pihak
                                            Peminjam</th>
                                        <th class="text-center" scope="col" style="width: 300px; color:white">Tanggal
                                            Peminjaman</th>
                                        <th class="text-center" scope="col" style="width: 30px; color:white">Total Barang
                                        </th>
                                        <th class="text-center" scope="col" style="width: 300px; color:white">Deadline
                                        </th>
                                        <th class="text-center" scope="col" style="width: 300px; color:white">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($groupedBarangKeluars as $group)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                @if (!empty($group['File_Surat']))
                                                    <a class="btn btn-sm btn-secondary" href="{{ $group['File_Surat'] }}"
                                                        target="_blank">Lihat Surat
                                                        Jalan</a>
                                                @else
                                                    <span>Tidak Ada</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if (!empty($group['File_BeritaAcara']))
                                                    <a style="width: 100%" href="{{ $group['File_BeritaAcara'] }}"
                                                        target="_blank" class="btn btn-sm btn-info">Lihat BA</a>
                                                @else
                                                    <span>Belum Dibuat</span>
                                                @endif
                                            </td>

                                            <td class="text-center">{{ $group['Nama_PihakPeminjam'] }}</td>
                                            <td class="text-center">{{ $group['tanggal_peminjamanbarang'] }}</td>
                                            <td class="text-center">{{ $group['total_barang'] }}</td>
                                            <td class="text-center">
                                                @if (!empty($group['Tanggal_PengembalianBarang']))
                                                    <span id="countdown-{{ $group['tanggal_peminjamanbarang'] }}"
                                                        class="badge custom-badge"></span>
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function() {
                                                            function getRemainingTime(startDate, returnDate) {
                                                                const end = new Date(returnDate);
                                                                const start = new Date(startDate);
                                                                let timeDiff = end - start;
                                                                if (start > end) return "Expired";
                                                                const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                                                                timeDiff -= days * (1000 * 60 * 60 * 24);
                                                                const hours = Math.floor(timeDiff / (1000 * 60 * 60));
                                                                timeDiff -= hours * (1000 * 60 * 60);
                                                                const minutes = Math.floor(timeDiff / (1000 * 60));
                                                                timeDiff -= minutes * (1000 * 60);

                                                                return `${days}d ${hours}h ${minutes}m`;
                                                            }

                                                            function updateCountdown() {
                                                                const startDate = "{{ $group['tanggal_peminjamanbarang'] }}";
                                                                const returnDate = "{{ $group['Tanggal_PengembalianBarang'] }}";
                                                                const countdownElement = document.getElementById(
                                                                    'countdown-{{ $group['tanggal_peminjamanbarang'] }}');
                                                                const remainingTime = getRemainingTime(startDate, returnDate);

                                                                if (new Date() > new Date(returnDate)) {
                                                                    countdownElement.innerHTML = `<span class="h1 badge bg-danger custom-badge">Expired</span>`;
                                                                } else {
                                                                    countdownElement.innerHTML =
                                                                        `<span class="badge bg-warning custom-badge">${remainingTime}</span>`;
                                                                }
                                                            }

                                                            updateCountdown();
                                                            setInterval(updateCountdown, 1000);
                                                        });
                                                    </script>
                                                @else
                                                    <span class="badge bg-success custom-badge">Reguler</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a class="btn btn-warning btn-md"
                                                        href="{{ route('barangkeluar.show', $group['id']) }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    {{-- Cek apakah kategori reguler --}}
                                                    @if ($group['Kategori_Peminjaman'] == 'Reguler')
                                                        <a href="{{ route('barangkeluar.createBeritaAcaraReguler', ['id' => $group['id']]) }}"
                                                            class="btn btn-primary btn-md mr-2 ml-2">
                                                            <i class="fas fa-file-alt"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('barangkeluar.createBeritaAcara', ['id' => $group['id']]) }}"
                                                            class="btn btn-primary btn-md mr-2 ml-2">
                                                            <i class="fas fa-file-alt"></i>
                                                        </a>
                                                    @endif
                                                    <a href=""
                                                        class="btn btn-danger btn-md">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
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
