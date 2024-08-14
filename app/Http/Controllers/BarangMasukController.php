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
use Illuminate\Support\Facades\Auth;

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

        $barangMasuks = collect($barangMasuksData)->map(function ($item) {
            // Convert arrays to objects
            $item['barang'] = collect($item['barang'])->map(function ($barang) {
                return (object) $barang; // Convert each barang to object
            });
            return (object) $item; // Convert main item to object
        });

        // Kelompokkan barang keluar berdasarkan tanggal peminjaman
        $groupedBarangMasuks = $barangMasuks->groupBy('id');

        // Hitung total barang untuk setiap grup
        $groupedBarangMasuks = $barangMasuks->groupBy('id')->map(function ($items) {
            return collect([
                'items' => $items->flatMap(fn($item) => $item->barang),
                'Jumlah_barang' => $items->flatMap(fn($item) => $item->barang)->count(),
                'File_SuratJalan' => $items->first()->File_SuratJalan ?? null,
                'File_BeritaAcara' => $items->first()->File_BeritaAcara ?? null,
                'NamaPerusahaan_Pengirim' => $items->first()->NamaPerusahaan_Pengirim ?? null,
                'Jumlah_BarangMasuk' => $items->first()->Jumlah_BarangMasuk ?? null,
                'No_Surat' => $items->first()->No_Surat ?? null,
                'TanggalPengiriman_Barang' => $items->first()->TanggalPengiriman_Barang ?? null,
                'id' => $items->first()->id ?? null
            ]);
        });
        $Id_role = Auth::user()->Id_Role;



        return view('barangmasuk.index', ['groupedBarangMasuks' => $groupedBarangMasuks]);
    }


    public function create()
    {
        $staffGudangs = User::all();
        $kategoriBarangs = KategoriBarang::all();
        $statusBarangs = StatusBarang::all();

        return view('barangmasuk.create', compact('staffGudangs', 'kategoriBarangs', 'statusBarangs'));
    }


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

        // Initialize the data for the main entry
        $data = [
            'Id_Petugas' => $request->Id_Petugas,
            'No_Surat' => $request->No_Surat,
            'NamaPerusahaan_Pengirim' => $request->NamaPerusahaan_Pengirim,
            'TanggalPengiriman_Barang' => $request->TanggalPengiriman_Barang,
            'Jumlah_BarangMasuk' => $request->jumlah_barangmasuk,
            'File_SuratJalan' => $fileSuratJalanPath,
            'barang' => [],
        ];

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

            // Add the item's data including the specific image path
            $data['barang'][] = [
                'id' => uniqid(),
                'nama_barang' => $request->Nama_Barang[$i],
                'kode_barang' => $request->Kode_Barang[$i],
                'kategori_barang' => $request->Kategori_Barang[$i],
                'jumlah_barang' => $request->JumlahBarang_Masuk[$i],
                'jenis_barang' => $request->Jenis_Barang[$i],
                'garansi_barang' => $request->Garansi_Barang[$i],
                'tanggal_masuk' => $request->Tanggal_Masuk[$i],
                'Status' => $request->Status[$i],
                'gambar_barang' => $gambarBarangPath,
            ];
        }

        // Save the entire entry to Firebase
        $newItemRef = $this->database->getReference('barang_masuk')->push($data);
        $itemId = $newItemRef->getKey(); // Mendapatkan ID dari Firebase

        // Optionally update the entry with the ID
        $newItemRef->update(['id' => $itemId]);

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
        // Validasi inputan
        $request->validate([
            'Status' => 'required|string|max:50',
        ]);

        try {
            // Mendapatkan referensi ke data barang masuk berdasarkan ID
            $barangMasukRef = $this->database->getReference('barang_masuk/' . $id);

            // Memperbarui field Status
            $barangMasukRef->update([
                'Status' => $request->input('Status'),
            ]);

            Alert::success('Berhasil', 'Status barang berhasil diperbarui.');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui status barang: ' . $e->getMessage());
        }

        return redirect()->route('barangmasuk.index')->with('success', 'Status barang berhasil diperbarui.');
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
