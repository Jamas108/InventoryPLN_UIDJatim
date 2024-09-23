@extends('layouts.app')

@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $('#barangkeluarTable').DataTable();

            // Event listener untuk tombol retur
            $(".datatable").on("click", ".btn-retur", function(e) {
                e.preventDefault();

                var id = $(this).data("id"); // Ambil ID dari tombol retur

                // Redirect ke rute create retur berdasarkan ID
                window.location.href = `/retur/create/${id}`;
            });

            $(".datatable").on("click", ".btn-delete", function(e) {
                e.preventDefault();

                var form = $(this).closest("form");
                var name = $(this).data("name");

                Swal.fire({
                    title: "Apakah Anda Yakin Ingin Menghapus Peminjaman Atas Nama \n" + name + "?",
                    text: "Data Akan Terhapus Secara Permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "bg-primary",
                    confirmButtonText: "Ya, Hapus Sekarang!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
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
                    {{-- hilangkan bagian ini karena ini nnti dri user --}}
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            <a href="{{ route('barangkeluar.create') }}"
                                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Barang Keluar </a>
                        </li>
                    </ul>
                </div>
                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0 bg-white datatable" id="barangkeluarTable"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle" scope="col"
                                            style="width: 30px; color:white">No</th>
                                        <th class="text-center align-middle" scope="col"
                                            style="width: 300px; color:white">Surat Jalan
                                        </th>
                                        <th class="text-center align-middle" scope="col"
                                            style="width: 300px; color:white">Berita
                                            Acara</th>
                                        <th class="text-center align-middle" scope="col"
                                            style="width: 300px; color:white">Pihak
                                            Peminjam</th>
                                        <th class="text-center align-middle" scope="col"
                                            style="width: 300px; color:white">Tanggal
                                            Peminjaman</th>
                                        <th class="text-center align-middle" scope="col"
                                            style="width: 30px; color:white">Total Barang
                                        </th>
                                        <th class="text-center align-middle" scope="col"
                                            style="width: 300px; color:white">Kategori
                                        </th>
                                        <th class="text-center align-middle" scope="col"
                                            style="width: 300px; color:white">Deadline
                                        </th>
                                        <th class="text-center align-middle" scope="col"
                                            style="width: 300px; color:white">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($groupedBarangKeluars as $group)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">
                                                @if (!empty($group['File_Surat']))
                                                    <a class="btn btn-sm btn-secondary" href="{{ $group['File_Surat'] }}"
                                                        target="_blank">Lihat Surat
                                                    </a>
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
                                            <td class="text-center">{{ $group['Kategori_Peminjaman'] }}</td>
                                            <td class="text-center">
                                                @if ($group['status'] == 'Pending')
                                                    <span class="badge bg-warning custom-badge">Pending</span>
                                                @elseif (!empty($group['Tanggal_PengembalianBarang']))
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
                                                    <a class="btn btn-warning btn-sm"
                                                        href="{{ !empty($group['id']) ? route('barangkeluar.show', $group['id']) : '#' }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if (Auth::user()->Id_Role == 2)
                                                        @if (!empty($group['id']) && $group['Kategori_Peminjaman'] == 'Reguler')
                                                            <a href="{{ route('barangkeluar.createBeritaAcaraReguler', ['id' => $group['id']]) }}"
                                                                class="btn btn-primary btn-sm mr-2 ml-2">
                                                                <i class="fas fa-file-alt"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('barangkeluar.createBeritaAcara', ['id' => $group['id']]) }}"
                                                                class="btn btn-primary btn-sm mr-2 ml-2">
                                                                <i class="fas fa-file-alt"></i>
                                                            </a>
                                                        @endif


                                                        @if (!empty($group['id']) && $group['Kategori_Peminjaman'] == 'Reguler')
                                                            <button class="btn btn-info btn-sm mr-2" type="button"
                                                                data-toggle="modal"
                                                                data-target="#modal-{{ $group['id'] }}"
                                                                aria-expanded="false"
                                                                aria-controls="#modal-{{ $group['id'] }}">
                                                                <i class="fas fa-undo"></i>
                                                            </button>
                                                        @else
                                                            <a href="{{ route('barangkeluar.return', $group['id']) }}"
                                                                class="btn btn-success btn-sm mr-2">
                                                                <i class="fas fa-check"></i>
                                                            </a>
                                                        @endif
                                                    @endif

                                                    @if (Auth::user()->Id_Role == 2)
                                                        @if (!empty($group['id']))
                                                            <form
                                                                action="{{ route('barangkeluar.destroy', $group['id']) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-sm me-2 btn-delete"
                                                                    data-name="{{ $group['Nama_PihakPeminjam'] }}">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>

                                                            </form>
                                                        @else
                                                            <button disabled class="btn btn-danger btn-sm"><i
                                                                    class="fas fa-trash"></i></button>
                                                        @endif
                                                    @else
                                                        @if (!empty($group['id']))
                                                            <form
                                                                action="{{ route('barangkeluar.destroy', $group['id']) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-sm ml-2 me-2 btn-delete"
                                                                    data-name="{{ $group['Nama_PihakPeminjam'] }}">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>

                                                            </form>
                                                        @else
                                                            <button disabled class="btn btn-danger btn-sm"><i
                                                                    class="fas fa-trash"></i></button>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="" style="margin-left: -30px">
                                <ul>
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <p><b>Keterangan :</b></p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div href="" class="btn btn-warning btn-sm" style="width: 3%">
                                                <i class="fas fa-eye"></i>
                                            </div>
                                            <p class="ml-2">Melihat Detail Barang</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div href="" class="btn btn-primary btn-sm mt-2" style="width: 3%">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                            <p class="ml-2 mt-1">Membuat Berita Acara</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div href="" class="btn btn-success btn-sm mt-2" style="width: 3%">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <p class="ml-2 mt-1">Peminjaman Insidentil Sudah Dikembalikan</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div href="" class="btn btn-info btn-sm mt-2" style="width: 3%">
                                                <i class="fas fa-undo"></i>
                                            </div>
                                            <p class="ml-2 mt-1">Peminjaman Reguler Diretur</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div href="" class="btn btn-danger btn-sm mt-2" style="width: 3%">
                                                <i class="fas fa-trash"></i>
                                            </div>
                                            <p class="ml-2 mt-1">Hapus Item</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($groupedBarangKeluars as $group)
        <div class="modal fade" id="modal-{{ $group['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="modalLabel-{{ $group['id'] }}" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 80%; width: 800px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel-{{ $group['id'] }}">Pilih Barang Yang Akan Diretur</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table inner-table table-bordered" id="barangmasukTable">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">No</th>
                                    <th class="text-center align-middle">id barang</th>
                                    <th class="text-center align-middle">Kode Barang</th>
                                    <th class="text-center align-middle">Nama Barang</th>
                                    <th class="text-center align-middle">Kuantitas</th>
                                    <th class="text-center align-middle">Kategori Barang</th>
                                    <th class="text-center align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($group['items'] as $barang)
                                    <tr>
                                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                        <td class="text-center align-middle">{{ $barang->id }}</td>
                                        <td class="text-center align-middle">{{ $barang->kode_barang }}</td>
                                        <td class="text-center align-middle">{{ $barang->nama_barang }}</td>
                                        <td class="text-center align-middle">{{ $barang->jumlah_barang }}</td>
                                        <td class="text-center align-middle">{{ $barang->kategori_barang }}</td>
                                        <td class="text-center align-middle">
                                            <a class="btn btn-info btn-sm"
                                                href="{{ route('retur.create', ['barangKeluarId' => $group['id'], 'barangId' => $barang->id]) }}">
                                                <i class="fas fa-undo"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="button" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
