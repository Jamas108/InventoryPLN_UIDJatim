<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class StokBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('stokbarang.index');
    }

    public function hardwareIndex(Request $request)
{
    $filter = $request->input('filter');

    $hardwareBarangMasuks = BarangMasuk::with(['kategoriBarang', 'statusBarang', 'barangKeluar'])
        ->whereHas('kategoriBarang', function($query) {
            $query->where('Nama_Kategori_Barang', 'hardware');
        });

    // Hitung stok untuk setiap item
    $hardwareBarangMasuks = $hardwareBarangMasuks->get()->map(function ($barang) {
        $totalBarangKeluar = $barang->barangKeluar->sum('Jumlah_Barang');
        $stokBarang = $barang->JumlahBarang_Masuk - $totalBarangKeluar;

        // Tetapkan atribut dinamis
        $barang->setAttribute('totalBarangKeluar', $totalBarangKeluar);
        $barang->setAttribute('stokBarang', $stokBarang);

        return $barang;
    });

    // Terapkan filter setelah menghitung stok
    if ($filter) {
        if ($filter == 'available') {
            $hardwareBarangMasuks = $hardwareBarangMasuks->where('stokBarang', '>', 50);
        } elseif ($filter == 'low-stock') {
            $hardwareBarangMasuks = $hardwareBarangMasuks->where('stokBarang', '<=', 50)->where('stokBarang', '>', 20);
        } elseif ($filter == 'last-stock') {
            $hardwareBarangMasuks = $hardwareBarangMasuks->where('stokBarang', '<=', 20);
        }
    }

    $hardwareBarangMasuks = $hardwareBarangMasuks->sortByDesc('Tanggal_Masuk');

    return view('stokbarang.hardware.index', compact('hardwareBarangMasuks'));
}


    public function networkingIndex(Request $request)
    {
        $filter = $request->input('filter');
    
        $networkingBarangMasuks = BarangMasuk::with(['kategoriBarang', 'statusBarang', 'barangKeluar'])
            ->whereHas('kategoriBarang', function($query) {
                $query->where('Nama_Kategori_Barang', 'networking');
            });
    
        // Hitung stok untuk setiap item
        $networkingBarangMasuks = $networkingBarangMasuks->get()->map(function ($barang) {
            $totalBarangKeluar = $barang->barangKeluar->sum('Jumlah_Barang');
            $stokBarang = $barang->JumlahBarang_Masuk - $totalBarangKeluar;
    
            // Tetapkan atribut dinamis
            $barang->setAttribute('totalBarangKeluar', $totalBarangKeluar);
            $barang->setAttribute('stokBarang', $stokBarang);
    
            return $barang;
        });
    
        // Terapkan filter setelah menghitung stok
        if ($filter) {
            if ($filter == 'available') {
                $networkingBarangMasuks = $networkingBarangMasuks->where('stokBarang', '>', 50);
            } elseif ($filter == 'low-stock') {
                $networkingBarangMasuks = $networkingBarangMasuks->where('stokBarang', '<=', 50)->where('stokBarang', '>', 20);
            } elseif ($filter == 'last-stock') {
                $networkingBarangMasuks = $networkingBarangMasuks->where('stokBarang', '<=', 20);
            }
        }
    
        $networkingBarangMasuks = $networkingBarangMasuks->sortByDesc('Tanggal_Masuk');
    
        return view('stokbarang.networking.index', compact('networkingBarangMasuks'));
    }
    


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
