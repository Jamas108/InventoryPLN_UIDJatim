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

        $hardwareBarangMasuks = BarangMasuk::with('kategoriBarang', 'statusBarang')
            ->whereHas('kategoriBarang', function($query) {
                $query->where('Nama_Kategori_Barang', 'hardware');
            });

        if ($filter) {
            if ($filter == 'available') {
                $hardwareBarangMasuks = $hardwareBarangMasuks->where('JumlahBarang_Masuk', '>', 50);
            } elseif ($filter == 'low-stock') {
                $hardwareBarangMasuks = $hardwareBarangMasuks->where('JumlahBarang_Masuk', '<=', 50)->where('JumlahBarang_Masuk', '>', 20);
            } elseif ($filter == 'last-stock') {
                $hardwareBarangMasuks = $hardwareBarangMasuks->where('JumlahBarang_Masuk', '<=', 20);
            }
        }

        $hardwareBarangMasuks = $hardwareBarangMasuks->orderBy('Tanggal_Masuk', 'desc')->get();

        return view('stokbarang.hardware.index', compact('hardwareBarangMasuks'));
    }

    public function networkingIndex(Request $request)
    {
        $filter = $request->input('filter');

        $networkingBarangMasuks = BarangMasuk::with('kategoriBarang', 'statusBarang')
            ->whereHas('kategoriBarang', function($query) {
                $query->where('Nama_Kategori_Barang', 'networking');
            });

        if ($filter) {
            if ($filter == 'available') {
                $networkingBarangMasuks = $networkingBarangMasuks->where('JumlahBarang_Masuk', '>', 50);
            } elseif ($filter == 'low-stock') {
                $networkingBarangMasuks = $networkingBarangMasuks->where('JumlahBarang_Masuk', '<=', 50)->where('JumlahBarang_Masuk', '>', 20);
            } elseif ($filter == 'last-stock') {
                $networkingBarangMasuks = $networkingBarangMasuks->where('JumlahBarang_Masuk', '<=', 20);
            }
        }

        $networkingBarangMasuks = $networkingBarangMasuks->orderBy('Tanggal_Masuk', 'desc')->get();

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
