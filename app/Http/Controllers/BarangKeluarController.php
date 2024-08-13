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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
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
        return view('barangkeluar.index');
    }

    public function regulerIndex()
    {
        // Misalkan kategori 'Reguler' memiliki ID 1 atau nama 'Reguler'
        $regulerKategori = KategoriPeminjaman::where('Nama_Kategori_Peminjaman', 'Reguler')->first();

        if (!$regulerKategori) {
            // Tangani kasus di mana kategori reguler tidak ditemukan
            return redirect()->route('barangkeluar.index')->with('error', 'Kategori Reguler tidak ditemukan.');
        }

        $barangKeluars = BarangKeluar::with('kategoriBarang', 'barangMasuk')
            ->where('Id_Kategori_Peminjaman', $regulerKategori->id)
            ->orderBy('Kode_BarangKeluar')
            ->get();

        // Group by Kode_BarangKeluar and include the sum of Jumlah_Barang and No_SuratJalanBK
        $groupedBarangKeluars = $barangKeluars->groupBy('Kode_BarangKeluar')->map(function ($items) {
            $items->Jumlah_Barang = $items->sum('Jumlah_Barang');
            $items->No_SuratJalanBK = $items->first()->No_SuratJalanBK;
            $items->Tanggal_BarangKeluar = $items->first()->Tanggal_BarangKeluar;
            $items->Nama_PihakPeminjam = $items->first()->Nama_PihakPeminjam;
            $items->File_BeritaAcara = $items->first()->File_BeritaAcara;

            return $items;
        });

        confirmDelete();

        return view('barangkeluar.reguler.index', compact('groupedBarangKeluars', 'barangKeluars'));
    }

    public function Insidentilindex()
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
        $groupedBarangKeluars = $barangKeluars->groupBy('tanggal_peminjamanbarang');

        // Hitung total barang untuk setiap grup
        $groupedBarangKeluars = $groupedBarangKeluars->map(function ($items) {
            return [
                'items' => $items->flatMap(fn($item) => $item->barang),
                'total_barang' => $items->flatMap(fn($item) => $item->barang)->count(),
                'tanggal_peminjamanbarang' => $items->first()->tanggal_peminjamanbarang,
                'File_SuratJalan' => $items->first()->File_SuratJalan,
                'File_BeritaAcara' => $items->first()->File_BeritaAcara,
                'Nama_PihakPeminjam' => $items->first()->Nama_PihakPeminjam,
                'Tanggal_Keluar' => $items->first()->Tanggal_Keluar,
                'Tanggal_PengembalianBarang' => $items->first()->Tanggal_PengembalianBarang,
                'id' => $items->first()->id
            ];
        });

        // Pass the variable to the view
        return view('barangkeluar.insidentil.index', ['groupedBarangKeluars' => $groupedBarangKeluars]);
    }






    public function allIndex()
    {
        // Mengambil semua data barang keluar reguler dan insidentil
        $regulerKategori = KategoriPeminjaman::where('Nama_Kategori_Peminjaman', 'Reguler')->first();
        $insidentilKategori = KategoriPeminjaman::where('Nama_Kategori_Peminjaman', 'Insidentil')->first();

        $barangKeluarsReguler = [];
        $barangKeluarsInsidentil = [];

        if ($regulerKategori) {
            $barangKeluarsReguler = BarangKeluar::with('kategoriBarang', 'barangMasuk')
                ->where('Id_Kategori_Peminjaman', $regulerKategori->id)
                ->orderBy('Kode_BarangKeluar')
                ->get();
        }

        if ($insidentilKategori) {
            $barangKeluarsInsidentil = BarangKeluar::with('kategoriBarang', 'barangMasuk')
                ->where('Id_Kategori_Peminjaman', $insidentilKategori->id)
                ->orderBy('Kode_BarangKeluar')
                ->get();
        }

        $barangKeluars = $barangKeluarsReguler->merge($barangKeluarsInsidentil);

        // Group by Kode_BarangKeluar and include the sum of Jumlah_Barang and No_SuratJalanBK
        $groupedBarangKeluars = $barangKeluars->groupBy('Kode_BarangKeluar')->map(function ($items) {
            $items->Jumlah_Barang = $items->sum('Jumlah_Barang');
            $items->No_SuratJalanBK = $items->first()->No_SuratJalanBK;
            $items->Tanggal_BarangKeluar = $items->first()->Tanggal_BarangKeluar;
            $items->Nama_PihakPeminjam = $items->first()->Nama_PihakPeminjam;
            $items->File_BeritaAcara = $items->first()->File_BeritaAcara;

            return $items;
        });

        return view('barangkeluar.all.index', compact('groupedBarangKeluars', 'barangKeluars'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function createInsidentil(Request $request)
    {
        $pageTitle = 'Tambahkan Barang Keluar';
        $kategori = 'Insidentil';
        $kategoriPeminjamans = KategoriPeminjaman::where('Nama_Kategori_Peminjaman', $kategori)->get();

        // Mengambil data barang dari Firebase menggunakan instance $this->database
        $reference = $this->database->getReference('barang_masuk');
        $snapshot = $reference->getSnapshot();
        $barangData = $snapshot->getValue();

        $Barangs = [];

        // Mengubah format data agar sesuai dengan view
        if ($barangData) {
            foreach ($barangData as $id => $barang) {
                $Barangs[] = [
                    'id' => $id,
                    'Nama_Barang' => $barang['Nama_Barang'],
                    'Kode_Barang' => $barang['Kode_Barang'],
                    'kategoriBarang' => ['Nama_Kategori_Barang' => $barang['Kategori_Barang']]
                ];
            }
        }

        return view('barangkeluar.insidentil.create', compact('pageTitle', 'kategori', 'kategoriPeminjamans', 'Barangs'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function storeInsidentil(Request $request)
    {
        $request->validate([
            'tanggal_peminjamanbarang' => 'required|date',
            'Kategori_Peminjaman' => 'required',
            'File_SuratJalan' => 'nullable|file|mimes:pdf|max:2048',
            'nama_barang.*' => 'required|string',
            'kode_barang.*' => 'required|string',
            'Kategori_Barang.*' => 'required|string',
            'jumlah_barang.*' => 'required|integer|min:1',

        ]);

        $data = [
            'tanggal_peminjamanbarang' => $request->input('tanggal_peminjamanbarang'),
            'Kategori_Peminjaman' => $request->input('Kategori_Peminjaman'),
            'No_SuratJalanBK' => '',
            'Nama_PihakPeminjam' => '',
            'Catatan' => '',
            'Tanggal_Keluar' => '',
            'Tanggal_PengembalianBarang' => '',
            'File_BeritaAcara' => '',
            'items' => []
        ];

        // Handle file upload if any
        if ($request->hasFile('File_SuratJalan')) {
            $file = $request->file('File_SuratJalan');
            $filePath = 'surat-jalan/' . $file->getClientOriginalName();
            $this->storage->getBucket()->upload(
                fopen($file->getPathname(), 'r'),
                ['name' => $filePath]
            );
            $fileUrl = $this->storage->getBucket()->object($filePath)->signedUrl(new \DateTime('+1 hour'));
            $data['File_SuratJalan'] = $fileUrl;
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
        $this->database->getReference('Barang_Keluar')->push($data);

        return redirect()->back()->with('success', 'Data successfully saved!');
    }

    // Send notification


    public function buatBeritaAcaraInsidentil(Request $request, $Kode_BarangKeluar)
    {
        $barangKeluars = BarangKeluar::where('Kode_BarangKeluar', $Kode_BarangKeluar)->get();

        // Mengarahkan ke form pembuatan Berita Acara
        return view('barangkeluar.insidentil.createba', compact('barangKeluars', 'Kode_BarangKeluar'));
    }

    public function buatBeritaAcaraReguler(Request $request, $Kode_BarangKeluar)
    {
        $barangKeluars = BarangKeluar::where('Kode_BarangKeluar', $Kode_BarangKeluar)->get();

        // Mengarahkan ke form pembuatan Berita Acara
        return view('barangkeluar.reguler.createba', compact('barangKeluars', 'Kode_BarangKeluar'));
    }

    public function storeBeritaAcaraReguler(Request $request)
    {
        $request->validate([
            'No_SuratJalanBK' => 'nullable|string',
            'Kode_BarangKeluar' => 'required|exists:barang_keluar,Kode_BarangKeluar',
            'Nama_PihakPeminjam' => 'required|string|max:255',
            'Catatan' => 'nullable|string',
            'Tanggal_Keluar' => 'required|date',
        ]);

        //test

        $barangKeluars = BarangKeluar::where('Kode_BarangKeluar', $request->Kode_BarangKeluar)->get();

        foreach ($barangKeluars as $barangKeluar) {
            $barangKeluar->update([
                'No_SuratJalanBK' => $request->No_SuratJalanBK,
                'Nama_PihakPeminjam' => $request->Nama_PihakPeminjam,
                'Catatan' => $request->Catatan,
                'Tanggal_Keluar' => $request->Tanggal_Keluar,
            ]);
        }

        // Data untuk PDF
        $data = [
            'No_SuratJalanBK' => $request->No_SuratJalanBK,
            'Nama_PihakPeminjam' => $request->Nama_PihakPeminjam,
            'Catatan' => $request->Catatan,
            'Tanggal_Keluar' => $request->Tanggal_Keluar,
            'barangKeluarList' => $barangKeluars,
        ];

        // Generate PDF
        $pdf = PDF::loadView('barangkeluar.reguler.beritaacarareguler', $data);

        // Tentukan path direktori
        $directoryPath = storage_path('app/public/berita_acara');

        // Buat direktori jika belum ada
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }

        // Simpan PDF ke penyimpanan server
        $pdfFilename = $barangKeluar->id . '.pdf';
        $pdfPath = $directoryPath . '/' . $pdfFilename;
        $pdf->save($pdfPath);

        // Simpan path PDF ke dalam kolom File_BeritaAcara di tabel barang_keluar
        foreach ($barangKeluars as $barangKeluar) {
            $barangKeluar->update([
                'File_BeritaAcara' => 'storage/berita_acara/' . $pdfFilename,
            ]);
        }

        // Kirim notifikasi
        $notification = Notification::create([
            'title' => 'Approval Berita Acara',
            'message' => 'Berita Acara berhasil dibuat dengan Kode Barang Keluar: ' . $request->id,
            'status' => 'unread',
        ]);

        event(new NewNotification($notification));

        // Redirect ke halaman indeks dengan pesan sukses
        return redirect()->route('barangkeluar.reguler.index')->with('success', 'Berita Acara berhasil dibuat dan disimpan.');
    }




    public function storeBeritaAcara(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:barang_keluar,id', // Validasi id barang_keluar
            'Nama_PihakPeminjam' => 'required|string|max:255',
            'Catatan' => 'nullable|string',
            'Tanggal_Keluar' => 'required|date',
            'Tanggal_Kembali' => 'nullable|date|after_or_equal:Tanggal_Keluar',
            'File_BeritaAcara' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'File_SuratJalan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Ambil barang keluar berdasarkan id
        $barangKeluar = BarangKeluar::find($request->id);

        if (!$barangKeluar) {
            return redirect()->back()->with('error', 'Barang Keluar tidak ditemukan dengan ID: ' . $request->id);
        }

        // Update data barang keluar
        $barangKeluar->update([
            'Nama_PihakPeminjam' => $request->Nama_PihakPeminjam,
            'Catatan' => $request->Catatan,
            'Tanggal_Keluar' => $request->Tanggal_Keluar,
            'Tanggal_PengembalianBarang' => $request->Tanggal_Kembali,
        ]);

        // Data untuk PDF
        $data = [
            'Nama_PihakPeminjam' => $request->Nama_PihakPeminjam,
            'Catatan' => $request->Catatan,
            'Tanggal_Keluar' => $request->Tanggal_Keluar,
            'Tanggal_PengembalianBarang' => $request->Tanggal_Kembali,
            'barangKeluarList' => [$barangKeluar], // Mengirimkan satu item sebagai array
        ];

        // Generate PDF
        $pdf = PDF::loadView('barangkeluar.insidentil.beritaacara', $data);

        // Tentukan path direktori di Firebase Storage
        $pdfFilename = $barangKeluar->id . '.pdf'; // Gunakan ID sebagai nama file
        $pdfPath = 'berita_acara/' . $pdfFilename;

        // Convert PDF to string and upload to Firebase
        $pdfContent = $pdf->output();
        $this->storage->getBucket()->upload(
            $pdfContent,
            ['name' => $pdfPath]
        );

        // Dapatkan URL file PDF dari Firebase Storage
        $fileUrl = $this->storage->getBucket()->object($pdfPath)->signedUrl(new \DateTime('+1 hour'));

        // Update URL PDF di Firebase Realtime Database
        $reference = $this->database->getReference('Barang_Keluar/' . $barangKeluar->id);
        $reference->update([
            'File_BeritaAcara' => $fileUrl,
        ]);

        // Kirim notifikasi
        $notification = Notification::create([
            'title' => 'Approval Berita Acara',
            'message' => 'Berita Acara berhasil dibuat dengan ID Barang Keluar: ' . $barangKeluar->id,
            'status' => 'unread',
        ]);

        event(new NewNotification($notification));

        // Redirect ke halaman indeks dengan pesan sukses
        return redirect()->route('barangkeluar.insidentil.index')->with('success', 'Berita Acara berhasil dibuat dan disimpan.');
    }


    public function createReguler(Request $request)
    {
        $pageTitle = 'Tambahkan Barang Keluar';
        $kategori = 'Reguler';
        $kategoriPeminjamans = KategoriPeminjaman::where('Nama_Kategori_Peminjaman', $kategori)->get();
        $Barangs = BarangMasuk::with('kategoriBarang')->get();

        return view('barangkeluar.reguler.create', compact('pageTitle', 'kategori', 'kategoriPeminjamans', 'Barangs'))->with('error', 'Jenis produk tidak valid.');
    }

    public function storeReguler(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal_peminjamanbarang' => 'required|date',
            'Id_Kategori_Peminjaman' => 'required',
            'nama_barang.*' => 'required',
            'kode_barang.*' => 'required|string|max:50',
            'Kategori_Barang.*' => 'required|string|max:50',
            'jumlah_barang.*' => 'required|integer|min:1',
            'File_SuratJalan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $Kode_BarangKeluar = $this->generateNumericUID();
        $userId = Auth::id();
        $statusId = 3;
        $filePath = null;

        // Simpan file jika diunggah
        if ($request->hasFile('File_SuratJalan')) {
            $file = $request->file('File_SuratJalan');
            $filePath = $file->storeAs('public/surat_jalan', $Kode_BarangKeluar . '.' . $file->getClientOriginalExtension());
        }

        foreach ($validatedData['nama_barang'] as $index => $nama_barang) {
            $kodeBarang = $validatedData['kode_barang'][$index];
            $jumlahBarang = $validatedData['jumlah_barang'][$index];

            // Cek stok barang
            $barangMasuk = BarangMasuk::where('Kode_Barang', $kodeBarang)->first();

            if ($barangMasuk) {
                $stokBarang = $barangMasuk->JumlahBarang_Masuk - $barangMasuk->barangKeluar->sum('Jumlah_Barang');

                if ($stokBarang < $jumlahBarang) {
                    return redirect()->back()->withErrors([
                        'jumlah_barang.' . $index => 'Stok tidak mencukupi untuk barang ' . $nama_barang . '.'
                    ])->withInput();
                }

                // Buat record BarangKeluar
                BarangKeluar::create([
                    'Id_User' => $userId,
                    'Id_Kategori_Peminjaman' => $validatedData['Id_Kategori_Peminjaman'],
                    'Id_StatusBarangKeluar' => $statusId,
                    'Kode_BarangKeluar' => $Kode_BarangKeluar,
                    'Nama_Barang' => $nama_barang,
                    'Kode_Barang' => $kodeBarang,
                    'Kategori_Barang' => $validatedData['Kategori_Barang'][$index],
                    'Jumlah_Barang' => $jumlahBarang,
                    'Tanggal_BarangKeluar' => $validatedData['tanggal_peminjamanbarang'],
                    'File_SuratJalan' => $filePath ? str_replace('public/', 'storage/', $filePath) : null,
                ]);
            } else {
                return redirect()->back()->with('error', 'Barang dengan kode ' . $kodeBarang . ' tidak ditemukan.')->withInput();
            }
        }

        $notification = Notification::create([
            'title' => 'Approval Barang Keluar Reguler',
            'message' => 'Barang berhasil ditambahkan dengan Kode Barang Keluar: ' . $Kode_BarangKeluar,
            'status' => 'unread',
        ]);

        event(new NewNotification($notification));

        Alert::success('Berhasil', 'Barang Berhasil Ditambahkan.');

        return redirect()->route('barangkeluar.reguler.index')->with('success', 'Barang Keluar berhasil disimpan.');
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

    public function generateNumericUID($length = 12)
    {
        $numericUID = '';
        for ($i = 0; $i < $length; $i++) {
            $numericUID .= random_int(0, 9);
        }
        return $numericUID;
    }
}
