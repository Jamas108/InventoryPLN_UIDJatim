<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\BeritaAcara;
use App\Models\BarangKeluar;
use App\Models\StatusBarang;
use App\Models\KategoriBarang;
use App\Models\KategoriPeminjaman;
use App\Models\Notification;
use App\Events\NewNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Kreait\Firebase\Factory;

class BarangKeluarController extends Controller
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
        $barangKeluarsSnapshot = $this->database->getReference('Barang_Keluar')->getSnapshot();
        $barangKeluarsData = $barangKeluarsSnapshot->getValue();

        // Convert data menjadi koleksi Laravel
        $barangKeluars = collect($barangKeluarsData)->map(function ($item) {
            // Convert arrays to objects
            $item['barang'] = collect($item['barang'])->map(function ($barang) {
                return (object) $barang; // Convert each barang to object
            });
            return (object) $item; // Convert main item to object
        });

        // Kelompokkan barang keluar berdasarkan tanggal peminjaman
        $groupedBarangKeluars = $barangKeluars->groupBy('id');

        // Hitung total barang untuk setiap grup
        $groupedBarangKeluars = $groupedBarangKeluars->map(function ($items) {
            return [
                'items' => $items->flatMap(fn($item) => $item->barang),
                'total_barang' => $items->flatMap(fn($item) => $item->barang)->count(),
                'tanggal_peminjamanbarang' => $items->first()->tanggal_peminjamanbarang,
                'File_SuratJalan' => $items->first()->File_SuratJalan ?? null,
                'File_BeritaAcara' => $items->first()->File_BeritaAcara ?? null,
                'Nama_PihakPeminjam' => $items->first()->Nama_PihakPeminjam ?? null,
                'Tanggal_Keluar' => $items->first()->Tanggal_Keluar ?? null,
                'Tanggal_PengembalianBarang' => $items->first()->Tanggal_PengembalianBarang ?? null,
                'id' => $items->first()->id ?? null
            ];
        });

        // Pass the variable to the view
        return view('barangkeluar.index', ['groupedBarangKeluars' => $groupedBarangKeluars]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Tambahkan Barang Keluar';
        $kategoriPeminjamans = KategoriPeminjaman::all(); // Ambil kategori peminjaman

        // Ambil data barang dari Firebase
        $barangMasuksSnapshot = $this->database->getReference('barang_masuk')->getSnapshot();
        $barangMasuksData = $barangMasuksSnapshot->getValue();

        // Mengubah struktur data
        $allItems = collect($barangMasuksData)->flatMap(function ($item) {
            return collect($item['barang'])->map(function ($barang) {
                return (object) $barang; // Convert each barang to object
            });
        });

        return view('barangkeluar.create', [
            'pageTitle' => $pageTitle,
            'kategoriPeminjamans' => $kategoriPeminjamans,
            'allItems' => $allItems // Mengirimkan data barang ke view
        ]);
    }





    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_peminjamanbarang' => 'required|date',
            'Tanggal_PengembalianBarang' => 'required|date',
            'Kategori' => 'required',
            'File_Surat' => 'nullable|file|mimes:pdf|max:2048',
            'nama_barang.*' => 'required|string',
            'kode_barang.*' => 'required|string',
            'Kategori_Barang.*' => 'required|string',
            'jumlah_barang.*' => 'required|integer|min:1',

        ]);

        $data = [
            'tanggal_peminjamanbarang' => $request->input('tanggal_peminjamanbarang'),
            'Tanggal_PengembalianBarang' => $request->input('Tanggal_PengembalianBarang'),
            'Kategori' => $request->input('Kategori'),
            'No_SuratJalanBK' => '',
            'Nama_PihakPeminjam' => '',
            'Catatan' => '',
            'File_BeritaAcara' => '',
            'items' => []
        ];

        // Handle file upload if any
        if ($request->hasFile('File_Surat')) {
            $file = $request->file('File_Surat');
            $filePath = 'surat-jalan/' . $file->getClientOriginalName();
            $this->storage->getBucket()->upload(
                fopen($file->getPathname(), 'r'),
                ['name' => $filePath]
            );
            $fileUrl = $this->storage->getBucket()->object($filePath)->signedUrl(new \DateTime('+1 hour'));
            $data['File_Surat'] = $fileUrl;
        }

        // Handle items
        $itemNames = $request->input('nama_barang');
        $itemCodes = $request->input('kode_barang');
        $itemCategories = $request->input('Kategori_Barang');
        $itemQuantities = $request->input('jumlah_barang');

        foreach ($itemNames as $index => $name) {
            $data['barang'][] = [
                'id' => uniqid(),
                'nama_barang' => $name,
                'kode_barang' => $itemCodes[$index],
                'kategori_barang' => $itemCategories[$index],
                'jumlah_barang' => $itemQuantities[$index]
            ];
        }

        // Save data to Firebase
        $newRecordRef = $this->database->getReference('Barang_Keluar')->push($data);
        $newRecordId = $newRecordRef->getKey();

        // Update the data with the Firebase generated ID
        $newRecordRef->update(['id' => $newRecordId]);

        return view('barangkeluar.index');
    }


    public function buatBeritaAcara($id)
    {
        // Ambil data barang keluar berdasarkan id
        $barangKeluar = $this->database->getReference('Barang_Keluar/' . $id)->getValue();

        // Kirim data ke view
        return view('barangkeluar.createba', [
            'barangKeluar' => $barangKeluar,
            'id' => $id,
            'Nama_PihakPeminjam' => $barangKeluar['Nama_PihakPeminjam'],
            'Tanggal_Keluar' => $barangKeluar['Tanggal_Keluar'] ?? null,
        ]);
    }



    public function storeBeritaAcara(Request $request, $id)
    {
        // Log request data
        \Log::info('Request Data:', $request->all());

        // Validate the request
        $request->validate([
            'nomor_beritaacara' => 'nullable|string',
            'Nama_PihakPeminjam' => 'nullable|string',
            'Tanggal_Kembali' => 'nullable|date',
            'Catatan' => 'nullable|string',
            'Tanggal_Keluar' => 'required|date',
        ]);

        // Fetch Barang Keluar data from Firebase
        $barangKeluarRef = $this->database->getReference('Barang_Keluar/' . $id);
        $barangKeluar = $barangKeluarRef->getValue();

        // Check if barangKeluar exists
        if (!$barangKeluar) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Prepare Barang Keluar data
        $barangKeluarList = [];
        if (isset($barangKeluar['barang']) && is_array($barangKeluar['barang'])) {
            foreach ($barangKeluar['barang'] as $barangData) {
                $barangKeluarList[] = [
                    'Kode_Barang' => $barangData['kode_barang'] ?? 'N/A',
                    'Nama_Barang' => $barangData['nama_barang'] ?? 'N/A',
                    'Jumlah_Barang' => $barangData['jumlah_barang'] ?? 'N/A',
                    'Kategori_Barang' => $barangData['kategori_barang'] ?? 'N/A',
                    'Jenis_Barang' => $barangData['jenis_barang'] ?? 'N/A',
                ];
            }
        }

        // Update data with the request
        $updateData = [
            'No_SuratJalanBK' => $request->input('nomor_beritaacara', $barangKeluar['nomor_beritaacara'] ?? ''),
            'Nama_PihakPeminjam' => $request->input('Nama_PihakPeminjam', $barangKeluar['Nama_PihakPeminjam'] ?? ''),
            'Tanggal_Kembali' => $request->input('Tanggal_Kembali', $barangKeluar['Tanggal_Kembali'] ?? ''),
            'Catatan' => $request->input('Catatan', $barangKeluar['Catatan'] ?? ''),  // Added Catatan field
            'Tanggal_Keluar' => $request->input('Tanggal_Keluar', $barangKeluar['Tanggal_Keluar'] ?? ''),
            'status' => 'Accepted',  // Ensure status is set to 'Accept'
        ];

        // Log the data to be updated
        \Log::info('Update Data:', $updateData);

        // Generate PDF
        $pdf = Pdf::loadView('barangkeluar.beritaacara', [
            'No_SuratJalanBK' => $updateData['No_SuratJalanBK'],
            'Tanggal_Keluar' => $updateData['Tanggal_Keluar'] ?? null,
            'Kategori' => $barangKeluar['Kategori'] ?? null,
            'Nama_PihakPeminjam' => $updateData['Nama_PihakPeminjam'],
            'Catatan' => $updateData['Catatan'],
            'barangKeluarList' => $barangKeluarList
        ]);

        // Save PDF to Firebase Storage
        $pdfFileName = 'berita-acara/' . 'Berita_Acara_' . $id . '.pdf';
        $pdfContent = $pdf->output();
        $this->storage->getBucket()->upload(
            $pdfContent,
            ['name' => $pdfFileName]
        );
        $pdfFileUrl = $this->storage->getBucket()->object($pdfFileName)->signedUrl(new \DateTime('+1 hour'));

        // Update Firebase record with the PDF URL and other fields
        $barangKeluarRef->update(array_merge($updateData, ['File_BeritaAcara' => $pdfFileUrl]));

        // Update stock in Barang Masuk
        $this->updateStockBarangMasuk($barangKeluar['barang']);

        return view('barangkeluar.index');
    }

    private function updateStockBarangMasuk(array $barangKeluarList)
    {
        foreach ($barangKeluarList as $barang) {
            $kodeBarang = $barang['kode_barang'] ?? 'N/A';
            $jumlahBarang = $barang['jumlah_barang'] ?? 0;

            // Fetch Barang Masuk data from Firebase
            $barangMasukRef = $this->database->getReference('barang_masuk');
            $barangMasukSnapshot = $barangMasukRef->getSnapshot();
            $barangMasukData = $barangMasukSnapshot->getValue();

            foreach ($barangMasukData as $key => $barangMasuk) {
                foreach ($barangMasuk['barang'] as $index => $barangItem) {
                    if ($barangItem['kode_barang'] === $kodeBarang) {
                        // Update stock quantity
                        $currentStock = $barangItem['jumlah_barang'] ?? 0;
                        $newStock = $currentStock - $jumlahBarang;

                        // Update Firebase record
                        $barangMasukRef->getChild($key . '/barang/' . $index)->update([
                            'jumlah_barang' => $newStock,
                        ]);
                    }
                }
            }
        }
    }






    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
