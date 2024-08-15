<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Kreait\Firebase\Factory;

class StokBarangController extends Controller
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
        // Fetch data from Firebase
        $barangMasuksSnapshot = $this->database->getReference('barang_masuk')->getSnapshot();
        $barangMasuksData = $barangMasuksSnapshot->getValue();

        // Convert data to collection of objects
        $barangMasuks = collect($barangMasuksData)->flatMap(function ($item) {
            return collect($item['barang'])->map(function ($barang) {
                // Convert each barang to object
                return (object) $barang;
            });
        });

        // Fetch data from retur_barang
        $returBarangSnapshot = $this->database->getReference('Retur_Barang')->getSnapshot();
        $returBarangData = $returBarangSnapshot->getValue();

        // Convert data to collection of objects
        $returBarangs = collect($returBarangData)->filter(function ($item) {
            return $item['Kategori_Retur'] === 'Bekas Handal' && $item['status'] === 'Accepted';
        })->map(function ($item) {
            return (object) $item;
        });

        // Merge barang masuk and retur barang
        $combinedData = $barangMasuks->map(function ($barang) use ($returBarangs) {
            $retur = $returBarangs->firstWhere('Kode_Barang', $barang->kode_barang);
            if ($retur) {
                $barang->retur_barang = $retur;
            }
            return $barang;
        });

        // Group by kode_barang
        $groupedBarangMasuks = $combinedData->groupBy('kode_barang')->map(function ($items, $kode_barang) {
            // Generate URL for the image
            $gambarUrl = null;
            if (isset($items->first()->gambar_barang)) {
                $object = $this->storage->getBucket()->object($items->first()->gambar_barang);
                $gambarUrl = $object->signedUrl(new \DateTime('1 hour'));
            }

            return [
                'kode_barang' => $kode_barang,
                'gambar_barang' => $gambarUrl,
                'nama_barang' => $items->first()->nama_barang ?? null,
                'jumlah_barang' => $items->sum('jumlah_barang'),
                'kategori' => $items->first()->kategori_barang ?? null,
                'garansi_barang_awal' => $items->first()->garansi_barang_awal ?? null,
                'garansi_barang_akhir' => $items->first()->garansi_barang_akhir ?? null,
                'sisa_hari_garansi' => $this->calculateSisaHariGaransi($items->first()),
                'retur_barang' => $items->first()->retur_barang ?? null
            ];
        });

        return view('stokbarang.index', ['groupedBarangMasuks' => $groupedBarangMasuks]);
    }

    private function calculateSisaHariGaransi($barang)
    {
        if (isset($barang->garansi_barang_awal) && isset($barang->garansi_barang_akhir)) {
            $garansiAwal = Carbon::parse($barang->garansi_barang_awal);
            $garansiAkhir = Carbon::parse($barang->garansi_barang_akhir);
            $currentDate = Carbon::now();

            if ($currentDate->lessThan($garansiAwal)) {
                return 'Garansi belum mulai';
            } elseif ($currentDate->greaterThan($garansiAkhir)) {
                return 'Garansi telah berakhir';
            } else {
                return $currentDate->diffInDays($garansiAkhir, false) . ' hari tersisa';
            }
        } else {
            return 'Informasi garansi tidak lengkap';
        }
    }


    public function hardwareIndex(Request $request)
    {
        $filter = $request->input('filter');

        $hardwareBarangMasuks = BarangMasuk::with(['kategoriBarang', 'statusBarang', 'barangKeluar'])
            ->whereHas('kategoriBarang', function ($query) {
                $query->where('Nama_Kategori_Barang', 'hardware');
            })
            ->get()
            ->map(function ($barang) {
                $totalBarangKeluar = $barang->barangKeluar->sum('Jumlah_Barang');
                $stokBarang = max($barang->JumlahBarang_Masuk - $totalBarangKeluar, 0); // Cegah stok kurang dari 0

                $barang->setAttribute('totalBarangKeluar', $totalBarangKeluar);
                $barang->setAttribute('stokBarang', $stokBarang);

                return $barang;
            })
            ->filter(function ($barang) {
                return $barang->stokBarang > 0; // Hanya tampilkan barang dengan stok > 0
            });

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
            ->whereHas('kategoriBarang', function ($query) {
                $query->where('Nama_Kategori_Barang', 'networking');
            })
            ->get()
            ->map(function ($barang) {
                $totalBarangKeluar = $barang->barangKeluar->sum('Jumlah_Barang');
                $stokBarang = max($barang->JumlahBarang_Masuk - $totalBarangKeluar, 0); // Cegah stok kurang dari 0

                $barang->setAttribute('totalBarangKeluar', $totalBarangKeluar);
                $barang->setAttribute('stokBarang', $stokBarang);

                return $barang;
            })
            ->filter(function ($barang) {
                return $barang->stokBarang > 0; // Hanya tampilkan barang dengan stok > 0
            });

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
        // Implementasi untuk halaman create
    }

    public function store(Request $request)
    {
        // Implementasi untuk store data baru
    }

    public function show(string $id)
    {
        // Implementasi untuk menampilkan detail barang
    }

    public function edit(string $id)
    {
        // Implementasi untuk halaman edit
    }

    public function update(Request $request, string $id)
    {
        // Implementasi untuk update data
    }

    public function destroy(string $id)
    {
        // Implementasi untuk delete data
    }
}
