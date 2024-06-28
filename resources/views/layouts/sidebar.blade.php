@php
    $currentRouteName = Route::currentRouteName();
@endphp
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
    <li class="nav-item {{ $currentRouteName == 'home' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" color="white">

    <!-- Heading -->
    <div class="sidebar-heading" style="color: white">
        Barang
    </div>

    <!-- Nav Item - Master Data -->
    <li class="nav-item {{ $currentRouteName == 'masterdata' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('masterdata') }}">
            <i class="fas fa-database"></i>
            <span>Master Data</span>
        </a>
    </li>

    <!-- Nav Item - Barang Masuk -->
    <li class="nav-item {{ $currentRouteName == 'barangmasuk' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('barangmasuk.index') }}">
            <i class="fas fa-home"></i>
            <span>Barang Masuk</span>
        </a>
    </li>

    <!-- Nav Item - Barang Keluar -->
    <li class="nav-item {{ $currentRouteName == 'barangkeluar' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('barangkeluar') }}">
            <i class="fas fa-dolly-flatbed"></i>
            <span>Barang Keluar</span>
        </a>
    </li>

    <!-- Nav Item - Barang Rusak -->
    <li class="nav-item {{ $currentRouteName == 'barangrusak' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('barangrusak') }}">
            <i class="fas fa-house-damage"></i>
            <span>Barang Rusak</span>
        </a>
    </li>

    <!-- Nav Item - Stok Barang -->
    <li class="nav-item {{ $currentRouteName == 'stokbarang' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('stokbarang') }}">
            <i class="fas fa-box-open"></i>
            <span>Stok Barang</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" color="white">

    <!-- Heading -->
    <div class="sidebar-heading" style="color: white">
        Operasional
    </div>

    <!-- Nav Item - Surat Jalan -->
    <li class="nav-item {{ $currentRouteName == 'suratjalan' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('suratjalan') }}">
            <i class="fas fa-envelope-open-text"></i>
            <span>Surat Jalan</span>
        </a>
    </li>

    <!-- Nav Item - Retur -->
    <li class="nav-item {{ $currentRouteName == 'retur' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('retur') }}">
            <i class="fas fa-shipping-fast"></i>
            <span>Retur</span>
        </a>
    </li>

    <!-- Nav Item - Reports -->
    <li class="nav-item {{ $currentRouteName == 'reports' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('reports') }}">
            <i class="fas fa-chart-bar"></i>
            <span>Reports</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" color="white">

    <!-- Heading -->
    <div class="sidebar-heading" style="color: white">
        Lainya
    </div>

    <!-- Nav Item - Notifikasi -->
    <li class="nav-item {{ $currentRouteName == 'notifikasi' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('notifikasi') }}">
            <i class="fas fa-bell"></i>
            <span>Notifikasi</span>
        </a>
    </li>

    <!-- Nav Item - User -->
    <li class="nav-item {{ $currentRouteName == 'user' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('user') }}">
            <i class="fas fa-user"></i>
            <span>User</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
