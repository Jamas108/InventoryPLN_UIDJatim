<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\ReturBarang;
use App\Models\StatusBarang;
use App\Models\StatusReturBarang;
use Illuminate\Http\Request;

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


    public function indexRequestedItem()
    {
        return view('reports.requesteditem.index');
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
