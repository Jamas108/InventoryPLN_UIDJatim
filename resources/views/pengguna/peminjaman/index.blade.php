@extends('layouts.apppengguna')

@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $('#penggunaTable').DataTable();
        });
    </script>
@endpush

@section('content')
    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="index.html" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 class="sitename">Inventory PLN</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero">Katalog</a></li>
                    <li><a href="#about">Tentang</a></li>
                    <li><a href="#services">Profil</a></li>
                    <li><a href="{{ route('userinventory.index') }}">Peminjaman Anda</a></li>
                </ul>
            </nav>

            <a class="btn-getstarted" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">
            <div class="container-fluid mt-5 px-5">
                <div class="justify-content-between rounded shadow p-4" style="background-color: rgb(18, 115, 114)">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-items-center table-hover mb-0 bg-white"
                            id="penggunaTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle" scope="col" style="width: 30px;">No</th>
                                    <th class="text-center align-middle" scope="col" style="width: 300px;">Surat Jalan
                                    </th>
                                    <th class="text-center align-middle" scope="col" style="width: 300px;">Berita
                                        Acara</th>
                                    <th class="text-center align-middle" scope="col" style="width: 300px;">Tanggal
                                        Peminjaman</th>
                                    <th class="text-center align-middle" scope="col" style="width: 30px;">Total Barang
                                    </th>
                                    <th class="text-center align-middle" scope="col" style="width: 300px;">Deadline
                                    </th>
                                    <th class="text-center align-middle" scope="col" style="width: 300px;">Status
                                    </th>
                                    <th class="text-center align-middle" scope="col" style="width: 300px;">Action</th>
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
                                        <td class="text-center">{{ $group['tanggal_peminjamanbarang'] }}</td>
                                        <td class="text-center">{{ $group['total_barang'] }}</td>
                                        <td class="text-center">
                                            @if (!empty($group['Tanggal_PengembalianBarang']))
                                                <span id="countdown-{{ $group['tanggal_peminjamanbarang'] }}"
                                                    class="badge custom-badge"></span>
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
                                        <td class="text-center">{{ $group['status'] }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a class="btn btn-warning btn-md"
                                                    href="{{ route('barangkeluar.show', $group['id']) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('barangkeluar.createBeritaAcara', ['id' => $group['id']]) }}"
                                                    class="btn btn-primary btn-md mr-2 ml-2"><i
                                                        class="fas fa-file-alt"></i></a>
                                                <a href="{{ route('barangkeluar.createBeritaAcara', ['id' => $group['id']]) }}"
                                                    class="btn btn-danger btn-md"><i class="fas fa-trash"></i></a>
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

        </section><!-- /Hero Section -->
    </main>
    </div>
@endsection
