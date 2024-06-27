@extends('layouts.app')
@section('content')
@include('layouts.sidebar')
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        @include('layouts.navbar')
            <section id="contact" class="contact">
                <div class="container" data-aos="fade-up">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Reports</h1>
                    </div>
                    <div class="row text-center justify-content-between">
                        <div class="col-md-2 mb-4 " style="background-color: white; padding: 30px; border-radius: 10px;">
                            <i class="fas fa-box-open fa-3x" style="color: blue;"></i>
                            <p class="mt-3">Barang Masuk</p>
                        </div>
                        <div class="col-md-2 mb-3 " style="background-color: white; padding: 30px; border-radius: 10px;">
                            <i class="fas fa-dolly fa-3x " style="color: teal;"></i>
                            <p class="mt-3">Barang Keluar</p>
                        </div>
                        <div class="col-md-2 mb-4 " style="background-color: white; padding: 30px; border-radius: 10px;">
                            <i class="fas fa-exclamation-triangle fa-3x" style="color: red;"></i>
                            <p class="mt-3">Barang Rusak</p>
                        </div>
                        <div class="col-md-2 mb-4 " style="background-color: white; padding: 30px; border-radius: 10px;">
                            <i class="fas fa-clipboard-list fa-3x" style="color: orange;"></i>
                            <p class="mt-3">Requested Item</p>
                        </div>
                    </div>
                </div>

            </section>
            </div>
        </div>
    </div>
@endsection
