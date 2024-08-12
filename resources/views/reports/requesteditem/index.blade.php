@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Report Requested Item</h1>
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            <a href="{{ route('reports.exportPdfRequestedItem', ['year' => request('year')]) }}"
                                class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                                 <i class="fas fa-download fa-sm text-white-50"></i> Download PDF
                             </a>
                             
                        </li>
                    </ul>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <form method="GET" action="{{ route('reports.requesteditem.index') }}" class="mb-4">
                            <div class="row mb-3">
                                <div class="col-md-11 mb-2">
                                    <label for="year" class="form-label">Filter by Year</label>
                                    <select class="form-select" id="year" name="year">
                                        <option value="" {{ request('year') == '' ? 'selected' : '' }}>All Years</option>
                                        @for ($year = now()->year; $year >= 2000; $year--)
                                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div class="col-md-1 mb-2 d-flex align-items-end">
                                    <button class="btn btn-primary" type="submit">Filter</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-bordered table-hover mb-0 datatable"
                                id="ProductTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 450px; color: white">Nama Barang</th>
                                        <th scope="col" style="width: 450px; color: white">Kode Barang</th>
                                        <th scope="col" style="width: 450px; color: white">Total Request</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requestedItems as $item)
                                        <tr>
                                            <td>{{ $item->barangMasuk->Nama_Barang }}</td>
                                            <td>{{ $item->Kode_Barang }}</td>
                                            <td>{{ $item->total_request }}</td>
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
