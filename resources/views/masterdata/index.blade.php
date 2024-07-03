@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-3">
                    <h1 class="h3 mb-0 text-gray-800 mr-5">Master Data</h1>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-bordered table-hover mb-0 datatable"
                                id="ProductTable" style="width: 100%;">
                                <thead style="background-color: rgb(1, 1, 95);">
                                    <tr style="color: white">
                                        <th scope="col" style="width: 200px;">ITEM NAME</th>
                                        <th scope="col" style="width: 500px;"></th>
                                        <th scope="col" style="width: 150px;">DATE ADDED</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td class="d-flex justify-content-center align-items-center">
                                                <img src="{{ Vite::asset('resources/assets/' . $item->image) }}"
                                                    alt="{{ $item->name }}" style="width: 100px;">
                                            </td>
                                            <td>
                                                <strong>{{ $item->name }}</strong><br>
                                                Category: {{ $item->category }}<br>
                                                Location: {{ $item->location }}<br>
                                                Kode: {{ $item->kode }}<br>
                                                {{-- Merk: {{ $item->merk }}<br>
                                                Jenis Barang: {{ $item->jenis_barang }} --}}
                                            </td>
                                            <td class="text-center align-middle">{{ $item->date_added->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
