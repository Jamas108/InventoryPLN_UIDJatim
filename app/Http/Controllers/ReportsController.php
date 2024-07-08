<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\StatusBarang;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('reports.index');
    }

    public function indexBarangMasuk(Request $request)
    {
        // $groupedBarangMasuks = BarangMasuk::all()->groupBy('No_Surat_Jalan');
        // $statusBarangs = StatusBarang::all();
        $barangMasuks = BarangMasuk::with('kategoriBarang', 'statusBarang')
            ->orderBy('Tanggal_Masuk', 'desc'); // Tambahkan orderBy disini

        // Ambil filter dari request
        $filterYear = $request->input('year');
        $filterCondition = $request->input('condition');

        // Terapkan filter jika ada
        if ($filterYear) {
            $barangMasuks->whereYear('Tanggal_Masuk', $filterYear);
        }

        if ($filterCondition) {
            $barangMasuks->where('Kondisi_Barang', $filterCondition);
        }

        // Kelompokkan barang masuk berdasarkan nomor surat
        $groupedBarangMasuks = $barangMasuks->get()->groupBy('No_Surat');

        $statusBarangs = StatusBarang::all();

        // Kirim filter ke view untuk ditampilkan di form filter
        return view('reports.barangmasuk.index', compact('groupedBarangMasuks', 'statusBarangs', 'filterYear', 'filterCondition'));
    }

    public function indexBarangKeluar()
    {
        return view('reports.barangkeluar.index');
    }
    public function indexBarangRusak()
    {
        return view('reports.barangrusak.index');
    }
    public function indexRequestedItem()
    {
        return view('reports.requesteditem.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
