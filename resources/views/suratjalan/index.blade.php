@extends('layouts.app')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        @include('layouts.navbar')
            <section id="contact" class="contact">
                <div class="container" data-aos="fade-up">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Surat Jalan</h1>
                        {{-- <ul class="list-inline mb-0 float-end">
                            <li class="list-inline-item">
                                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
                                        class="fas fa-download fa-sm text-white-50"></i> Download PDF</a>
                                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                        class="fas fa-download fa-sm text-white-50"></i> Download Excel</a>
                                <a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                        class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Barang</a>
                            </li>
                        </ul> --}}

                    </div>

                    <div class="col-lg-12 mt-lg-0 d-flex align-items-stretch mx-auto" data-aos="fade-up"
                        data-aos-delay="200">
                        <table id="BarangmasukTable" class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 450px;">SURAT JALAN</th>
                                    <th scope="col" style="width: 450px;">NO SURAT JALAN</th>
                                    <th scope="col" style="width: 300px;"></th>

                                </tr>
                            </thead>
                            {{-- <tbody>
                                    @foreach ($barangmasuk as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>Rp{{ number_format($item->harga_awal, 0, ',', '.') }}</td>
                                            <td>{{ $item->jumlah}}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <form action="{{ route('barangmasuk.destroy', ['id' => $item->id]) }}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn-delete btn-sm" data-name="{{ $item->nama_barang }}">
                                                            <i class="bi-trash"></i></button>
                                                        <a href="{{ route('show', ['id' => $item->id]) }}" class="btn btn-warning ">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                    </form>
                                                    {{-- <a href="{{ route('delete', ['id' => $item->id]) }}"
                                                        class="btn-delete">Delete</a> --}}
                            {{-- <button class="btn btn-danger btn-sm hapus" data-toggle="modal"
                                                        data-target="#ModalDelete" data-id='#'><i
                                                            class="fas fa-trash"></i></button> --}}
                    </div>
                    </td>
                    </tr>
                    {{-- <!-- Modal -->
                                            <div class="modal fade" id="ModalDelete" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Hapus</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form
                                                            action="{{ route('delete-inventory', ['id' => $item->id]) }}"
                                                            method="post" id="konfirmasiHapus">
                                                            @method('delete')
                                                            @csrf
                                                            <div class="modal-body">
                                                                Apakah Anda yakin akan menghapus data ini?
                                                            </div>
                                                            <input type="text" name="id_hapus"
                                                                class="form-control d-none" id="hapus">
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Tidak</button>
                                                                <button type="submit" class="btn btn-primary">Ya</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div> --}}
                    {{-- </tr>
                                    @endforeach
                                </tbody> --}}
                    </table>
                </div>
        </div>
    </div>
    </div>
    </div>
    </section>
@endsection
