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
        // KONEKSI DATABASE //
        //koneksi database barang masuk
        $barangMasukSnapshot = $this->database->getReference('barang_masuk')->getSnapshot();
        $barangMasukData = $barangMasukSnapshot->getValue();
        //koneksi database barang keluar
        $barangKeluarSnapshot = $this->database->getReference('Barang_Keluar')->getSnapshot();
        $barangKeluarData = $barangKeluarSnapshot->getValue();
        //koneksi database retur
        $returBarangSnapshot = $this->database->getReference('Retur_Barang')->getSnapshot();
        $returBarangData = $returBarangSnapshot->getValue();
        //koneksi database user
        $usersSnapshot = $this->database->getReference('users')->getSnapshot();
        $usersData = $usersSnapshot->getValue();

        // COUNT DASHBOARD //
        //COUNT BARANG MASUK
        $totalBarangMasuk = 0;
        $totalPending = 0;
        $totalAccepted = 0;
        $totalJenisBarang = 0;
        if (!empty($barangMasukData)) {
            // Iterate over each item in 'barang_masuk'
            foreach ($barangMasukData as $item) {
                // Check if 'barang' key exists in the current item
                if (isset($item['barang']) && is_array($item['barang'])) {
                    // Sum up the jumlah_barang for each barang item
                    foreach ($item['barang'] as $barangItem) {
                        // Ensure jumlah_barang is numeric before adding
                        if (isset($barangItem['jumlah_barang']) && is_numeric($barangItem['jumlah_barang']))
                            $totalBarangMasuk += $barangItem['jumlah_barang'];


                        // Use the 'Status' key safely
                        $status = $barangItem['Status'] ?? null; // Adjusted to match case-sensitive key

                        // If status is null, log the item for further inspection
                        if ($status === null) {
                            continue; // Skip this iteration
                        }

                        // Count pending and accepted items based on your specific criteria
                        if (strtolower($status) === 'pending') { // Use strtolower for case insensitivity
                            $totalPending++;
                        } elseif (strtolower($status) === 'accept') { // Adjusted to match the exact status string
                            $totalAccepted++;
                        }
                    }

                    // Count unique categories
                    if (isset($item['barang']) && is_array($item['barang'])) {
                        // Count total items in 'barang'
                        $totalJenisBarang += count($item['barang']);
                    } // Unique categories
                } 
            }
        }

        //COUNT BARANG KELUAR
        $totalBarangKeluar = 0; // Total of jumlah_barang in barang keluar
        $totalPendingKeluar = 0;
        $totalInsidentil = 0; // Peminjaman Insidentil
        $totalReguler = 0; // Peminjaman Reguler

        // Check if 'barang_keluar' data is not empty
        if (!empty($barangKeluarData)) {
            foreach ($barangKeluarData as $item) {
                // Check if 'barang' exists and is an array
                if (isset($item['status']) && $item['status'] === 'Accepted') {
                    if (isset($item['barang']) && is_array($item['barang'])) {
                        foreach ($item['barang'] as $barang) {
                            // Check if 'jumlah_barang' exists and is numeric
                            if (isset($barang['jumlah_barang']) && is_numeric($barang['jumlah_barang'])) {
                                $totalBarangKeluar += $barang['jumlah_barang'];
                            }
                        }
                    }
                }

                // Check the status and kategori peminjaman at the root level
                if (isset($item['status']) && $item['status'] === 'Accepted') {
                    if (isset($item['Kategori_Peminjaman'])) {
                        if ($item['Kategori_Peminjaman'] === 'Insidentil') {
                            $totalInsidentil++; // Increment count for Insidentil
                        } elseif ($item['Kategori_Peminjaman'] === 'Reguler') {
                            $totalReguler++; // Increment count for Reguler
                        }
                    }
                }

                // Count pending status
                if (isset($item['status']) && $item['status'] === 'Pending') {
                    $totalPendingKeluar++;
                }
            }
        }

        //COUNT RETUR
        // Initialize counters for Retur Barang
        $totalReturBarang = 0;
        $totalReturBarangPending = 0;  // Count for all returned items
        $totalBekasHandal = 0; // Count for Bekas Handal
        $totalBekasBergaransi = 0; // Count for Bekas Bergaransi
        $totalBarangRusak = 0; // Count for Barang Rusak

        // Check if 'Retur_Barang' data is not empty
        if (!empty($returBarangData)) {
            foreach ($returBarangData as $item) {
                // Count all returned items
                if (isset($item['status']) && $item['status'] === 'Accepted') {
                    $totalReturBarang++; // Count all accepted returns

                    // Check category of returned item
                    if (isset($item['Kategori_Retur'])) {
                        // Ensure jumlah_barang is numeric before adding
                        if (isset($item['jumlah_barang']) && is_numeric($item['jumlah_barang'])) {
                            $jumlahBarang = (int)$item['jumlah_barang'];

                            if ($item['Kategori_Retur'] === 'Bekas Handal') {
                                $totalBekasHandal += $jumlahBarang; // Accumulate jumlah_barang for Bekas Handal
                            } elseif ($item['Kategori_Retur'] === 'Bekas Bergaransi') {
                                $totalBekasBergaransi += $jumlahBarang; // Accumulate jumlah_barang for Bekas Bergaransi
                            } elseif ($item['Kategori_Retur'] === 'Barang Rusak') {
                                $totalBarangRusak += $jumlahBarang; // Accumulate jumlah_barang for Barang Rusak
                            }
                        }
                    }
                }
                // Count pending status
                if (isset($item['status']) && $item['status'] === 'Pending') {
                    $totalReturBarangPending++;
                }
            }
        }

        //COUNT USERS
        // Initialize count for users
        $totalUsers = 0;

        // Check if 'Users' data is not empty
        if (!empty($usersData)) {
            $totalUsers = count($usersData); // Count the total users
        }

        // CHART //

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
            $date = Carbon::parse($item['tanggal_peminjamanbarang']);
            return $date->between($startDate, $endDate);
        })->groupBy(function ($item) {
            return Carbon::parse($item['tanggal_peminjamanbarang'])->format('Y-m'); // Group by month
        })->map(function ($items) {
            return $items->count(); // Count items per month
        });

        $barangRetur = collect($returBarangData)->filter(function ($item) use ($startDate, $endDate) {
            $date = Carbon::parse($item['Tanggal_Retur']);
            return $date->between($startDate, $endDate);
        })->groupBy(function ($item) {
            return Carbon::parse($item['Tanggal_Retur'])->format('Y-m'); // Group by month
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
        $returData = $months->map(fn($month) => $barangRetur->get($month, 0));

        return view('home', [
            'months' => $months,
            'returData' => $returData,
            'masukData' => $masukData,
            'keluarData' => $keluarData,
            'totalBarangMasuk' => $totalBarangMasuk,
            'totalPending' => $totalPending,
            'totalAccepted' => $totalAccepted,
            'totalJenisBarang' => $totalJenisBarang,
            'totalBarangKeluar' => $totalBarangKeluar,
            'totalPendingKeluar' => $totalPendingKeluar,
            'totalInsidentil' => $totalInsidentil,
            'totalReguler' => $totalReguler,
            'totalReturBarang' => $totalReturBarang,
            'totalReturBarangPending' => $totalReturBarangPending,
            'totalBekasHandal' => $totalBekasHandal,
            'totalBekasBergaransi' => $totalBekasBergaransi,
            'totalBarangRusak' => $totalBarangRusak,
            'totalUsers' => $totalUsers,
        ]);
    }
}
