@extends('layouts.app')

@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $('#barangmasukTable').DataTable();
        });

        $(".datatable").on("click", ".btn-delete", function(e) {
            e.preventDefault();

            var form = $(this).closest("form");
            var name = $(this).data("name");

            Swal.fire({
                title: "Apakah yakin menghapus barang?",
                text: "Data yang dihapus tidak dapat kembali!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonClass: "bg-primary",
                confirmButtonText: "Ya, hapus barang",
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
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
                    <h1 class="h3 mb-0 text-gray-800">Barang Masuk</h1>
                    @if (Auth::user()->Id_Role == 2)
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            <a href="{{ route('barangmasuk.create') }}"
                                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Barang
                            </a>
                        </li>
                    </ul>
                    @endif
                </div>
                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-center table-bordered align-middle table-hover mb-0 datatable"
                                id="barangmasukTable" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="color:white">No</th>
                                        <th scope="col" style="width: 300px; color:white">No. Surat Jalan</th>
                                        <th scope="col" style="width: 300px; color:white">Nama PT</th>
                                        <th scope="col" style="width: 300px; color:white">Total Barang</th>
                                        <th scope="col" style="width: 300px; color:white">Approval Status</th>
                                        <th scope="col" style="width: 250px; color:white">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($groupedBarangMasuks as $barangMasuks)
                                        <tr>
                                            <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                            <td>{{ $barangMasuks['No_Surat'] }}</td>
                                            <td>{{ $barangMasuks['NamaPerusahaan_Pengirim'] }}</td>
                                            <td>{{ $barangMasuks['Jumlah_BarangMasuk'] }}</td>
                                            <td>{{ $barangMasuks['Status'] }}</td>
                                            <td>
                                                <button class="btn btn-info btn-sm" type="button" data-toggle="modal"
                                                    data-target="#modal-{{ $barangMasuks['id'] }}" aria-expanded="false"
                                                    aria-controls="#modal-{{ $barangMasuks['id'] }}">
                                                    <i class="fas fa-boxes"></i>
                                                </button>
                                                <a href="{{ route('barangmasuk.show', $barangMasuks['id']) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                    
                                                </a>
                                                <a href="{{ route('barangmasuk.edit', $barangMasuks['id']) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('barangmasuk.destroy', $barangMasuks['id']) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
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
                                            <div href="" class="btn btn-info btn-sm" style="width: 3%">
                                                <i class="fas fa-boxes"></i>
                                            </div>
                                            <p class="ml-2">Melihat Daftar Barang</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div href="" class="btn btn-warning btn-sm mt-2" style="width: 3%">
                                                <i class="fas fa-eye"></i>
                                            </div>
                                            <p class="ml-2 mt-1">Melihat Detail Item</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div href="" class="btn btn-primary btn-sm mt-2" style="width: 3%">
                                                <i class="fas fa-edit"></i>
                                            </div>
                                            <p class="ml-2 mt-1">Edit Item</p>
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
    @foreach ($groupedBarangMasuks as $barangMasuks)
        <div class="modal fade" id="modal-{{ $barangMasuks['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="modalLabel-{{ $barangMasuks['id'] }}" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 80%; width: 800px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel-{{ $barangMasuks['id'] }}">List Barang Masuk</h5>
                        @if (Auth::user()->Id_Role == 2)
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        @endif
                    </div>
                    <div class="modal-body">
                        <table class="table inner-table table-bordered" id="barangmasukTable">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">No</th>
                                    <th class="text-center align-middle">Kode Barang</th>
                                    <th class="text-center align-middle">Nama Barang</th>
                                    <th class="text-center align-middle">Kuantitas</th>
                                    <th class="text-center align-middle">Kategori Barang</th>
                                    <th class="text-center align-middle">Garansi Barang</th>
                                    <th class="text-center align-middle">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangMasuks['items'] as $barangMasuk)
                                    <tr>
                                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                        <td class="text-center align-middle">{{ $barangMasuk->kode_barang }}</td>
                                        <td class="text-center align-middle">{{ $barangMasuk->nama_barang }}</td>
                                        <td class="text-center align-middle">{{ $barangMasuk->inisiasi_stok }}</td>
                                        <td class="text-center align-middle">{{ $barangMasuk->kategori_barang }}</td>
                                        <td class="text-center align-middle">
                                            @if ($barangMasuk->sisa_hari_garansi == 'Garansi tidak tersedia')
                                                <span class="text-warning">{{ $barangMasuk->sisa_hari_garansi }}</span>
                                            @elseif($barangMasuk->sisa_hari_garansi == 'Garansi telah berakhir')
                                                <span class="text-danger">{{ $barangMasuk->sisa_hari_garansi }}</span>
                                            @else
                                                {{ $barangMasuk->sisa_hari_garansi }}
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            <form
                                                action="{{ route('barangmasuk.updateStatus', ['itemId' => $barangMasuks['id'], 'barangId' => $barangMasuk->id]) }}"
                                                method="POST">
                                                @csrf
                                                @if (Auth::user()->Id_Role == 1)
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <select name="Status" id="status"
                                                            class="form-control form-control-sm w-auto">
                                                            <option value="Accept"
                                                                {{ $barangMasuk->Status == 'Accept' ? 'selected' : '' }}>
                                                                Accept</option>
                                                            <option value="Pending"
                                                                {{ $barangMasuk->Status == 'Pending' ? 'selected' : '' }}>
                                                                Pending</option>
                                                            <option value="Reject"
                                                                {{ $barangMasuk->Status == 'Reject' ? 'selected' : '' }}>
                                                                Reject</option>
                                                            <!-- Tambahkan pilihan status lainnya sesuai kebutuhan -->
                                                        </select>
                                                        <button type="submit"
                                                            class="btn btn-primary btn-sm ms-2">Update</button>
                                                    </div>
                                                @else
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <select name="Status" id="status"
                                                            class="form-control form-control-sm w-auto" disabled>
                                                            <option value="Accept"
                                                                {{ $barangMasuk->Status == 'Accept' ? 'selected' : '' }}>
                                                                Accept</option>
                                                            <option value="Pending"
                                                                {{ $barangMasuk->Status == 'Pending' ? 'selected' : '' }}>
                                                                Pending</option>
                                                            <option value="Reject"
                                                                {{ $barangMasuk->Status == 'Reject' ? 'selected' : '' }}>
                                                                Reject</option>
                                                        </select>
                                                    </div>
                                                @endif
                                            </form>
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