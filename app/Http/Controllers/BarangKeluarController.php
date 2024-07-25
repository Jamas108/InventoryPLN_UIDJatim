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
        return view('barangkeluar.all.index');
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
        $validatedData = $request->validate([
            'tanggal_peminjamanbarang' => 'required|date',
            'Id_Kategori_Peminjaman' => 'required',
            'nama_barang.*' => 'required',
            'kode_barang.*' => 'required|string|max:50',
            'Kategori_Barang.*' => 'required|string|max:50',
            'jumlah_barang.*' => 'required|integer|min:1',
        ]);

        $Kode_BarangKeluar = $this->generateNumericUID();
        $userId = Auth::id();
        $statusId = 3;

        foreach ($validatedData['nama_barang'] as $index => $nama_barang) {
            BarangKeluar::create([
                'Id_User' => $userId,
                'Id_Kategori_Peminjaman' => $validatedData['Id_Kategori_Peminjaman'],
                'Id_StatusBarangKeluar' => $statusId,
                'Kode_BarangKeluar' => $Kode_BarangKeluar,
                'Nama_Barang' => $nama_barang,
                'Kode_Barang' => $validatedData['kode_barang'][$index],
                'Kategori_Barang' => $validatedData['Kategori_Barang'][$index],
                'Jumlah_Barang' => $validatedData['jumlah_barang'][$index],
                'Tanggal_BarangKeluar' => $validatedData['tanggal_peminjamanbarang'],
            ]);
        }

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
            ]);

            if ($request->hasFile('File_BeritaAcara')) {
                $filePath = $request->file('File_BeritaAcara')->store('public/berita_acara_files');
                $barangKeluar->File_BeritaAcara = str_replace('public/', '', $filePath);
            }

            if ($request->hasFile('File_SuratJalan')) {
                $filePath = $request->file('File_SuratJalan')->store('public/surat_jalan_files');
                $barangKeluar->File_SuratJalan = str_replace('public/', '', $filePath);
            }

            $barangKeluar->save();
        }

        $notification = Notification::create([
            'title' => 'Approval Berita Acara',
            'message' => 'Berita Acara berhasil dibuat dengan Kode Barang Keluar: ' . $request->Kode_BarangKeluar,
            'status' => 'unread',
        ]);

        event(new NewNotification($notification));

        Alert::success('Berhasil', 'Berita Acara Berhasil Ditambahkan.');

        return redirect()->route('barangkeluar.reguler.index')->with('success', 'Berita Acara berhasil disimpan.');
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

            if ($request->hasFile('File_BeritaAcara')) {
                $filePath = $request->file('File_BeritaAcara')->store('public/berita_acara_files');
                $barangKeluar->File_BeritaAcara = str_replace('public/', '', $filePath);
            }

            if ($request->hasFile('File_SuratJalan')) {
                $filePath = $request->file('File_SuratJalan')->store('public/surat_jalan_files');
                $barangKeluar->File_SuratJalan = str_replace('public/', '', $filePath);
            }

            $barangKeluar->save();
        }

        $notification = Notification::create([
            'title' => 'Approval Berita Acara',
            'message' => 'Berita Acara berhasil dibuat dengan Kode Barang Keluar: ' . $request->Kode_BarangKeluar,
            'status' => 'unread',
        ]);

        event(new NewNotification($notification));

        Alert::success('Berhasil', 'Berita Acara Berhasil Ditambahkan.');

        return redirect()->route('barangkeluar.insidentil.index')->with('success', 'Berita Acara berhasil disimpan.');
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
        ]);

        $Kode_BarangKeluar = $this->generateNumericUID();
        $userId = Auth::id();
        $statusId = 3;

        foreach ($validatedData['nama_barang'] as $index => $nama_barang) {
            BarangKeluar::create([
                'Id_User' => $userId,
                'Id_Kategori_Peminjaman' => $validatedData['Id_Kategori_Peminjaman'],
                'Id_StatusBarangKeluar' => $statusId,
                'Kode_BarangKeluar' => $Kode_BarangKeluar,
                'Nama_Barang' => $nama_barang,
                'Kode_Barang' => $validatedData['kode_barang'][$index],
                'Kategori_Barang' => $validatedData['Kategori_Barang'][$index],
                'Jumlah_Barang' => $validatedData['jumlah_barang'][$index],
                'Tanggal_BarangKeluar' => $validatedData['tanggal_peminjamanbarang'],
            ]);
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
