<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Carbon\Carbon;

class HomeController extends Controller
{

    protected $database;
    protected $storage;

    public function __construct()
    {
        $firebase = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env("FIREBASE_DATABASE_URL"));

        $this->database = $firebase->createDatabase();
        $this->storage = $firebase->createStorage();
        $this->middleware('auth');
    }

    public function index()
    {
        $barangMasukSnapshot = $this->database->getReference('barang_masuk')->getSnapshot();
        $barangMasukData = $barangMasukSnapshot->getValue();
        $barangKeluarSnapshot = $this->database->getReference('Barang_Keluar')->getSnapshot();
        $barangKeluarData = $barangKeluarSnapshot->getValue();

        $startDate = Carbon::now()->startOfYear(); // Start of the year
        $endDate = Carbon::now()->endOfYear(); // End of the year

        // Filter data by year and group by month
        $barangMasuk = collect($barangMasukData)->filter(function ($item) use ($startDate, $endDate) {
            $date = Carbon::parse($item['TanggalPengiriman_Barang']);
            return $date->between($startDate, $endDate);
        })->groupBy(function ($item) {
            return Carbon::parse($item['TanggalPengiriman_Barang'])->format('Y-m'); // Group by month
        })->map(function ($items) {
            return $items->count(); // Count items per month
        });

        $barangKeluar = collect($barangKeluarData)->filter(function ($item) use ($startDate, $endDate) {
            $date = Carbon::parse($item['Tanggal_PengembalianBarang']);
            return $date->between($startDate, $endDate);
        })->groupBy(function ($item) {
            return Carbon::parse($item['Tanggal_PengembalianBarangy'])->format('Y-m'); // Group by month
        })->map(function ($items) {
            return $items->count(); // Count items per month
        });

        // Generate a list of months for the current year
        $months = collect(range(1, 12))->map(function ($month) {
            return Carbon::now()->month($month)->format('Y-m');
        });

        // Map the monthly data, defaulting to 0 if no data exists
        $masukData = $months->map(fn($month) => $barangMasuk->get($month, 0));
        $keluarData = $months->map(fn($month) => $barangKeluar->get($month, 0));

        return view('home', [
            'months' => $months,
            'masukData' => $masukData,
            'keluarData' => $keluarData
        ]);
    }
}
