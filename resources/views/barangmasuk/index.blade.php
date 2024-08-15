@extends('layouts.app')

@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $('#employeeTable').DataTable();
        });

        $(".status-select").on("change", function() {
            var status = $(this).val();
            var id = $(this).data("id");

            $.ajax({
                url: "{{ route('barangmasuk.updateStatusAjax') }}",
                type: 'PUT',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Status berhasil diperbarui',
                            text: response.message
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal memperbarui status',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan',
                        text: 'Status tidak dapat diperbarui'
                    });
                }
            });
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
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                                <i class="fas fa-download fa-sm text-white-50"></i> Download PDF</a>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                                <i class="fas fa-download fa-sm text-white-50"></i> Download Excel</a>
                            <a href="{{ route('barangmasuk.create') }}"
                                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Barang </a>
                        </li>
                    </ul>
                </div>
                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-center align-middle table-hover mb-0 datatable" id="ProductTable"
                                style="width: 100%">
                                <thead>
                                    <tr>
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
                                            <td>{{ $barangMasuks['No_Surat'] }}</td>
                                            <td>{{ $barangMasuks['NamaPerusahaan_Pengirim'] }}</td>
                                            <td>{{ $barangMasuks['Jumlah_BarangMasuk'] }}</td>
                                            <td>Approved</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-{{ $barangMasuks['id'] }}"
                                                    aria-expanded="false"
                                                    aria-controls="collapse-{{ $barangMasuks['id'] }}">
                                                    +
                                                </button>
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

                                        <tr id="collapse-{{ $barangMasuks['id'] }}" class="collapse"
                                            data-bs-parent="#ProductTable">
                                            <td colspan="5">
                                                <div class="accordion-body">
                                                    <table class="table inner-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Kode Barang</th>
                                                                <th>Nama Barang</th>
                                                                <th>Kuantitas</th>
                                                                <th>Kategori Barang</th>
                                                                <th>Garansi Barang</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($barangMasuks['items'] as $barangMasuk)
                                                                <tr>
                                                                    <td>{{ $barangMasuk->kode_barang }}</td>
                                                                    <td>{{ $barangMasuk->nama_barang }}</td>
                                                                    <td>{{ $barangMasuk->jumlah_barang }}</td>
                                                                    <td>{{ $barangMasuk->kategori_barang }}</td>
                                                                    <td>
                                                                        @if ($barangMasuk->sisa_hari_garansi == 'Garansi tidak tersedia')
                                                                            <span
                                                                                class="text-warning">{{ $barangMasuk->sisa_hari_garansi }}</span>
                                                                        @elseif($barangMasuk->sisa_hari_garansi == 'Garansi telah berakhir')
                                                                            <span
                                                                                class="text-danger">{{ $barangMasuk->sisa_hari_garansi }}</span>
                                                                        @else
                                                                            {{ $barangMasuk->sisa_hari_garansi }}
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <form
                                                                            action="{{ route('barangmasuk.updateStatus', $barangMasuk->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @if (Auth::user()->Id_Role == 3)
                                                                                <!-- Cek apakah id role adalah 3 -->
                                                                                <div
                                                                                    class="d-flex justify-content-center align-items-center">
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
                                                                                <div
                                                                                    class="d-flex justify-content-center align-items-center">
                                                                                    <select name="Status" id="status"
                                                                                        class="form-control form-control-sm w-auto"
                                                                                        disabled>
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
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">Tidak ada barang masuk.</td>
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
