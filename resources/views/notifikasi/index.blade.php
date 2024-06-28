@extends('layouts.app')
@section('content')
@include('layouts.sidebar')
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        @include('layouts.navbar')


        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-1">
                <h1 class="h3 mb-0 text-gray-800">Notifikasi</h1>
                <ul class="list-inline mb-0 mr-5 float-end">
                    <li class="list-inline-item">
                        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Download PDF</a>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Download Excel</a>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Product</a> --}}
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-bell"></i> </a>
                    </li>
                </ul>
            </div>

            <div class="container-fluid pt-2 px-2">


                <div class="card-body">

                    <div class="notification-item" style="background: #fff; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px; padding: 15px;">
                        <div class="notification-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center;">
                                <i class="fas fa-check-circle" style="font-size: 1.5rem; margin-right: 10px; color: #007bff;"></i>
                                <h5 style="margin: 0; font-size: 1.25rem;">Approval Barang Masuk</h5>
                            </div>
                            <span class="date" style="font-size: 0.875rem; color: #007bff;">Juni 26, 2024</span>
                        </div>
                        <div class="notification-body" style="margin-top: 10px;">
                            <p>Surat jalan butuh persetujuan dengan No. Surat: 217/000/IX/2024</p>
                        </div>
                        <div class="notification-footer" style="display: flex; justify-content: flex-end; margin-top: 15px;">
                            <button class="btn btn-primary">View Details</button>
                        </div>
                    </div>

                    <div class="notification-item" style="background: #c3c3c3; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px; padding: 15px;">
                        <div class="notification-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center;">
                                <i class="fas fa-check-circle" style="font-size: 1.5rem; margin-right: 10px; color: #5f5f5f;"></i>
                                <h5 style="margin: 0; font-size: 1.25rem;">Approval Barang Masuk</h5>
                            </div>
                            <span class="date" style="font-size: 0.875rem; color: #6c757d;">Mei 25, 2024</span>
                        </div>
                        <div class="notification-body" style="margin-top: 10px;">
                            <p>Surat jalan butuh persetujuan dengan No. Surat: 099/510/XVIX/2024</p>
                        </div>
                        <div class="notification-footer" style="display: flex; justify-content: flex-end; margin-top: 15px;">
                            <button class="btn btn-dark">View Details</button>
                        </div>
                    </div>

                    <div class="notification-item" style="background: #c3c3c3; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px; padding: 15px;">
                        <div class="notification-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center;">
                                <i class="fas fa-check-circle" style="font-size: 1.5rem; margin-right: 10px; color: #5f5f5f;"></i>
                                <h5 style="margin: 0; font-size: 1.25rem;">Approval Barang Masuk</h5>
                            </div>
                            <span class="date" style="font-size: 0.875rem; color: #6c757d;">Maret 24, 2024</span>
                        </div>
                        <div class="notification-body" style="margin-top: 10px;">
                            <p>Surat jalan butuh persetujuan dengan No. Surat: 099/510/XVIX/2024</p>
                        </div>
                        <div class="notification-footer" style="display: flex; justify-content: flex-end; margin-top: 15px;">
                            <button class="btn btn-dark">View Details</button>
                        </div>
                    </div>

                    <div class="notification-item" style="background: #c3c3c3; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px; padding: 15px;">
                        <div class="notification-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center;">
                                <i class="fas fa-check-circle" style="font-size: 1.5rem; margin-right: 10px; color: #5f5f5f;"></i>
                                <h5 style="margin: 0; font-size: 1.25rem;">Approval Barang Masuk</h5>
                            </div>
                            <span class="date" style="font-size: 0.875rem; color: #6c757d;">Maret 23, 2024</span>
                        </div>
                        <div class="notification-body" style="margin-top: 10px;">
                            <p>Surat jalan butuh persetujuan dengan No. Surat: 099/510/XVIX/2024</p>
                        </div>
                        <div class="notification-footer" style="display: flex; justify-content: flex-end; margin-top: 15px;">
                            <button class="btn btn-dark">View Details</button>
                        </div>
                    </div>

                    <div class="notification-item" style="background: #c3c3c3; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px; padding: 15px;">
                        <div class="notification-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center;">
                                <i class="fas fa-check-circle" style="font-size: 1.5rem; margin-right: 10px; color: #5f5f5f;"></i>
                                <h5 style="margin: 0; font-size: 1.25rem;">Approval Barang Masuk</h5>
                            </div>
                            <span class="date" style="font-size: 0.875rem; color: #6c757d;">Maret 23, 2024</span>
                        </div>
                        <div class="notification-body" style="margin-top: 10px;">
                            <p>Surat jalan butuh persetujuan dengan No. Surat: 099/510/XVIX/2024</p>
                        </div>
                        <div class="notification-footer" style="display: flex; justify-content: flex-end; margin-top: 15px;">
                            <button class="btn btn-dark">View Details</button>
                        </div>
                    </div>

                    <!-- Tambahkan notifikasi lainnya di sini -->
                </div>

            </div>
        </div>

    </div>
</div>



@endsection
