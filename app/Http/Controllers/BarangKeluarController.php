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

class BarangKeluarController extends Controller
{
    public function __construct()
    {
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

    public function insidentilIndex()
    {
        $insidentilKategori = KategoriPeminjaman::where('Nama_Kategori_Peminjaman', 'Insidentil')->first();

        if (!$insidentilKategori) {
            // Tangani kasus di mana kategori reguler tidak ditemukan
            return redirect()->route('barangkeluar.index')->with('error', 'Kategori Insidentil tidak ditemukan.');
        }

        // Adjust the query to include No_SuratJalanBK
        $barangKeluars = BarangKeluar::with(['kategoriBarang', 'barangMasuk'])
            ->where('Id_Kategori_Peminjaman', $insidentilKategori->id)
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

        return view('barangkeluar.insidentil.index', compact('groupedBarangKeluars', 'barangKeluars'));
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
        $Barangs = BarangMasuk::with('kategoriBarang')->get();

        return view('barangkeluar.insidentil.create', compact('pageTitle', 'kategori', 'kategoriPeminjamans', 'Barangs'))->with('error', 'Jenis produk tidak valid.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeInsidentil(Request $request)
    {
        // Definisikan pesan kustom untuk validasi
        $messages = [
            'required' => ':Attribute harus diisi.',
            'date' => 'Format :attribute tidak valid.',
            'integer' => 'Isi :attribute dengan angka.',
            'min' => 'Isi :attribute dengan nilai minimal :min.',
            'file' => 'File :attribute harus berupa file.',
            'mimes' => 'File :attribute harus memiliki ekstensi: :values.',
            'max' => 'Ukuran file :attribute tidak boleh lebih dari :max kilobytes.',
        ];

        // Validasi data input menggunakan Validator
        $validator = Validator::make($request->all(), [
            'tanggal_peminjamanbarang' => 'required|date',
            'Id_Kategori_Peminjaman' => 'required',
            'nama_barang.*' => 'required',
            'kode_barang.*' => 'required|string|max:50',
            'Kategori_Barang.*' => 'required|string|max:50',
            'jumlah_barang.*' => 'required|integer|min:1',
            'File_SuratJalan' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Variabel awal
        $Kode_BarangKeluar = $this->generateNumericUID();
        $userId = Auth::id();
        $statusId = 3;
        $filePath = null;

        // Simpan file jika diunggah
        if ($request->hasFile('File_SuratJalan')) {
            $file = $request->file('File_SuratJalan');
            $filePath = $file->storeAs('public/surat_jalan', $Kode_BarangKeluar . '.' . $file->getClientOriginalExtension());
        }

        // Ambil data yang sudah divalidasi
        $validatedData = $request->except('File_SuratJalan');
        $namaBarangArray = $validatedData['nama_barang'];
        $jumlahBarangArray = $validatedData['jumlah_barang'];
        $kodeBarangArray = $validatedData['kode_barang'];
        $kategoriBarangArray = $validatedData['Kategori_Barang'];

        foreach ($namaBarangArray as $index => $nama_barang) {
            $jumlahBarang = $jumlahBarangArray[$index];
            $kodeBarang = $kodeBarangArray[$index];

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
                    'Kategori_Barang' => $kategoriBarangArray[$index],
                    'Jumlah_Barang' => $jumlahBarang,
                    'Tanggal_BarangKeluar' => now(),
                ]);
            } else {
                return redirect()->back()->with('error', 'Barang dengan kode ' . $kodeBarang . ' tidak ditemukan.')->withInput();
            }
        }

        // Kirim notifikasi
        $notification = Notification::create([
            'title' => 'Approval Barang Keluar Insidentil',
            'message' => 'Barang berhasil ditambahkan dengan Kode Barang Keluar: ' . $Kode_BarangKeluar,
            'status' => 'unread',
        ]);

        event(new NewNotification($notification));

        Alert::success('Berhasil', 'Barang Berhasil Ditambahkan.');

        return redirect()->route('barangkeluar.insidentil.index')->with('success', 'Barang Keluar berhasil disimpan.');
    }





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
        $pdfFilename = $barangKeluar->Kode_BarangKeluar . '.pdf';
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
            'message' => 'Berita Acara berhasil dibuat dengan Kode Barang Keluar: ' . $request->Kode_BarangKeluar,
            'status' => 'unread',
        ]);

        event(new NewNotification($notification));

        // Redirect ke halaman indeks dengan pesan sukses
        return redirect()->route('barangkeluar.reguler.index')->with('success', 'Berita Acara berhasil dibuat dan disimpan.');
    }




    public function storeBeritaAcara(Request $request)
    {
        $request->validate([
            'No_SuratJalanBK' => 'nullable|string',
            'Kode_BarangKeluar' => 'required|exists:barang_keluar,Kode_BarangKeluar',
            'Nama_PihakPeminjam' => 'required|string|max:255',
            'Catatan' => 'nullable|string',
            'Tanggal_Keluar' => 'required|date',
            'Tanggal_Kembali' => 'nullable|date|after_or_equal:Tanggal_Keluar',
            'File_BeritaAcara' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'File_SuratJalan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $barangKeluars = BarangKeluar::where('Kode_BarangKeluar', $request->Kode_BarangKeluar)->get();

        foreach ($barangKeluars as $barangKeluar) {
            $barangKeluar->update([
                'No_SuratJalanBK' => $request->No_SuratJalanBK,
                'Nama_PihakPeminjam' => $request->Nama_PihakPeminjam,
                'Catatan' => $request->Catatan,
                'Tanggal_Keluar' => $request->Tanggal_Keluar,
                'Tanggal_PengembalianBarang' => $request->Tanggal_Kembali,
            ]);
        }

        // Data untuk PDF
        $data = [
            'No_SuratJalanBK' => $request->No_SuratJalanBK,
            'Nama_PihakPeminjam' => $request->Nama_PihakPeminjam,
            'Catatan' => $request->Catatan,
            'Tanggal_Keluar' => $request->Tanggal_Keluar,
            'Tanggal_PengembalianBarang' => $request->Tanggal_Kembali,
            'barangKeluarList' => $barangKeluars,
        ];

        // Generate PDF
        $pdf = PDF::loadView('barangkeluar.insidentil.beritaacara', $data);

        // Tentukan path direktori
        $directoryPath = storage_path('app/public/berita_acara');

        // Buat direktori jika belum ada
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }

        // Simpan PDF ke penyimpanan server
        $pdfFilename = $barangKeluar->Kode_BarangKeluar . '.pdf';
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
            'message' => 'Berita Acara berhasil dibuat dengan Kode Barang Keluar: ' . $request->Kode_BarangKeluar,
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