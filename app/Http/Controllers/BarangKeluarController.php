<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\BeritaAcara;
use App\Models\KategoriBarang;
use App\Models\KategoriPeminjaman;
use App\Models\StatusBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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

        $barangKeluars = BarangKeluar::with('kategoriBarang')
            ->where('Id_Kategori_Peminjaman', $regulerKategori->id)
            ->orderBy('Kode_BarangKeluar')
            ->get();

        $groupedBarangKeluars = $barangKeluars->groupBy('Kode_BarangKeluar');

        $groupedBarangKeluars = $groupedBarangKeluars->map(function ($items) {
            $items->Jumlah_Barang = $items->sum('Jumlah_Barang');
            return $items;
        });


        return view('barangkeluar.reguler.index', compact('groupedBarangKeluars', 'barangKeluars'));
    }
    public function insidentilIndex()
    {
        $insidentilKategori = KategoriPeminjaman::where('Nama_Kategori_Peminjaman', 'Insidentil')->first();

        if (!$insidentilKategori) {
            // Tangani kasus di mana kategori reguler tidak ditemukan
            return redirect()->route('barangkeluar.index')->with('error', 'Kategori Reguler tidak ditemukan.');
        }

        $barangKeluars = BarangKeluar::with('kategoriBarang')
            ->where('Id_Kategori_Peminjaman', $insidentilKategori->id)
            ->orderBy('Kode_BarangKeluar')
            ->get();

        $groupedBarangKeluars = $barangKeluars->groupBy('Kode_BarangKeluar');

        $groupedBarangKeluars = $groupedBarangKeluars->map(function ($items) {
            $items->Jumlah_Barang = $items->sum('Jumlah_Barang');
            return $items;
        });


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

        return redirect()->route('barangkeluar.index')->with('success', 'Barang Keluar berhasil disimpan.');
    }

    public function buatBeritaAcaraInsidentil(Request $request, $Kode_BarangKeluar)
    {
        // Dapatkan data Barang Keluar berdasarkan Kode_BarangKeluar
        $barangKeluars = BarangKeluar::where('Kode_BarangKeluar', $Kode_BarangKeluar)->get();
        $totalBarangDipinjam = BarangKeluar::where('Kode_BarangKeluar', $request->Kode_BarangKeluar)->sum('Jumlah_Barang');

        // Anda dapat menambahkan logika lain jika diperlukan

        return view('barangkeluar.insidentil.createba', compact('barangKeluars', 'Kode_BarangKeluar','totalBarangDipinjam',));
    }

    public function storeBeritaAcara(Request $request)
    {


        $user = Auth::user();
        $totalBarangDipinjam = BarangKeluar::where('Kode_BarangKeluar', $request->Kode_BarangKeluar)->sum('Jumlah_Barang');


        $beritaAcara = new BeritaAcara();
        $beritaAcara->Id_BarangKeluar = $request->Kode_BarangKeluar;
        $beritaAcara->Id_User = $user->id;
        $beritaAcara->Nama_PihakPeminjam = $request->Nama_PihakPeminjam;
        $beritaAcara->Total_BarangDipinjam = $totalBarangDipinjam;
        $beritaAcara->Catatan = $request->Catatan;

        if ($request->hasFile('File_BeritaAcara')) {
            $beritaAcara->File_BeritaAcara = $request->file('File_BeritaAcara')->store('berita_acara_files');
        }

        if ($request->hasFile('File_SuratJalan')) {
            $beritaAcara->File_SuratJalan = $request->file('File_SuratJalan')->store('surat_jalan_files');
        }

        $beritaAcara->Tanggal_Keluar = $request->Tanggal_Keluar;
        $beritaAcara->Tanggal_Kembali = $request->Tanggal_Kembali;
        $beritaAcara->save();

        return redirect()->route('barangkeluar.index')->with('success', 'Berita Acara berhasil disimpan.');
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

        return redirect()->route('barangkeluar.index')->with('success', 'Barang Keluar berhasil disimpan.');
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
