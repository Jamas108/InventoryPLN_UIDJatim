@extends('layouts.applogin')
@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 align-item-center"  >
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="{{ Vite::asset('../resources/assets/logo-inventory.png') }}"
                        alt="Autumn Logo"  width="100%">
                </div>

                <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <span class="login100-form-title strong">
                        Login Pegawai
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Valid username is required">
                        <input class="input100" type="text" name="email" placeholder="Username" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="Password" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" type="submit">
                            Login
                        </button>
                    </div>

                    <div class="text-center p-t-136">
                        <a class="txt2" href="#">
                            Create your Account
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
