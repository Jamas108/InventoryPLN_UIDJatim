@extends('layouts.app')
@section('content')
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: rgb(1, 1, 95)">


        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon" id="logopln">
                <img src="{{ Vite::asset('../resources/assets/logo.png') }}" alt="Autumn Logo" height="50px" width="50px">
            </div>
            <div class="sidebar-brand-text mx-3" style="font-size: 30px; color: #24a8e0">P L N</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" color="white">

        <!-- Heading -->
        <div class="sidebar-heading">
            Barang
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('masterdata') }}">
                <i class="fas fa-database"></i>
                <span>Master Data</span></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('barangmasuk') }}">
                <i class="fas fa-home"></i>
                <span>Barang Masuk</span></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('barangkeluar') }}">
                <i class="fas fa-dolly-flatbed"></i>
                <span>Barang Keluar</span></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('barangrusak') }}">
                <i class="fas fa-house-damage"></i>
                <span>Barang Rusak</span></a>
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('stokbarang') }}">
                <i class="fas fa-box-open"></i>
                <span>Stok Barang</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" color="white">

        <!-- Heading -->
        <div class="sidebar-heading">
            Operasional
        </div>
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('suratjalan') }}">
                <i class="fas fa-envelope-open-text"></i>
                <span>Surat Jalan</span></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('retur') }}">
                <i class="fas fa-shipping-fast"></i>
                <span>Retur</span></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('reports') }}">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" color="white">

        <!-- Heading -->
        <div class="sidebar-heading">
            Lainya
        </div>
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('notifikasi') }}">
                <i class="fas fa-bell"></i>
                <span>Notifikasi</span></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('user') }}">
                <i class="fas fa-user"></i>
                <span>User</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>

    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                            aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small"
                                        placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin PLN</span>

                            <img src="{{ Vite::asset('../resources/assets/logo.png') }}"
                                class="img-profile rounded-circle" alt="Autumn Logo" height="50px" width="50px">
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->

            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Stok Barang</h1>
                    <ul class="list-inline mb-0 float-end">
                        {{-- <li class="list-inline-item">
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download PDF</a>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download Excel</a>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                    class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Product</a>
                        </li> --}}
                    </ul>
                </div>

                <div class="container-fluid pt-2 px-2 vh-50 d-grid" style="grid-template-columns: repeat(2, 1fr); gap: 1rem;">

                    <div class="card p-0" style="background-color: transparent; border: none;">
                        <img src="{{ Vite::asset('../resources/assets/hardware.jpg') }}" class="rounded"
                            alt="Autumn Logo" style="object-fit: cover; width: 100%; height: 50vh;">
                        <div class="card-img-overlay d-flex justify-content-between flex-column">
                            <div style="align-self: flex-start; color:white">
                                <h6 class="card-text">CATALOG</h6>
                                <h3 class="card-title" style="font-weight: 800">Hardware</h3>
                            </div>
                            <a href="#" class="btn btn-primary" style="align-self: flex-end;">See Details</a>
                        </div>
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        @include('layouts.navbar')
            <section id="contact" class="contact">
                <div class="container" data-aos="fade-up">
                    <div class="section-title mt-5">
                        <h1>Stok Barang</h1>
                    </div>
                    <div class="container mt-4">
                        <ul class="list-inline text-center">
                            <li class="list-inline-item mr-5" style="width: 400px;">
                                <div class="card text-bg-dark">
                                    <img src="{{ Vite::asset('../resources/assets/hardware.jpg') }}" class="rounded" alt="Autumn1 Logo" width="400" height="200" style="object-fit: cover;">
                                    <div class="card-img-overlay d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-text">CATALOG</h6>
                                            <h3 class="card-title" style="font-weight: 800">Hardware</h3>
                                        </div>
                                        <a href="#" class="btn btn-primary" style="align-self: flex-end;">See Details</a>
                                    </div>
                                </div>
                            </li>

                            <li class="list-inline-item ml-5" style="width: 400px;">
                                <div class="card text-bg-dark">
                                    <img src="{{ Vite::asset('../resources/assets/network.jpg') }}" class="rounded" alt="Autumn Logo" width="400" height="200" style="object-fit: cover;">
                                    <div class="card-img-overlay d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-text">CATALOG</h6>
                                            <h3 class="card-title" style="font-weight: 800">Networking</h3>
                                        </div>
                                        <a href="#" class="btn btn-primary" style="align-self: flex-end;">See Details</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="card p-0" style="background-color: transparent; border: none;">
                        <img src="{{ Vite::asset('../resources/assets/network.jpg') }}" class="rounded"
                            alt="Autumn Logo" style="object-fit: cover; width: 100%; height: 50vh;">
                        <div class="card-img-overlay d-flex justify-content-between flex-column">
                            <div style="align-self: flex-start; color:white">
                                <h6 class="card-text">CATALOG</h6>
                                <h3 class="card-title" style="font-weight: 800">Networking</h3>
                            </div>
                            <a href="#" class="btn btn-primary" style="align-self: flex-end;">See Details</a>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
@endsection
