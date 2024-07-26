<?php

namespace App\Http\Controllers;

use App\Models\ReturBarang;
use Illuminate\Http\Request;

class BarangRusakController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $barangrusaks = ReturBarang::where('Id_Jenis_Retur', 3)->get();
        return view('barangrusak.index', compact('barangrusaks'));
    }

    public function show($id)
    {
        // Mengambil data barang rusak berdasarkan ID
        $barangrusak = ReturBarang::findOrFail($id);
        return view('barangrusak.show', compact('barangrusak'));
    }
}
