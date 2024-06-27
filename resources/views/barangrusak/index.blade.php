@extends('layouts.app')
@section('content')
@include('layouts.sidebar')
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        @include('layouts.navbar')
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
