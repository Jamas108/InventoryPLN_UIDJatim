<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Storage;


class ReportsController extends Controller
{
    protected $database;
    protected $storage;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env("FIREBASE_DATABASE_URL"));

        $this->database = $factory->createDatabase();
        $this->storage = $factory->createStorage();
    }
    protected function getStorageImageUrl($filePath)
    {
        try {
            $bucket = $this->storage->getBucket();
            $object = $bucket->object($filePath);

            if ($object->exists()) {
                return $object->signedUrl(new \DateTime('tomorrow')); // URL dengan validitas 1 hari
            }

            return null; // Jika file tidak ditemukan
        } catch (\Exception $e) {
            return null;
        }
    }


    public function index()
    {
        // Mendapatkan data dari Firebase
        $dataBarangMasuk = $this->fetchData('barang_masuk');
        $dataBarangKeluar = $this->fetchData('Barang_Keluar');
        $dataReturBarang = $this->fetchData('Retur_Barang');

        // Status yang diterima
        $statusAccepted = ['Accept', 'Accepted',];

        // Filter data Barang Masuk
        $filteredBarangMasuk = array_filter($dataBarangMasuk, function ($dataMasuk) use ($statusAccepted) {
            // Pastikan data barang ada dan adalah array
            if (isset($dataMasuk['barang']) && is_array($dataMasuk['barang'])) {
                // Filter barang berdasarkan status
                $filteredBarang = array_filter($dataMasuk['barang'], function ($barang) use ($statusAccepted) {
                    return isset($barang['Status']) && in_array($barang['Status'], $statusAccepted);
                });

                // Jika ada barang yang diterima, simpan entri ini
                if (!empty($filteredBarang)) {
                    $dataMasuk['barang'] = $filteredBarang;
                    return $dataMasuk;
                }
            }
            return false;
        });

        // Hapus entri yang tidak ada barangnya
        $filteredBarangMasuk = array_filter($filteredBarangMasuk);

        // Filter data Barang Keluar
        $dataBarangKeluar = array_filter($dataBarangKeluar, function ($dataKeluar) use ($statusAccepted) {
            return isset($dataKeluar['barang']) && is_array($dataKeluar['barang'])
                ? array_filter($dataKeluar['barang'], fn($barang) => in_array($dataKeluar['status'], $statusAccepted))
                : [];
        });

        // Filter data Retur Barang
        $dataReturBarang = array_filter($dataReturBarang, function ($retur) use ($statusAccepted) {
            return in_array($retur['status'] ?? 'N/A', $statusAccepted);
        });

        // Menggabungkan data stok barang
        $stokBarang = $this->processStokBarang($dataBarangMasuk, $dataBarangKeluar, $dataReturBarang);

        // Memisahkan data berdasarkan kategori
        $stokBarangNetworking = array_filter($stokBarang, fn($item) => $item['kategori_barang'] === 'Networking');
        $stokBarangHardware = array_filter($stokBarang, fn($item) => $item['kategori_barang'] === 'Hardware');

        // Menambahkan gambar ke barang masuk
        foreach ($filteredBarangMasuk as &$dataMasuk) {
            if (isset($dataMasuk['barang']) && is_array($dataMasuk['barang'])) {
                foreach ($dataMasuk['barang'] as &$barang) {
                    // Cari gambar dari stok barang berdasarkan kode barang
                    $stok = collect($stokBarangNetworking)->firstWhere('kode_barang', $barang['kode_barang']);
                    if ($stok) {
                        $barang['gambar_barang'] = $stok['gambar_barang_masuk'];
                    }
                    $stokHardware = collect($stokBarangHardware)->firstWhere('kode_barang', $barang['kode_barang']);
                    if ($stokHardware) {
                        $barang['gambar_barang'] = $stokHardware['gambar_barang_masuk'];
                    }
                }
            }
        }
        // Menambahkan gambar ke barang keluar
        foreach ($dataBarangKeluar as &$dataKeluar) {
            if (isset($dataKeluar['barang']) && is_array($dataKeluar['barang'])) {
                foreach ($dataKeluar['barang'] as &$barang) {
                    $stok = collect($stokBarangNetworking)->firstWhere('kode_barang', $barang['kode_barang']);
                    if ($stok) {
                        $barang['gambar_barang'] = $stok['gambar_barang_masuk'];
                    }
                    $stokHardware = collect($stokBarangHardware)->firstWhere('kode_barang', $barang['kode_barang']);
                    if ($stokHardware) {
                        $barang['gambar_barang'] = $stokHardware['gambar_barang_masuk'];
                    }
                }
            }
        }

        // Menambahkan URL gambar ke data retur barang
        foreach ($dataReturBarang as &$dataRetur) {
            if (isset($dataRetur['barang']) && is_array($dataRetur['barang'])) {
                foreach ($dataRetur['barang'] as &$barang) {
                    // Cari gambar dari stok barang berdasarkan kode barang
                    $stok = collect($stokBarangNetworking)->firstWhere('kode_barang', $barang['kode_barang']);
                    if ($stok) {
                        $barang['Gambar_Retur'] = $stok['Gambar_Retur'];
                    }
                    $stokHardware = collect($stokBarangHardware)->firstWhere('kode_barang', $barang['kode_barang']);
                    if ($stokHardware) {
                        $barang['Gambar_Retur'] = $stokHardware['Gambar_Retur'];
                    }
                }
            }
        }
        // Mengirim data ke view untuk ditampilkan
        return view('reports.index', [
            'stokBarangNetworking' => $stokBarangNetworking,
            'stokBarangHardware' => $stokBarangHardware,
            'barangMasuk' => $filteredBarangMasuk,
            'barangKeluar' => $dataBarangKeluar,
            'returBarang' => $dataReturBarang,
        ]);
    }

    // Metode untuk mendapatkan data dari Firebase
    protected function fetchData($reference)
    {
        $snapshot = $this->database->getReference($reference)->getSnapshot();
        return $snapshot->getValue() ?? [];
    }

    // Metode untuk memproses data stok barang
    protected function processStokBarang($dataBarangMasuk, $dataBarangKeluar, $dataReturBarang)
    {
        $stokBarang = [];

        if (is_array($dataBarangMasuk)) {
            foreach ($dataBarangMasuk as $dataMasuk) {
                if (isset($dataMasuk['barang']) && is_array($dataMasuk['barang'])) {
                    foreach ($dataMasuk['barang'] as $barangMasuk) {
                        if (isset($barangMasuk['Status']) && in_array($barangMasuk['Status'], ['Accept', 'Accepted'])) {
                            $kodeBarang = $barangMasuk['kode_barang'];

                            if (!isset($stokBarang[$kodeBarang])) {
                                $stokBarang[$kodeBarang] = [
                                    'kategori_barang' => $barangMasuk['kategori_barang'],
                                    'kode_barang' => $kodeBarang,
                                    'nama_barang' => $barangMasuk['nama_barang'],
                                    'gambar_barang_masuk' => $this->getStorageImageUrl($barangMasuk['gambar_barang'] ?? null), // Mendapatkan URL gambar barang masuk
                                    'jumlah_barang_masuk' => 0,
                                    'jumlah_stok' => 0,
                                    'jumlah_barang_keluar' => 0,
                                    'jumlah_retur_handal' => 0,
                                    'jumlah_retur_bergaransi' => 0,
                                    'jumlah_retur_rusak' => 0,
                                    'kondisi' => $barangMasuk['jenis_barang'] ?? 'N/A',
                                    'status' => $barangMasuk['Status'] ?? 'N/A',
                                ];
                            }

                            $stokBarang[$kodeBarang]['jumlah_barang_masuk'] += $barangMasuk['inisiasi_stok'];
                            $stokBarang[$kodeBarang]['jumlah_stok'] += $barangMasuk['jumlah_barang'];
                        }
                    }
                }
            }
        }

        if (is_array($dataBarangKeluar)) {
            foreach ($dataBarangKeluar as $dataKeluar) {
                if (isset($dataKeluar['status']) && in_array($dataKeluar['status'], ['Accept', 'Accepted'])) {
                    if (isset($dataKeluar['barang']) && is_array($dataKeluar['barang'])) {
                        foreach ($dataKeluar['barang'] as $barangKeluar) {
                            $kodeBarang = $barangKeluar['kode_barang'];

                            if (!isset($stokBarang[$kodeBarang])) {
                                $stokBarang[$kodeBarang] = [
                                    'kategori_barang' => $barangKeluar['kategori_barang'],
                                    'kode_barang' => $kodeBarang,
                                    'nama_barang' => $barangKeluar['nama_barang'],
                                    'gambar_barang_masuk' => $this->getStorageImageUrl($barangKeluar['gambar_barang'] ?? null), // Mendapatkan URL gambar barang keluar
                                    'jumlah_barang_masuk' => 0,
                                    'jumlah_barang_keluar' => 0,
                                    'jumlah_retur_handal' => 0,
                                    'jumlah_retur_bergaransi' => 0,
                                    'jumlah_retur_rusak' => 0,
                                    'kondisi' => $barangKeluar['jenis_barang'] ?? 'N/A',
                                    'status' => $dataKeluar['status'] ?? 'N/A',
                                ];
                            }

                            $stokBarang[$kodeBarang]['jumlah_barang_keluar'] += $barangKeluar['jumlah_barang'];
                        }
                    }
                }
            }
        }

        if (is_array($dataReturBarang)) {
            foreach ($dataReturBarang as $retur) {
                $kodeBarang = $retur['kode_barang'];
                $stokBarang[$kodeBarang]['Gambar_Retur'] = $this->getStorageImageUrl($retur['Gambar_Retur'] ?? null);

                if (isset($stokBarang[$kodeBarang])) {
                    if ($retur['Kategori_Retur'] == 'Bekas Handal') {
                        $stokBarang[$kodeBarang]['jumlah_retur_handal'] += $retur['jumlah_barang'];
                    } elseif ($retur['Kategori_Retur'] == 'Bekas Bergaransi') {
                        $stokBarang[$kodeBarang]['jumlah_retur_bergaransi'] += $retur['jumlah_barang'];
                    } elseif ($retur['Kategori_Retur'] == 'Barang Rusak') {
                        $stokBarang[$kodeBarang]['jumlah_retur_rusak'] += $retur['jumlah_barang'];
                    }
                }
            }
        }

        foreach ($stokBarang as &$stok) {
            $stok['selisih'] = $stok['jumlah_stok'];

        }

        return $stokBarang;
    }
    public function downloadBarangMasukPdf(Request $request)
    {
        $dataBarangMasuk = $this->fetchData('barang_masuk');
        $pdf = PDF::loadView('pdf.barangmasuk', ['data' => $dataBarangMasuk]);
        return $pdf->download('barang_masuk.pdf');
    }

    public function downloadBarangKeluarPdf(Request $request)
    {
        $dataBarangKeluar = $this->fetchData('Barang_Keluar');
        $pdf = PDF::loadView('pdf.barangkeluar', ['data' => $dataBarangKeluar]);
        return $pdf->download('barang_keluar.pdf');
    }

    public function downloadReturBarangPdf(Request $request)
    {
        $dataBarangRetur = $this->fetchData('Retur_Barang');
        $pdf = PDF::loadView('pdf.returbarang', ['data' => $dataBarangRetur]);
        return $pdf->download('barang_retur.pdf');
    }

    public function downloadStokBarangPdf(Request $request)
    {
        $dataBarangMasuk = $this->fetchData('barang_masuk');
        $dataBarangKeluar = $this->fetchData('Barang_Keluar');
        $dataReturBarang = $this->fetchData('Retur_Barang');

        $stokBarang = $this->processStokBarang($dataBarangMasuk, $dataBarangKeluar, $dataReturBarang);

        $stokBarangNetworking = array_filter($stokBarang, fn($item) => $item['kategori_barang'] === 'Networking');
        $stokBarangHardware = array_filter($stokBarang, fn($item) => $item['kategori_barang'] === 'Hardware');

        $pdf = PDF::loadView('pdf.stokbarang', [
            'stokBarangNetworking' => $stokBarangNetworking,
            'stokBarangHardware' => $stokBarangHardware,
        ]);

        return $pdf->download('stok_barang.pdf');
    }
}