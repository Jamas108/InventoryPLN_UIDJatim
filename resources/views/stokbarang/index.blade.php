@extends('layouts.app')
@section('content')
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


                </div>
        </div>
        </section>
    @endsection
