<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Auth;


class UserInventoryController extends Controller
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
        // Dapatkan data pengguna yang sedang login
        $user = Auth::user();
        $userId = $user->id; // ID pengguna yang sedang login

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

        // **Filter data barang keluar berdasarkan userId yang sedang login**
        $filteredBarangKeluars = $barangKeluars->filter(function ($item) use ($userId) {
            return isset($item->userId) && $item->userId == $userId; // Hanya barang dengan userId yang sama
        });

        // Kelompokkan barang keluar berdasarkan ID barang
        $groupedBarangKeluars = $filteredBarangKeluars->groupBy('id');

        // Hitung total barang untuk setiap grup dan tambahkan detail barang
        $groupedBarangKeluars = $groupedBarangKeluars->map(function ($items) {
            return [
                'items' => $items->flatMap(fn($item) => $item->barang),
                'total_barang' => $items->flatMap(fn($item) => $item->barang)->count(),
                'tanggal_peminjamanbarang' => $items->first()->tanggal_peminjamanbarang,
                'File_Surat' => $items->first()->File_Surat ?? null,
                'File_BeritaAcara' => $items->first()->File_BeritaAcara ?? null,
                'Nama_PihakPeminjam' => $items->first()->Nama_PihakPeminjam ?? null,
                'status' => $items->first()->status ?? null,
                'Tanggal_Keluar' => $items->first()->Tanggal_Keluar ?? null,
                'Tanggal_PengembalianBarang' => $items->first()->Tanggal_PengembalianBarang ?? null,
                'id' => $items->first()->id ?? null,
                'detail_barang' => $items->first()->barang // Menyertakan detail barang
            ];
        });

        // Pass the variable to the view
        return view('pengguna.peminjaman.index', ['groupedBarangKeluars' => $groupedBarangKeluars]);
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

        return view('pengguna.peminjaman.insidentil', [
            'pageTitle' => $pageTitle,
            'allItems' => $allItems // Mengirimkan data barang yang sudah difilter ke view
        ]);
    }

    public function createReguler()
    {
        $pageTitle = 'Tambahkan Barang Keluar';

        // Ambil data barang dari Firebase
        $barangMasuksSnapshot = $this->database->getReference('barang_masuk')->getSnapshot();
        $barangMasuksData = $barangMasuksSnapshot->getValue();

        // Mengubah struktur data
        $allItems = collect($barangMasuksData)->flatMap(function ($item) {
            return collect($item['barang'])->map(function ($barang) {
                return (object) $barang; // Convert each barang to object
            });
        });

        return view('pengguna.peminjaman.reguler', [
            'pageTitle' => $pageTitle,
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

        return redirect()->route('pengguna.index')->with('success', 'Barang Masuk berhasil diperbarui.');
    }

    public function storeReguler(Request $request)
    {
        $request->validate([
            'tanggal_peminjamanbarang' => 'required|date',
            'Tanggal_PengembalianBarang' => 'nullable|date',
            'Kategori' => 'required',
            'File_Surat' => 'required|file|mimes:pdf|max:2048',
            'nama_barang.*' => 'required|string',
            'kode_barang.*' => 'required|string',
            'Kategori_Barang.*' => 'required|string',
            'jumlah_barang.*' => 'required|integer|min:1',
        ], [
            'tanggal_peminjamanbarang.required' => 'Tanggal peminjaman barang wajib diisi.',
            'File_Surat.mimes' => 'File surat harus berformat PDF.',
            'File_Surat.required' => 'File surat wajib diisi.',
            'File_Surat.max' => 'Ukuran file surat tidak boleh lebih dari 2MB.',
            'jumlah_barang.*.required' => 'Jumlah barang wajib diisi.',
            'jumlah_barang.*.min' => 'Jumlah barang minimal 1.',
        ]);

        $user = Auth::user();

        $data = [
            'id' => uniqid(),
            'userId' => $user->id,
            'tanggal_peminjamanbarang' => $request->input('tanggal_peminjamanbarang'),
            'Tanggal_PengembalianBarang' => $request->input('Tanggal_PengembalianBarang'),
            'Kategori_Peminjaman' => $request->input('Kategori'),
            'No_SuratJalanBK' => '',
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

        return redirect()->route('pengguna.success')->with('success', 'Barang Masuk berhasil diperbarui.');
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
