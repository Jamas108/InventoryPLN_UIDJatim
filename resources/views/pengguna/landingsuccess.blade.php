@extends('layouts.apppengguna')
@section('content')
        <section id="hero" class="hero section dark-background">
            <div class="container mb-5">
                <div class="hero-img d-flex flex-column align-items-center justify-content-center"
                    data-aos="zoom-out" data-aos-delay="200">
                    <img src={{ Vite::asset('resources/assets/sukses.png') }} width="50%" class="img-fluid animated" alt="">
                    <h1 class="h3 text-center">Pengajuan Peminjaman Berhasil</h1>
                    <p class="text-center">Terima Kasih, Pengajuan Peminjaman Anda Akan Di Cek Oleh Admin</p>
                    <a href="{{route('pengguna.index')}}" class="btn btn-get-started" style="width: 30%">Kembali</a>
                </div>
            </div>
        </section>
@endsection
