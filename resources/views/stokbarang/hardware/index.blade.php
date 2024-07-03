@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            <a href="{{ route('stokbarang.index') }}" class="btn-lg">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <h1 class="h3 mb-0 text-gray-800 mr-5" style="font-weight: bold">Hardware</h1>
                </div>
                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <!-- Filter form -->
                        <form method="GET" action="{{ route('stokbarang.hardware.index') }}" class="mb-4">
                            <div class="input-group">
                                <select name="filter" class="form-select" aria-label="Filter">
                                    <option value="">All</option>
                                    <option value="available">Available</option>
                                    <option value="low-stock">Low Stock</option>
                                    <option value="last-stock">Last Stock</option>
                                </select>
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table text-start align-middle table-bordered table-hover mb-0 datatable" id="ProductTable" style="90%">
                                <thead style="background-color: rgb(1, 1, 95);">
                                    <tr style="color: white">
                                        <th scope="col">ITEM NAME</th>
                                        <th scope="col"></th>
                                        <th scope="col">QUANTITY</th>
                                        <th scope="col">DATE ADDED</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td class="d-flex justify-content-center align-items-center">
                                                <img src="{{ Vite::asset('resources/assets/' . $item->image) }}" alt="{{ $item->name }}" style="width: 100px;">
                                            </td>
                                            <td>
                                                <strong>{{ $item->name }}</strong><br>
                                                Category: {{ $item->category }}<br>
                                                Location: {{ $item->location }}<br>
                                                Style: {{ $item->style }}<br>
                                                Color: {{ $item->color }}
                                            </td>
                                            <td class="text-center align-middle">
                                                @if($item->quantity > 5)
                                                    <span class="badge bg-success">{{ $item->quantity }} Available</span>
                                                @elseif($item->quantity > 2)
                                                    <span class="badge bg-warning">{{ $item->quantity }} Low Stock</span>
                                                @else
                                                    <span class="badge bg-danger">{{ $item->quantity }} Last Stock</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">{{ $item->date_added->format('M d, Y') }}</td>
                                            <td class="text-center align-middle">
                                                <a href="" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
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
