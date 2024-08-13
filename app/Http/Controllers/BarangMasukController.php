<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BarangMasuk;
use App\Models\StaffGudang;
use App\Models\Notification;
use App\Models\StatusBarang;
use Illuminate\Http\Request;
use App\Models\KategoriBarang;
use App\Events\NewNotification;
use RealRashid\SweetAlert\Facades\Alert;
use Kreait\Firebase\Factory;

class BarangMasukController extends Controller
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
        // Ambil data dari Firebase
        $barangMasuksSnapshot = $this->database->getReference('barang_masuk')->getSnapshot();
        $barangMasuksData = $barangMasuksSnapshot->getValue();

        // Convert data menjadi koleksi Laravel
        $barangMasuks = collect($barangMasuksData)->map(function ($item) {
            return (object) $item; // Convert array to object
        });

        // Kelompokkan barang masuk berdasarkan nomor surat
        $groupedBarangMasuks = $barangMasuks->groupBy('No_Surat');

        // Hitung total barang untuk setiap grup
        $groupedBarangMasuks = $groupedBarangMasuks->map(function ($items) {
            $items->Jumlah_barang = $items->sum('JumlahBarang_Masuk');
            return $items;
        });

        // Ambil data status barang dari database lokal jika tidak ada di Firebase
        $statusBarangs = StatusBarang::all();

        confirmDelete();

        return view('barangmasuk.index', compact('groupedBarangMasuks', 'statusBarangs'));
    }


    public function create()
    {
        $staffGudangs = User::all();
        $kategoriBarangs = KategoriBarang::all();
        $statusBarangs = StatusBarang::all();

        return view('barangmasuk.create', compact('staffGudangs', 'kategoriBarangs', 'statusBarangs'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([]);

    //     $fileSuratJalanPath = null;
    //     if ($request->hasFile('File_SuratJalan')) {
    //         $file = $request->file('File_SuratJalan');
    //         $fileName = time() . '_' . $file->getClientOriginalName();
    //         $filePath = 'file_surat_jalan/' . $fileName;

    //         // Upload ke Firebase Storage
    //         $bucket = $this->storage->getBucket();
    //         $bucket->upload(
    //             fopen($file->getPathname(), 'r'),
    //             [
    //                 'name' => $filePath,
    //             ]
    //         );
    //         $fileSuratJalanPath = $filePath;
    //     }

    //     foreach ($request->JumlahBarang_Masuk as $i => $jumlah) {
    //         $gambarBarangPath = null;
    //         if ($request->hasFile("Gambar_Barang.$i")) {
    //             $file = $request->file("Gambar_Barang.$i");
    //             $fileName = time() . '_' . $file->getClientOriginalName();
    //             $filePath = 'gambar_barang/' . $fileName;

    //             // Upload ke Firebase Storage
    //             $bucket = $this->storage->getBucket();
    //             $bucket->upload(
    //                 fopen($file->getPathname(), 'r'),
    //                 [
    //                     'name' => $filePath,
    //                 ]
    //             );
    //             $gambarBarangPath = $filePath;
    //         }

    //         $data = [
    //             'Id_Petugas' => $request->Id_Petugas,
    //             'No_Surat' => $request->No_Surat,
    //             'NamaPerusahaan_Pengirim' => $request->NamaPerusahaan_Pengirim,
    //             'TanggalPengiriman_Barang' => $request->TanggalPengiriman_Barang,
    //             'Jumlah_barang' => $request->Jumlah_barang,
    //             'Kode_Barang' => $request->Kode_Barang[$i],
    //             'Nama_Barang' => $request->Nama_Barang[$i],
    //             'Jenis_Barang' => $request->Jenis_Barang[$i],
    //             'Kategori_Barang' => $request->Kategori_Barang[$i],
    //             'JumlahBarang_Masuk' => $request->JumlahBarang_Masuk[$i],
    //             'Garansi_Barang' => $request->Garansi_Barang[$i],
    //             'Kondisi_Barang' => $request->Kondisi_Barang[$i],
    //             'Tanggal_Masuk' => $request->Tanggal_Masuk[$i],
    //             'Gambar_Barang' => $gambarBarangPath,
    //             'File_SuratJalan' => $fileSuratJalanPath, // Update path gambar
    //             'Status' => $request->Status[$i],
    //         ];

    //         // Menyimpan data ke Firebase
    //         $this->database->getReference('barang_masuk')->push($data);
    //     }

    //     Alert::success('Berhasil', 'Barang Berhasil Ditambahkan.');

    //     return redirect()->route('barangmasuk.index')->with('success', 'Barang Masuk berhasil ditambahkan.');
    // }

    public function store(Request $request)
    {
        $request->validate([]);

        $fileSuratJalanPath = null;
        if ($request->hasFile('File_SuratJalan')) {
            $file = $request->file('File_SuratJalan');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'file_surat_jalan/' . $fileName;

            // Upload ke Firebase Storage
            $bucket = $this->storage->getBucket();
            $bucket->upload(
                fopen($file->getPathname(), 'r'),
                [
                    'name' => $filePath,
                ]
            );
            $fileSuratJalanPath = $filePath;
        }

        foreach ($request->JumlahBarang_Masuk as $i => $jumlah) {
            $gambarBarangPath = null;
            if ($request->hasFile("Gambar_Barang.$i")) {
                $file = $request->file("Gambar_Barang.$i");
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'gambar_barang/' . $fileName;

                // Upload ke Firebase Storage
                $bucket = $this->storage->getBucket();
                $bucket->upload(
                    fopen($file->getPathname(), 'r'),
                    [
                        'name' => $filePath,
                    ]
                );
                $gambarBarangPath = $filePath;
            }

            $data = [
                'Id_Petugas' => $request->Id_Petugas,
                'No_Surat' => $request->No_Surat,
                'NamaPerusahaan_Pengirim' => $request->NamaPerusahaan_Pengirim,
                'TanggalPengiriman_Barang' => $request->TanggalPengiriman_Barang,
                'Jumlah_barang' => $request->jumlah_barang,
                'Kode_Barang' => $request->Kode_Barang[$i],
                'Nama_Barang' => $request->Nama_Barang[$i],
                'Jenis_Barang' => $request->Jenis_Barang[$i],
                'Kategori_Barang' => $request->Kategori_Barang[$i],
                'JumlahBarang_Masuk' => $request->JumlahBarang_Masuk[$i],
                'Garansi_Barang' => $request->Garansi_Barang[$i],
                'Kondisi_Barang' => $request->Kondisi_Barang[$i],
                'Tanggal_Masuk' => $request->Tanggal_Masuk[$i],
                'Gambar_Barang' => $gambarBarangPath,
                'File_SuratJalan' => $fileSuratJalanPath, // Update path gambar
                'Status' => $request->Status[$i],
            ];

            // Menyimpan data ke Firebase dengan ID yang dihasilkan otomatis
            $newItemRef = $this->database->getReference('barang_masuk')->push($data);
            $itemId = $newItemRef->getKey(); // Mendapatkan ID dari Firebase

            // Opsional: Update data dengan ID unik jika Anda ingin menyimpan ID di Firebase
            $newItemRef->update(['id' => $itemId]);
        }

        Alert::success('Berhasil', 'Barang Berhasil Ditambahkan.');

        return redirect()->route('barangmasuk.index')->with('success', 'Barang Masuk berhasil ditambahkan.');
    }

    public function edit($noSurat)
    {

        // Ambil data barang masuk berdasarkan No_Surat
        $barangMasuks = BarangMasuk::where('No_Surat', $noSurat)->get();

        // Ambil data lain yang diperlukan
        $staffGudangs = User::all();
        $kategoriBarangs = KategoriBarang::all();
        $statusBarangs = StatusBarang::all();

        return view('barangmasuk.edit', compact('barangMasuks', 'staffGudangs', 'kategoriBarangs', 'statusBarangs'));
    }

    public function update(Request $request, $noSurat)
    {
        $request->validate([
            'Id_Petugas' => 'required|exists:users,id',
            'No_Surat' => 'required|string|max:70',
            'NamaPerusahaan_Pengirim' => 'required|string|max:200',
            'TanggalPengiriman_Barang' => 'required|date',
            'Jumlah_barang' => 'required|integer',
            'File_SuratJalan' => 'nullable|file|max:2048',
            'Kode_Barang.*' => 'required|string|max:200',
            'Nama_Barang.*' => 'required|string|max:200',
            'Jenis_Barang.*' => 'required|string|max:50',
            'Id_Kategori_Barang.*' => 'required|exists:kategori_barang,id',
            'JumlahBarang_Masuk.*' => 'required|integer',
            'Garansi_Barang.*' => 'nullable|integer',
            'Kondisi_Barang.*' => 'required|string|max:200',
            'Tanggal_Masuk.*' => 'required|date',
            'Gambar_Barang.*' => 'nullable|file|image|max:2048',
            'Id_Status_Barang.*' => 'required|exists:status_barang,id',
        ]);

        $barangMasuks = BarangMasuk::where('No_Surat', $noSurat)->get();

        foreach ($barangMasuks as $index => $barangMasuk) {
            $fileSuratJalanPath = $request->file('File_SuratJalan') ? $request->file('File_SuratJalan')->store('file_surat_jalan') : $barangMasuk->File_SuratJalan;

            $barangMasuk->update([
                'Id_Petugas' => $request->Id_Petugas,
                'No_Surat' => $request->No_Surat,
                'NamaPerusahaan_Pengirim' => $request->NamaPerusahaan_Pengirim,
                'TanggalPengiriman_Barang' => $request->TanggalPengiriman_Barang,
                'Jumlah_barang' => $request->Jumlah_barang,
                'File_SuratJalan' => $fileSuratJalanPath,
                'Kode_Barang' => $request->Kode_Barang[$index],
                'Nama_Barang' => $request->Nama_Barang[$index],
                'Jenis_Barang' => $request->Jenis_Barang[$index],
                'Id_Kategori_Barang' => $request->Id_Kategori_Barang[$index],
                'JumlahBarang_Masuk' => $request->JumlahBarang_Masuk[$index],
                'Garansi_Barang' => $request->Garansi_Barang[$index],
                'Kondisi_Barang' => $request->Kondisi_Barang[$index],
                'Tanggal_Masuk' => $request->Tanggal_Masuk[$index],
                'Gambar_Barang' => $request->file('Gambar_Barang')[$index] ? $request->file('Gambar_Barang')[$index]->store('gambar_barang') : $barangMasuk->Gambar_Barang,
                'Id_Status_Barang' => $request->Id_Status_Barang[$index],
            ]);
        }

        Alert::success('Berhasil Diubah', 'Barang Berhasil Diubah.');


        return redirect()->route('barangmasuk.index')->with('success', 'Barang Masuk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barangmasuk = BarangMasuk::findOrFail($id);
        $barangmasuk->delete();

        Alert::success('Berhasil Dihapus', 'Barang Berhasil Dihapus.');

        return redirect()->route('barangmasuk.index')->with('success', 'Barang Masuk berhasil dihapus.');
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Accept,Pending,Reject',
        ]);

        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangMasuk->Status = $request->input('status');
        $barangMasuk->save();

        return redirect()->route('barangmasuk.index')->with('success', 'Status barang telah diperbarui.');
    }

    public function updateStatusAjax(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:barang_masuk,id',
            'status' => 'required|in:Accept,Pending,Reject',
        ]);

        $barangMasuk = BarangMasuk::findOrFail($request->input('id'));
        $barangMasuk->Status = $request->input('status');
        $barangMasuk->save();

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui.']);
    }
}
