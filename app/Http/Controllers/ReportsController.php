<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
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
        $dataBarangMasuk = $snapshot->getValue() ?? [];

        // Mengambil data barang keluar dari Firebase
        $reference = $this->database->getReference('Barang_Keluar');
        $snapshot = $reference->getSnapshot();
        $dataBarangKeluar = $snapshot->getValue() ?? [];

        // Mengambil data retur barang dari Firebase
        $reference = $this->database->getReference('Retur_Barang');
        $snapshot = $reference->getSnapshot();
        $dataReturBarang = $snapshot->getValue() ?? [];

        // Menggabungkan data stok barang
        $stokBarang = [];

        if (is_array($dataBarangMasuk)) {
            foreach ($dataBarangMasuk as $idMasuk => $dataMasuk) {
                if (isset($dataMasuk['barang']) && is_array($dataMasuk['barang'])) {
                    foreach ($dataMasuk['barang'] as $barangMasuk) {
                        $kodeBarang = $barangMasuk['kode_barang'];

                        if (!isset($stokBarang[$kodeBarang])) {
                            $stokBarang[$kodeBarang] = [
                                'kategori_barang' => $barangMasuk['kategori_barang'],
                                'kode_barang' => $kodeBarang,
                                'nama_barang' => $barangMasuk['nama_barang'],
                                'jumlah_barang_masuk' => 0,
                                'jumlah_barang_keluar' => 0,
                                'jumlah_retur_handal' => 0,
                                'jumlah_retur_bergaransi' => 0,
                                'jumlah_retur_rusak' => 0, // Tambahkan kategori retur rusak
                                'kondisi' => $barangMasuk['jenis_barang'] ?? 'N/A',
                            ];
                        }

                        $stokBarang[$kodeBarang]['jumlah_barang_masuk'] += $barangMasuk['jumlah_barang'];
                    }
                }
            }
        }

        if (is_array($dataBarangKeluar)) {
            foreach ($dataBarangKeluar as $idKeluar => $dataKeluar) {
                if (isset($dataKeluar['barang']) && is_array($dataKeluar['barang'])) {
                    foreach ($dataKeluar['barang'] as $barangKeluar) {
                        $kodeBarang = $barangKeluar['kode_barang'];

                        if (!isset($stokBarang[$kodeBarang])) {
                            $stokBarang[$kodeBarang] = [
                                'kategori_barang' => $barangKeluar['kategori_barang'],
                                'kode_barang' => $kodeBarang,
                                'nama_barang' => $barangKeluar['nama_barang'],
                                'jumlah_barang_masuk' => 0,
                                'jumlah_barang_keluar' => 0,
                                'jumlah_retur_handal' => 0,
                                'jumlah_retur_bergaransi' => 0,
                                'jumlah_retur_rusak' => 0, // Tambahkan kategori retur rusak
                                'kondisi' => $barangKeluar['jenis_barang'] ?? 'N/A',
                            ];
                        }

                        $stokBarang[$kodeBarang]['jumlah_barang_keluar'] += $barangKeluar['jumlah_barang'];
                    }
                }
            }
        }

        // Menambahkan jumlah barang retur berdasarkan kategori
        if (is_array($dataReturBarang)) {
            foreach ($dataReturBarang as $idRetur => $retur) {
                $kodeBarang = $retur['Kode_Barang'];

                if (isset($stokBarang[$kodeBarang])) {
                    if ($retur['Kategori_Retur'] == 'Bekas Handal') {
                        $stokBarang[$kodeBarang]['jumlah_retur_handal'] += $retur['Jumlah_Barang'];
                    } elseif ($retur['Kategori_Retur'] == 'Bekas Bergaransi') {
                        $stokBarang[$kodeBarang]['jumlah_retur_bergaransi'] += $retur['Jumlah_Barang'];
                    } elseif ($retur['Kategori_Retur'] == 'Rusak') { // Tambahkan kategori rusak
                        $stokBarang[$kodeBarang]['jumlah_retur_rusak'] += $retur['Jumlah_Barang'];
                    }
                }
            }
        }

        // Menghitung selisih barang masuk dan barang keluar serta jumlah barang retur
        foreach ($stokBarang as &$stok) {
            $stok['selisih'] = $stok['jumlah_barang_masuk'] - $stok['jumlah_barang_keluar']
                + $stok['jumlah_retur_handal'] + $stok['jumlah_retur_bergaransi']
                - $stok['jumlah_retur_rusak']; // Hitung retur rusak
        }

        // Mengirim data ke view untuk ditampilkan
        return view('reports.index', [
            'stokBarang' => $stokBarang,
            'barangMasuk' => $dataBarangMasuk,
            'barangKeluar' => $dataBarangKeluar,
            'returBarang' => $dataReturBarang,
        ]);
    }

    public function downloadStokBarangPdf(Request $request)
    {
        // Ambil data Stok Barang
        $data = $this->getStokBarangData(); // Sesuaikan dengan method Anda

        // Generate PDF
        $pdf = PDF::loadView('pdf.stokbarang', compact('data'));

        // Unduh PDF
        return $pdf->download('stok_barang.pdf');
    }

    // Tambahkan metode untuk mendapatkan data stok barang
    protected function getStokBarangData()
    {
        // Ambil data stok barang dari Firebase seperti pada metode index
        $reference = $this->database->getReference('barang_masuk');
        $snapshot = $reference->getSnapshot();
        $dataBarangMasuk = $snapshot->getValue() ?? [];

        $reference = $this->database->getReference('Barang_Keluar');
        $snapshot = $reference->getSnapshot();
        $dataBarangKeluar = $snapshot->getValue() ?? [];

        $reference = $this->database->getReference('Retur_Barang');
        $snapshot = $reference->getSnapshot();
        $dataReturBarang = $snapshot->getValue() ?? [];

        $stokBarang = [];

        // Proses data barang masuk
        foreach ($dataBarangMasuk as $idMasuk => $dataMasuk) {
            if (isset($dataMasuk['barang']) && is_array($dataMasuk['barang'])) {
                foreach ($dataMasuk['barang'] as $barangMasuk) {
                    $kodeBarang = $barangMasuk['kode_barang'];

                    if (!isset($stokBarang[$kodeBarang])) {
                        $stokBarang[$kodeBarang] = [
                            'kategori_barang' => $barangMasuk['kategori_barang'],
                            'kode_barang' => $kodeBarang,
                            'nama_barang' => $barangMasuk['nama_barang'],
                            'jumlah_barang_masuk' => 0,
                            'jumlah_barang_keluar' => 0,
                            'jumlah_retur_handal' => 0,
                            'jumlah_retur_bergaransi' => 0,
                            'jumlah_retur_rusak' => 0, // Tambahkan kategori retur rusak
                            'kondisi' => $barangMasuk['jenis_barang'] ?? 'N/A',
                        ];
                    }

                    $stokBarang[$kodeBarang]['jumlah_barang_masuk'] += $barangMasuk['jumlah_barang'];
                }
            }
        }

        // Proses data barang keluar
        foreach ($dataBarangKeluar as $idKeluar => $dataKeluar) {
            if (isset($dataKeluar['barang']) && is_array($dataKeluar['barang'])) {
                foreach ($dataKeluar['barang'] as $barangKeluar) {
                    $kodeBarang = $barangKeluar['kode_barang'];

                    if (!isset($stokBarang[$kodeBarang])) {
                        $stokBarang[$kodeBarang] = [
                            'kategori_barang' => $barangKeluar['kategori_barang'],
                            'kode_barang' => $kodeBarang,
                            'nama_barang' => $barangKeluar['nama_barang'],
                            'jumlah_barang_masuk' => 0,
                            'jumlah_barang_keluar' => 0,
                            'jumlah_retur_handal' => 0,
                            'jumlah_retur_bergaransi' => 0,
                            'jumlah_retur_rusak' => 0, // Tambahkan kategori retur rusak
                            'kondisi' => $barangKeluar['jenis_barang'] ?? 'N/A',
                        ];
                    }

                    $stokBarang[$kodeBarang]['jumlah_barang_keluar'] += $barangKeluar['jumlah_barang'];
                }
            }
        }

        // Proses data retur barang
        foreach ($dataReturBarang as $idRetur => $retur) {
            $kodeBarang = $retur['Kode_Barang'];

            if (isset($stokBarang[$kodeBarang])) {
                if ($retur['Kategori_Retur'] == 'Bekas Handal') {
                    $stokBarang[$kodeBarang]['jumlah_retur_handal'] += $retur['Jumlah_Barang'];
                } elseif ($retur['Kategori_Retur'] == 'Bekas Bergaransi') {
                    $stokBarang[$kodeBarang]['jumlah_retur_bergaransi'] += $retur['Jumlah_Barang'];
                } elseif ($retur['Kategori_Retur'] == 'Rusak') { 
                    $stokBarang[$kodeBarang]['jumlah_retur_rusak'] += $retur['Jumlah_Barang'];
                }
            }
        }

        // Hitung selisih barang masuk dan barang keluar serta jumlah barang retur
        foreach ($stokBarang as &$stok) {
            $stok['selisih'] = $stok['jumlah_barang_masuk'] - $stok['jumlah_barang_keluar']
                + $stok['jumlah_retur_handal'] + $stok['jumlah_retur_bergaransi']
                - $stok['jumlah_retur_rusak'];
        }

        return $stokBarang;
    }
}

