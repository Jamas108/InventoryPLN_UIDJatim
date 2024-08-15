@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')

            <div class="container-fluid">
                <div class="d-sm-flex align-items-left justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Tambah Akun Pegawai</h1>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white rounded shadow p-4">
                        <form method="POST" action="{{ route('user.store') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Nama" class="col-form-label text-md-left">{{ __('Nama') }}</label>
                                        <input id="Nama" type="text" class="form-control" name="Nama"
                                            value="{{ old('Nama') }}" required autocomplete="Nama">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Jenis_Kelamin" class="col-form-label text-md-left">{{ __('Jenis Kelamin') }}</label>
                                        <select id="Jenis_Kelamin" class="form-control" name="Jenis_Kelamin" required>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="No_Telepon" class="col-form-label text-md-left">{{ __('No Telepon') }}</label>
                                        <input id="No_Telepon" type="text" class="form-control" name="No_Telepon"
                                            value="{{ old('No_Telepon') }}" required autocomplete="No_Telepon">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Alamat" class="col-form-label text-md-left">{{ __('Alamat') }}</label>
                                        <input id="Alamat" type="text" class="form-control" name="Alamat"
                                            value="{{ old('Alamat') }}" required autocomplete="Alamat">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Instansi" class="col-form-label text-md-left">{{ __('Instansi') }}</label>
                                        <input id="Instansi" type="text" class="form-control" name="Instansi"
                                            value="{{ old('Instansi') }}" required autocomplete="Instansi">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="col-form-label text-md-left">{{ __('Email') }}</label>
                                        <input id="email" type="email" class="form-control" name="email"
                                            value="{{ old('email') }}" required autocomplete="email">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="col-form-label text-md-left">{{ __('Password') }}</label>
                                        <input id="password" type="password" class="form-control" name="password"
                                            required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password-confirm" class="col-form-label text-md-left">{{ __('Confirm Password') }}</label>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 text-lefty">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Tambah Akun') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>y

        </div>
    </div>
@endsection
