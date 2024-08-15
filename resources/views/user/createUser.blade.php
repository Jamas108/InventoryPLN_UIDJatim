@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')

            <div class="container-fluid">
                <div class="d-sm-flex align-items-left justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Tambah Akun Pengguna</h1>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white rounded shadow p-4">
                        <!-- Session Alerts -->
                        <div class="container">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @elseif (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>

                        <!-- Form -->
                        <form action="{{ route('create.user') }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="col-form-label text-md-left">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label text-md-left">Name:</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nomorhp" class="col-form-label text-md-left">Nomor HP:</label>
                                        <input type="text" class="form-control" id="nomorhp" name="nomorhp" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="col-form-label text-md-left">Password:</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status" class="col-form-label text-md-left">Status:</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="user">User</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Create User</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
