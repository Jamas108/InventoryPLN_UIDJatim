@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')

        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">User</h1>
                {{-- <ul class="list-inline mb-0 float-end">
                    <li class="list-inline-item">
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Download PDF</a>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Download Excel</a>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-plus fa-sm text-white-50"></i> Tambahkan Product</a>
                    </li>
                </ul> --}}
            </div>

            <div class="container-fluid pt-2 px-2">
                <div class="bg-white justify-content-between rounded shadow p-4">
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0 datatable"
                            id="ProductTable" style="100%">
                            <thead >
                                <tr>
                                    <th scope="col" style="width: 300px; color:white">Username</th>
                                    <th scope="col" style="width: 200px; color:white">Name</th>
                                    <th scope="col" style="width: 250px; color:white">Email</th>
                                    <th scope="col" style="width: 250px; color:white">Role</th>
                                    <th scope="col" style="width: 250px; color:white">Log Activity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td>aa</td>
                                <td>aa</td>
                                <td>aa</td>
                                <td>aa</td>
                                <td>aa</td>
                            </tbody>
                            <tbody>
                                <td>aa</td>
                                <td>aa</td>
                                <td>aa</td>
                                <td>aa</td>
                                <td>aa</td>
                            </tbody>
                            <tbody>
                                <td>aa</td>
                                <td>aa</td>
                                <td>aa</td>
                                <td>aa</td>
                                <td>aa</td>
                            </tbody>
                            <tbody>
                                <td>aa</td>
                                <td>aa</td>
                                <td>aa</td>
                                <td>aa</td>
                                <td>aa</td>
                            </tbody>
                            <tbody>
                                <td>aa</td>
                                <td>aa</td>
                                <td>aa</td>
                                <td>aa</td>
                                <td>aa</td>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

@endsection
