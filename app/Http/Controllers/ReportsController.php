<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class ReportsController extends Controller
{
    protected $database;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env("FIREBASE_DATABASE_URL"));

        $this->database = $factory->createDatabase();
    }

    public function index()
    {
        // Mengambil data barang masuk dari Firebase
        $reference = $this->database->getReference('barang_masuk');
        $snapshot = $reference->getSnapshot();
        $dataBarangMasuk = $snapshot->getValue();

        $reference = $this->database->getReference('Barang_Keluar');
        $snapshot = $reference->getSnapshot();
        $dataBarangKeluar = $snapshot->getValue();

        $reference = $this->database->getReference('Retur_Barang');
        $snapshot = $reference->getSnapshot();
        $dataReturBarang = $snapshot->getValue();

        // Mengirim data ke view untuk ditampilkan
        return view('reports.index', [
            'barangMasuk' => $dataBarangMasuk,
            'barangKeluar' => $dataBarangKeluar,
            'returBarang' => $dataReturBarang,
        ]);
    }
}
