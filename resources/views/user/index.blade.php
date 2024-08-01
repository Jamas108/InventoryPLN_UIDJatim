@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')

            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">User</h1>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-bordered table-hover mb-0 datatable"
                                id="UserTable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Role User</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">No. Telepon</th>
                                        <th scope="col">Instansi</th>
                                        <th scope="col">Log Activity</th>
                                        <th scope="col">Action</th>
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
                                            <td>
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
