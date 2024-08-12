<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\ReturBarang;
use App\Models\StatusBarang;
use App\Models\StatusReturBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

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
        $barangMasuks = BarangMasuk::with('kategoriBarang', 'statusBarang')
            ->orderBy('Tanggal_Masuk', 'desc');

        $filterYear = $request->input('year');
        $filterCondition = $request->input('condition');

        if ($filterYear) {
            $barangMasuks->whereYear('Tanggal_Masuk', $filterYear);
        }

        if ($filterCondition) {
            $barangMasuks->where('Kondisi_Barang', $filterCondition);
        }

        $groupedBarangMasuks = $barangMasuks->get()->groupBy('No_Surat');
        $statusBarangs = StatusBarang::all();

        return view('reports.barangmasuk.index', compact('groupedBarangMasuks', 'statusBarangs', 'filterYear', 'filterCondition'));
    }

    public function exportPdfBarangMasuk(Request $request)
    {
        $barangMasuks = BarangMasuk::with('kategoriBarang', 'statusBarang')
            ->orderBy('Tanggal_Masuk', 'desc');

        $filterYear = $request->input('year');
        $filterCondition = $request->input('condition');

        if ($filterYear) {
            $barangMasuks->whereYear('Tanggal_Masuk', $filterYear);
        }

        if ($filterCondition) {
            $barangMasuks->where('Kondisi_Barang', $filterCondition);
        }

        $groupedBarangMasuks = $barangMasuks->get()->groupBy('No_Surat');
        $pdf = PDF::loadView('reports.barangmasuk.pdf', compact('groupedBarangMasuks', 'filterYear', 'filterCondition'));

        return $pdf->download('reports_barangmasuk.pdf');
    }

    public function indexBarangKeluar(Request $request)
    {
        $barangKeluars = BarangKeluar::with('kategoriBarang', 'barangMasuk', 'statusBarang')
            ->orderBy('Tanggal_BarangKeluar', 'desc');

        $filterYear = $request->input('year');
        $filterCondition = $request->input('condition');

        if ($filterYear) {
            $barangKeluars->whereYear('Tanggal_BarangKeluar', $filterYear);
        }

        if ($filterCondition) {
            $barangKeluars->where('Kondisi_Barang', $filterCondition);
        }

        $groupedBarangKeluars = $barangKeluars->get()->groupBy('Kode_BarangKeluar');
        $statusBarangs = StatusBarang::all();

        return view('reports.barangkeluar.index', compact('groupedBarangKeluars', 'statusBarangs', 'filterYear', 'filterCondition'));
    }

    public function exportPdfBarangKeluar(Request $request)
    {
        $barangKeluars = BarangKeluar::with('kategoriBarang', 'barangMasuk', 'statusBarang')
            ->orderBy('Tanggal_BarangKeluar', 'desc');

        $filterYear = $request->input('year');
        $filterCondition = $request->input('condition');

        if ($filterYear) {
            $barangKeluars->whereYear('Tanggal_BarangKeluar', $filterYear);
        }

        if ($filterCondition) {
            $barangKeluars->where('Kondisi_Barang', $filterCondition);
        }

        $groupedBarangKeluars = $barangKeluars->get()->groupBy('Kode_BarangKeluar');
        $pdf = PDF::loadView('reports.barangkeluar.pdf', compact('groupedBarangKeluars', 'filterYear', 'filterCondition'));

        return $pdf->download('reports_barangkeluar.pdf');
    }

    public function indexBarangRusak(Request $request)
    {
        $barangRusaks = ReturBarang::with('statusRetur')
        ->where('Id_Jenis_Retur', 3)    
        ->orderBy('Tanggal_Retur', 'desc');

        $filterYear = $request->input('year');
        $filterCondition = $request->input('condition');

        if ($filterYear) {
            $barangRusaks->whereYear('Tanggal_Retur', $filterYear);
        }

        if ($filterCondition) {
            $barangRusaks->where('Id_Status_Retur', $filterCondition);
        }

        $groupedBarangRusaks = $barangRusaks->get()->groupBy('Kode_Barang');
        $statusReturs = StatusReturBarang::all();

        return view('reports.barangrusak.index', compact('groupedBarangRusaks', 'statusReturs', 'filterYear', 'filterCondition'));
    }

    public function exportPdfBarangRusak(Request $request)
    {
        $barangRusaks = ReturBarang::with('statusRetur')
        ->where('Id_Jenis_Retur', 3)    
        ->orderBy('Tanggal_Retur', 'desc');

        $filterYear = $request->input('year');
        $filterCondition = $request->input('condition');

        if ($filterYear) {
            $barangRusaks->whereYear('Tanggal_Retur', $filterYear);
        }

        if ($filterCondition) {
            $barangRusaks->where('Id_Status_Retur', $filterCondition);
        }

        $groupedBarangRusaks = $barangRusaks->get()->groupBy('Kode_Barang');
        $pdf = PDF::loadView('reports.barangrusak.pdf', compact('groupedBarangRusaks', 'filterYear', 'filterCondition'));

        return $pdf->download('reports_barangrusak.pdf');
    }


    public function indexRequestedItem(Request $request)
    {
        // Ambil filter tahun dari request
        $filterYear = $request->input('year');
    
        // Buat query untuk mendapatkan barang keluar dan melakukan grouping
        $requestedItemsQuery = BarangKeluar::select('Kode_Barang', DB::raw('SUM(Jumlah_Barang) as total_request'))
            ->groupBy('Kode_Barang')
            ->orderByDesc('total_request')
            ->with('barangMasuk');
    
        // Terapkan filter tahun jika ada
        if ($filterYear) {
            $requestedItemsQuery->whereYear('Tanggal_BarangKeluar', $filterYear);
        }
    
        // Eksekusi query dan ambil 10 hasil teratas
        $requestedItems = $requestedItemsQuery->take(10)->get();
    
        // Kembalikan view dengan data yang difilter
        return view('reports.requesteditem.index', compact('requestedItems'));

    }
    
public function exportPdfRequestedItem(Request $request)
{
    // Ambil filter tahun dari request
    $filterYear = $request->input('year');

    // Buat query untuk mendapatkan barang keluar dan melakukan grouping
    $requestedItemsQuery = BarangKeluar::select('Kode_Barang', DB::raw('SUM(Jumlah_Barang) as total_request'))
        ->groupBy('Kode_Barang')
        ->orderByDesc('total_request')
        ->with('barangMasuk');

    // Terapkan filter tahun jika ada
    if ($filterYear) {
        $requestedItemsQuery->whereYear('Tanggal_BarangKeluar', $filterYear);
    }

    // Eksekusi query dan ambil 10 hasil teratas
    $requestedItems = $requestedItemsQuery->take(10)->get();

    // Generate PDF dengan data yang difilter
    $pdf = PDF::loadView('reports.requesteditem.pdf', compact('requestedItems', 'filterYear'));

    return $pdf->download('reports_requesteditem.pdf');
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
