@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

                </div>

                <!-- Content Row -->
                <div class="row">

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Barang Masuk</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBarangMasuk }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-boxes fa-2x" style="color:rgb(0, 38, 255)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Barang Masuk Pending</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPending }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-ban fa-2x " style="color:rgb(255, 153, 0)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Barang Masuk Accept </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAccepted }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-check fa-2x" style="color:rgb(30, 219, 30)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Requests Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Total Jenis Barang </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalJenisBarang }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-box fa-2x" style="color:rgb(0, 225, 255)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Barang Keluar </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBarangKeluar }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dolly fa-2x" style="color:rgb(0, 38, 255)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Barang Keluar Pending </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPendingKeluar }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-ban fa-2x" style="color:rgb(255, 153, 0)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Peminjaman Insidentil </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalInsidentil }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-hourglass-half fa-2x" style="color:rgb(30, 219, 30)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Peminjaman Reguler </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalReguler }}

                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-box-open fa-2x" style="color:rgb(0, 225, 255)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Barang Retur </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalReturBarang }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-shipping-fast fa-2x" style="color:rgb(0, 38, 255)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Retur Pending </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $totalReturBarangPending }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-ban fa-2x" style="color:rgb(255, 153, 0)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Bekas Handal </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBekasHandal }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-recycle fa-2x" style="color:rgb(30, 219, 30)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Bekas Bergaransi </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBekasBergaransi }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-people-carry fa-2x" style="color:rgb(0, 225, 255)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Barang Rusak </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBarangRusak }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-house-damage fa-2x" style="color:rgb(0, 38, 255)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Total Pengguna </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalUsers}}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user fa-2x" style="color:rgb(255, 153, 0)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <!-- Chart -->
                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Barang Masuk, Barang Keluar dan Retur Barang Per Bulan</h6>
                            </div>
                            <div class="card-body">
                                <div id="chart"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var options = {
                        chart: {
                            type: 'line',
                        },
                        series: [{
                                name: 'Barang Masuk',
                                data: @json($masukData),
                            },
                            {
                                name: 'Barang Keluar',
                                data: @json($keluarData),
                            },
                            {
                                name: 'Barang Retur',
                                data: @json($returData),
                            }
                        ],
                        xaxis: {
                            categories: @json($months),
                            title: {
                                text: 'Bulan'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Jumlah Barang'
                            }
                        },
                        title: {
                            text: 'Grafik Barang Masuk, Barang Keluar dan Retur Barang per Bulan'
                        }
                    }

                    var chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();
                });
            </script>
        @endpush
    @endsection
