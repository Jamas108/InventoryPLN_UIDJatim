<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function index()
    {
        // Mengambil semua data barang masuk, termasuk relasi dengan kategori barang
        $barangMasuks = BarangMasuk::with('kategoriBarang')->get();

        // Mengirim data ke view
        return view('masterdata.index', compact('barangMasuks'));
    }
}
