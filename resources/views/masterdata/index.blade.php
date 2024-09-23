@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Master Data</h1>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="bg-white justify-content-between rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="table text-center align-middle mb-0 datatable" id="ProductTable" style="width: 100%;">
                                <thead style="background-color: #01015F;">
                                    <tr style="color: white;">
                                        <th scope="col" style="width: 15%; color: white">Nama Barang</th>
                                        <th scope="col" style="width: 25%; color: white">Foto Barang</th>
                                        <th scope="col" style="width: 20%; color: white">Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dummy data -->
                                    <tr>
                                        <td class="text-center align-middle"><h6 class="card-title">Router TP-Link MR100</h6></td>
                                        <td class="text-center align-middle">
                                           <img src="https://doran.id/wp-content/uploads/2023/03/Router-TP-LINK-MR100-1.jpg"
                                                class="img-fluid rounded" alt="Barang 1"
                                                style="max-width: 300px; max-height: 250px; object-fit: cover;">
                                        </td>
                                        <td class="text-start align-middle">
                                            <div class="card-body p-0">
                                                <p class="mb-1"><strong>Kategori Barang:</strong> Hardware </p>
                                                <p class="mb-1"><strong>Perusahaan Pengirim:</strong>PT. NUSANTARA POWER</p>
                                                <p class="mb-0"><strong>Jumlah:</strong>500</p>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center align-middle"><h6 class="card-title">UBIQUITI 4-Port Gigabit Router with 1 SFP Port EdgeRouter 4 ER-4</h6></td>
                                        <td class="text-center align-middle">
                                            <img src=" https://www.bhinneka.com/web/image/product.template/37002/image_1024?unique=b248a62"
                                                class="img-fluid rounded" alt="Barang 2"
                                                style="max-width: 300px; max-height: 250px; object-fit: cover;">
                                        </td>
                                        <td class="text-start align-middle">
                                            <div class="card-body p-0">
                                                <p class="mb-1"><strong>Kategori Barang:</strong> Hardaware</p>
                                                <p class="mb-1"><strong>Perusahaan Pengirim:</strong> PT ICONNET</p>
                                                <p class="mb-0"><strong>Jumlah:</strong> 950 </p>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center align-middle"><h6 class="card-title">MikroTik RB1100AHx4</h6></td>
                                        <td class="text-center align-middle">
                                            <img src=" https://i.ytimg.com/vi/-KDNh4eWNsI/maxresdefault.jpg"
                                                class="img-fluid rounded" alt="Barang 2"
                                                style="max-width: 300px; max-height: 250px; object-fit: cover;">
                                        </td>
                                        <td class="text-start align-middle">
                                            <div class="card-body p-0">
                                                <p class="mb-1"><strong>Kategori Barang:</strong> Hardaware</p>
                                                <p class="mb-1"><strong>Perusahaan Pengirim:</strong> PT ICONNET</p>
                                                <p class="mb-0"><strong>Jumlah:</strong> 950 </p>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center align-middle"><h6 class="card-title">Kabel Utp Cat5e Amp Commscope Original - Cat5 - Cat 5</h6></td>
                                        <td class="text-center align-middle">
                                            <img src=" https://images.tokopedia.net/img/cache/700/product-1/2020/4/15/238399/238399_fb7da611-7fe1-4161-ba99-3b1b5d06067f_720_720.jpg"
                                                class="img-fluid rounded" alt="Barang 2"
                                                style="max-width: 300px; max-height: 250px; object-fit: cover;">
                                        </td>
                                        <td class="text-start align-middle">
                                            <div class="card-body p-0">
                                                <p class="mb-1"><strong>Kategori Barang:</strong> Networking</p>
                                                <p class="mb-1"><strong>Perusahaan Pengirim:</strong> PT ICONNET</p>
                                                <p class="mb-0"><strong>Jumlah:</strong> 5000 </p>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center align-middle"><h6 class="card-title">Cable Commscope UTP CAT 6 305m Blue</h6></td>
                                        <td class="text-center align-middle">
                                            <img src=" https://plazait.co.id/wp-content/uploads/2024/04/Cable-Commscope-UTP-CAT-6E-305m-Blue-1.jpg "
                                                class="img-fluid rounded" alt="Barang 2"
                                                style="max-width: 300px; max-height: 250px; object-fit: cover;">
                                        </td>
                                        <td class="text-start align-middle">
                                            <div class="card-body p-0">
                                                <p class="mb-1"><strong>Kategori Barang:</strong> Networking</p>
                                                <p class="mb-1"><strong>Perusahaan Pengirim:</strong> PT ICONNET</p>
                                                <p class="mb-0"><strong>Jumlah:</strong> 90 </p>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center align-middle"><h6 class="card-title">Konektor RJ45 Cat6 Belden</h6></td>
                                        <td class="text-center align-middle">
                                            <img src=" https://down-id.img.susercontent.com/file/04560ad39fcdc73fcd27b95785a72999"
                                                class="img-fluid rounded" alt="Barang 2"
                                                style="max-width: 300px; max-height: 250px; object-fit: cover;">
                                        </td>
                                        <td class="text-start align-middle">
                                            <div class="card-body p-0">
                                                <p class="mb-1"><strong>Kategori Barang:</strong> Networking</p>
                                                <p class="mb-1"><strong>Perusahaan Pengirim:</strong> CV LENTERA MADURA </p>
                                                <p class="mb-0"><strong>Jumlah:</strong> 950 </p>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center align-middle"><h6 class="card-title">TL-SG1024 | 24-Port Gigabit Rackmount Switch</h6></td>
                                        <td class="text-center align-middle">
                                            <img src=" https://rxtx.com.au/wp-content/uploads/2023/08/Tp-Link-TL-SG1024-Left-Side-View.jpg"
                                                class="img-fluid rounded" alt="Barang 2"
                                                style="max-width: 300px; max-height: 250px; object-fit: cover;">
                                        </td>
                                        <td class="text-start align-middle">
                                            <div class="card-body p-0">
                                                <p class="mb-1"><strong>Kategori Barang:</strong> Networking</p>
                                                <p class="mb-1"><strong>Perusahaan Pengirim:</strong>PT STARK INDUSTRI </p>
                                                <p class="mb-0"><strong>Jumlah:</strong> 999 </p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
