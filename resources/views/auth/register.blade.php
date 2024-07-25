@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="Nama" class="col-md-4 col-form-label text-md-end">{{ __('Nama') }}</label>
                                <div class="col-md-6">
                                    <input id="Nama" type="Nama" class="form-control" name="Nama"
                                        value="{{ old('Nama') }}" required autocomplete="Nama">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Jenis_Kelamin"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Jenis_Kelamin') }}</label>
                                <div class="col-md-6">
                                    <input id="Jenis_Kelamin" type="Jenis_Kelamin" class="form-control" name="Jenis_Kelamin"
                                        value="{{ old('Jenis_Kelamin') }}" required autocomplete="Jenis_Kelamin">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="No_Telepon"
                                    class="col-md-4 col-form-label text-md-end">{{ __('No_Telepon') }}</label>
                                <div class="col-md-6">
                                    <input id="No_Telepon" type="No_Telepon" class="form-control" name="No_Telepon"
                                        value="{{ old('No_Telepon') }}" required autocomplete="No_Telepon">
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="Alamat"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Alamat') }}</label>
                                <div class="col-md-6">
                                    <input id="Alamat" type="Alamat" class="form-control" name="Alamat"
                                        value="{{ old('Alamat') }}" required autocomplete="Alamat">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Instansi"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Instansi') }}</label>
                                <div class="col-md-6">
                                    <input id="Instansi" type="Instansi" class="form-control" name="Instansi"
                                        value="{{ old('Instansi') }}" required autocomplete="Instansi">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('email') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required
                                        autocomplete="new-password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>


                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
