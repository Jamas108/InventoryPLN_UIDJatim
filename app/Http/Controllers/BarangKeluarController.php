<?php

namespace App\Http\Controllers;

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

        // Hitung total barang untuk setiap grup dan tambahkan detail barang
        $groupedBarangKeluars = $groupedBarangKeluars->map(function ($items) {
            return [
                'items' => $items->flatMap(fn($item) => $item->barang),
                'total_barang' => $items->flatMap(fn($item) => $item->barang)->count(),
                'tanggal_peminjamanbarang' => $items->first()->tanggal_peminjamanbarang,
                'File_Surat' => $items->first()->File_Surat ?? null,
                'File_BeritaAcara' => $items->first()->File_BeritaAcara ?? null,
                'Nama_PihakPeminjam' => $items->first()->Nama_PihakPeminjam ?? null,
                'Kategori_Peminjaman' => $items->first()->Kategori_Peminjaman ?? null,
                'Tanggal_PengembalianBarang' => $items->first()->Tanggal_PengembalianBarang ?? null,
                'id' => $items->first()->id ?? null,
                'detail_barang' => $items->first()->barang // Menyertakan detail barang
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

        // Ambil data barang dari Firebase
        $barangMasuksSnapshot = $this->database->getReference('barang_masuk')->getSnapshot();
        $barangMasuksData = $barangMasuksSnapshot->getValue();

        // Mengubah struktur data dan filter barang dengan status 'Accept'
        $allItems = collect($barangMasuksData)->flatMap(function ($item) {
            return collect($item['barang'])->map(function ($barang) {
                return (object) $barang; // Convert each barang to object
            });
        })->filter(function ($barang) {
            return isset($barang->Status) && $barang->Status === 'Accept'; // Filter only items with 'Accept' status
        });

        return view('barangkeluar.create', [
            'pageTitle' => $pageTitle,
            'allItems' => $allItems // Mengirimkan data barang yang sudah difilter ke view
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_peminjamanbarang' => 'required|date',
            'Tanggal_PengembalianBarang' => 'nullable|date',
            'Kategori' => 'required',
            'File_Surat' => 'nullable|file|mimes:pdf|max:2048',
            'nama_barang.*' => 'required|string',
            'kode_barang.*' => 'required|string',
            'Kategori_Barang.*' => 'required|string',
            'jumlah_barang.*' => 'required|integer|min:1',

        ]);

        $user = Auth::user();

        $data = [
            'id' => uniqid(),
            'userId' => $user->id,
            'tanggal_peminjamanbarang' => $request->input('tanggal_peminjamanbarang'),
            'Tanggal_PengembalianBarang' => $request->input('Tanggal_PengembalianBarang'),
            'Kategori_Peminjaman' => $request->input('Kategori'),
            'No_SuratJalanBK' => '',
            'no_berita_acara' => '',
            'status' => $request->input('status'),
            'Nama_PihakPeminjam' => $user->Nama,
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
        $itemJenis = $request->input('jenis_barang');
        $itemGaransiAwal = $request->input('garansi_barang_awal');
        $itemGaransiAkhir = $request->input('garansi_barang_akhir');

        foreach ($itemNames as $index => $name) {
            $data['barang'][] = [
                'id' => uniqid(),
                'nama_barang' => $name,
                'kode_barang' => $itemCodes[$index],
                'kategori_barang' => $itemCategories[$index],
                'jumlah_barang' => $itemQuantities[$index],
                'jenis_barang' => $itemJenis[$index],
                'garansi_barang_awal' => $itemGaransiAwal[$index],
                'garansi_barang_akhir' => $itemGaransiAkhir[$index],
            ];
        }

        // Save data to Firebase
        $newRecordRef = $this->database->getReference('Barang_Keluar')->push($data);
        $newRecordId = $newRecordRef->getKey();

        // Update the data with the Firebase generated ID
        $newRecordRef->update(['id' => $newRecordId]);

        return redirect()->route('barangkeluar.index')->with('success', 'Barang Masuk berhasil diperbarui.');
    }

    //TODO: Insidentil
    public function buatBeritaAcara($id)
    {
        // Ambil data barang keluar berdasarkan id
        $barangKeluar = $this->database->getReference('Barang_Keluar/' . $id)->getValue();

        // Ambil semua data barang keluar untuk menentukan nomor berita acara tertinggi
        $allBarangKeluar = $this->database->getReference('Barang_Keluar')->getValue();
        $maxNumber = '000'; // Default jika belum ada data

        foreach ($allBarangKeluar as $key => $item) {
            if (isset($item['no_berita_acara'])) {
                $currentNumber = $item['no_berita_acara'];
                if (intval($currentNumber) > intval($maxNumber)) {
                    $maxNumber = $currentNumber;
                }
            }
        }

        // Increment nomor berita acara
        $nextNumber = str_pad((int)$maxNumber + 1, 3, '0', STR_PAD_LEFT);

        // Kirim data ke view
        return view('barangkeluar.createba', [
            'barangKeluar' => $barangKeluar,
            'id' => $id,
            'Nama_PihakPeminjam' => $barangKeluar['Nama_PihakPeminjam'],
            'tanggal_peminjamanbarang' => $barangKeluar['tanggal_peminjamanbarang'],
            'Tanggal_PengembalianBarang' => $barangKeluar['Tanggal_PengembalianBarang'],
            'nextNumber' => $nextNumber
        ]);
    }




    public function storeBeritaAcara(Request $request, $id)
    {

        // Validate the request
        $request->validate([
            'nomor_beritaacara' => 'nullable|string',
            'Nama_PihakPeminjam' => 'nullable|string',
            'Catatan' => 'nullable|string',
            'no_berita_acara' => 'required|string',
            'tanggal_peminjamanbarang' => 'required|date',
            'Tanggal_PengembalianBarang' => 'required|date',
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

        // Create No_SuratJalanBK by concatenating the fields
        $noSuratJalanBK = implode('/', [
            $request->input('no_berita_acara'),
            $request->input('pembuat_no_berita_acara'),
            $request->input('kategori_no_berita_acara'),
            $request->input('tahun_no_berita_acara'),
            $request->input('bulan_no_berita_acara'),

        ]);

        // Update data with the request
        $updateData = [
            'No_SuratJalanBK' => $noSuratJalanBK,
            'no_berita_acara' => $request->input('no_berita_acara', $barangKeluar['no_berita_acara'] ?? ''),
            'Nama_PihakPeminjam' => $request->input('Nama_PihakPeminjam', $barangKeluar['Nama_PihakPeminjam'] ?? ''),
            'Tanggal_PengembalianBarang' => $request->input('Tanggal_PengembalianBarang', $barangKeluar['Tanggal_PengembalianBarang'] ?? ''),
            'Catatan' => $request->input('Catatan', $barangKeluar['Catatan'] ?? ''),  // Added Catatan field
            'tanggal_peminjamanbarang' => $request->input('tanggal_peminjamanbarang', $barangKeluar['tanggal_peminjamanbarang'] ?? ''),
            'Tanggal_Keluar_BeritaAcara' => date('Y-m-d'),  // Tanggal keluar berita acara saat ini
            'status' => 'Accepted',  // Ensure status is set to 'Accept'
        ];


        // Generate PDF
        $pdf = Pdf::loadView('barangkeluar.beritaacara', [
            'No_SuratJalanBK' => $noSuratJalanBK,
            'tanggal_peminjamanbarang' => $updateData['tanggal_peminjamanbarang'] ?? null,
            'Tanggal_PengembalianBarang' => $updateData['Tanggal_PengembalianBarang'] ?? null,
            'Kategori' => $barangKeluar['Kategori'] ?? null,
            'Nama_PihakPeminjam' => $updateData['Nama_PihakPeminjam'],
            'Catatan' => $updateData['Catatan'],
            'Tanggal_Keluar_BeritaAcara' => date('Y-m-d'),  // Tanggal keluar berita acara saat ini
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

        return redirect()->route('barangkeluar.index')->with('success', 'Barang Masuk berhasil diperbarui.');
    }

    //TODO:
    public function buatBeritaAcaraReguler($id)
    {
        // Ambil data barang keluar berdasarkan id
        $barangKeluar = $this->database->getReference('Barang_Keluar/' . $id)->getValue();

        // Kirim data ke view
        return view('barangkeluar.createbareguler', [
            'barangKeluar' => $barangKeluar,
            'id' => $id,
            'Nama_PihakPeminjam' => $barangKeluar['Nama_PihakPeminjam'],
            'tanggal_peminjamanbarang' => $barangKeluar['tanggal_peminjamanbarang'],
        ]);
    }

    public function storeBeritaAcaraReguler(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'no_berita_acara' => 'nullable|string',
            'pembuat_no_berita_acara' => 'nullable|string',
            'kategori_no_berita_acara' => 'nullable|string',
            'bulan_no_berita_acara' => 'nullable|string',
            'tahun_no_berita_acara' => 'nullable|string',
            'Nama_PihakPeminjam' => 'nullable|string',
            'Catatan' => 'nullable|string',
            'tanggal_peminjamanbarang' => 'required|date',
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

        // Create No_SuratJalanBK by concatenating the fields
        $noSuratJalanBK = implode('/', [
            $request->input('no_berita_acara'),
            $request->input('pembuat_no_berita_acara'),
            $request->input('kategori_no_berita_acara'),
            $request->input('bulan_no_berita_acara'),
            $request->input('tahun_no_berita_acara')
        ]);

        // Update data with the request
        $updateData = [
            'No_SuratJalanBK' => $noSuratJalanBK,
            'Nama_PihakPeminjam' => $request->input('Nama_PihakPeminjam', $barangKeluar['Nama_PihakPeminjam'] ?? ''),
            'Catatan' => $request->input('Catatan', $barangKeluar['Catatan'] ?? ''),
            'tanggal_peminjamanbarang' => $request->input('tanggal_peminjamanbarang', $barangKeluar['tanggal_peminjamanbarang'] ?? ''),
            'Tanggal_Keluar_BeritaAcara' => date('Y-m-d'),  // Tanggal keluar berita acara saat ini
            'status' => 'Accepted',
        ];

        // Generate PDF
        $pdf = Pdf::loadView('barangkeluar.beritaacarareguler', [
            'No_SuratJalanBK' => $updateData['No_SuratJalanBK'],
            'tanggal_peminjamanbarang' => $updateData['tanggal_peminjamanbarang'] ?? null,
            'Tanggal_Keluar_BeritaAcara' => $updateData['Tanggal_Keluar_BeritaAcara'] ?? null,
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

        return redirect()->route('barangkeluar.index')->with('success', 'Barang Masuk berhasil diperbarui.');
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
    public function show($id)
    {
        // Ambil data barang keluar berdasarkan id
        $barangKeluar = $this->database->getReference('Barang_Keluar/' . $id)->getValue();

        // Cek apakah barang keluar ditemukan
        if (!$barangKeluar) {
            return redirect()->route('barangkeluar.index')->with('error', 'Data barang keluar tidak ditemukan.');
        }

        // Kirim data ke view
        return view('barangkeluar.detail', [
            'barangKeluar' => $barangKeluar,
            'id' => $id,
        ]);
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
