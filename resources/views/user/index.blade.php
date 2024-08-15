@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')

            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">User</h1>
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                                data-toggle="modal" data-target="#addAccountModal">
                                <i class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Akun
                            </a>

                            {{-- <a href="{{ route('viewcreate.user') }}"
                                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Akun Pengguna</a>
                                <a href="{{ route('user.create') }}"
                                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Akun Pegawai</a> --}}
                        </li>
                    </ul>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addAccountModalLabel">Pilih Jenis Akun yang Ingin Ditambahkan
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <ul class="list-inline mb-0 float-end">
                                    <li class="list-inline-item">
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('user.create') }}" class="btn btn-primary w-45 mr-2">
                                                <i class="fas fa-user-tie"></i> Tambahkan Akun Pegawai
                                            </a>
                                            <a href="{{ route('viewcreate.user') }}" class="btn btn-secondary w-45 ml-2">
                                                <i class="fas fa-user"></i> Tambahkan Akun Pengguna
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-center align-middle table-hover mb-0 datatable" id="UserTable"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 200px; color:white; ">Role User</th>
                                        <th scope="col" style="width: 200px; color:white; ">Nama</th>
                                        <th scope="col" style="width: 200px; color:white; ">Email</th>
                                        <th scope="col" style="width: 200px; color:white; ">No. Telepon</th>
                                        <th scope="col" style="width: 200px; color:white; ">Instansi</th>
                                        <th scope="col" style="width: 200px; color:white; ">Log Activity</th>
                                        <th scope="col" style="width: 200px; color:white; ">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->userRole->Nama_Role_Users }}</td>
                                            <td>{{ $user->Nama }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->No_Telepon }}</td>
                                            <td>{{ $user->Instansi }}</td>
                                            <td>activity</td>
                                            <td class="text-center">
                                                <a href="{{ route('user.edit', $user->id) }}"
                                                    class="btn btn-warning btn-sm">Edit Role</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
