@extends('layouts.apppengguna')


@section('content')
    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="index.html" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 class="sitename">Inventory PLN</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero">Katalog</a></li>
                    <li><a href="#about">Tentang</a></li>
                    <li><a href="#services">Profil</a></li>
                    <li><a href="{{route('userinventory.index')}}">Peminjaman Anda</a></li>
                </ul>
            </nav>

            <a class="btn-getstarted" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>

        </div>
    </header>

    <main class="main" >

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background" style="align-items: center">

            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="fade-up">
                        <h1>Ajukan Peminjaman Anda Sekarang</h1>
                        <p>Peminjaman Aset PLN UID Jawa Timur Terbagi Menjadi Dua Kategori Yaitu Peminjaman Reguler dan Insidentil.</p>
                        <div class="d-flex">
                            <a href="{{ route('userinventory.create') }}" class="btn-get-started">Peminjaman Insidentil</a>
                            <a href="{{ route('createreguler.index') }}" class="btn-get-started ml-2" style="background-color: rgb(255, 208, 0)">Peminjaman Reguler</a>
                        </div>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="100">
                        <img src={{ Vite::asset('resources/assets/inventoryuser.png') }} class="img-fluid animated" alt="">
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->
    </main>
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
