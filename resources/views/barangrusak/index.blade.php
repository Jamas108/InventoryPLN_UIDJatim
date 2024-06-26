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
            <a class="nav-link"  href="{{ route('barangmasuk') }}">
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
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin PLN</span>
                            <img src="{{ Vite::asset('../resources/assets/logo.png') }}" class="img-profile rounded-circle" alt="Autumn Logo" height="50px" width="50px">
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- End of Topbar -->

            <section id="contact" class="contact">
                <div class="container" data-aos="fade-up">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Barang Rusak</h1>
                        {{-- <ul class="list-inline mb-0 float-end">
                            <li class="list-inline-item">
                                <a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                        class="fas fa-plus fa-sm text-white-50"></i> Add List</a>
                            </li>
                        </ul> --}}
                    </div>
                    <div class="row">
                        <div class="d-flex justify-content-center">
                                <div class="col-lg-12 mt-lg-0 d-flex align-items-stretch mx-auto" data-aos="fade-up"
                                    data-aos-delay="200" style=" background-color: rgb(1, 1, 95)" >
                                    <table id="BarangmasukTable"  class="table table-striped datatable" >
                                        <thead>
                                            <tr style="color: rgb(255, 255, 255)">
                                                <th scope="col" style="width: 150px;">Nama</th>
                                                <th scope="col" style="width: 200px;">No. Seri</th>
                                                <th scope="col" style="width: 150px;">Tipe</th>
                                                <th scope="col" style="width: 150px;">Merk</th>
                                                <th scope="col" style="width: 250px;">Keterangan</th>
                                                <th scope="col" style="width: 150px;">Detail</th>
                                            </tr>
                                        </thead>
                                </table>
                            </div>


                    </div>
                </div>
        </div>
        </section>
    @endsection
