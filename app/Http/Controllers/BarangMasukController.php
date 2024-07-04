<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use App\Models\StaffGudang;
use App\Models\KategoriBarang;
use App\Models\StatusBarang;

class BarangMasukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $barangMasuks = BarangMasuk::with('kategoriBarang', 'statusBarang')->orderBy('No_Surat')->get();

        // Kelompokkan barang masuk berdasarkan nomor surat
        $groupedBarangMasuks = $barangMasuks->groupBy('No_Surat');
        $statusBarangs = StatusBarang::all();

        return view('barangmasuk.index', compact('groupedBarangMasuks', 'statusBarangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $staffGudangs = StaffGudang::all();
        $kategoriBarangs = KategoriBarang::all();
        $statusBarangs = StatusBarang::all();

        return view('barangmasuk.create', compact('staffGudangs', 'kategoriBarangs', 'statusBarangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'Id_Petugas' => 'required|exists:staff_gudang,id',
            'No_Surat' => 'required|string|max:70',
            'NamaPerusahaan_Pengirim' => 'required|string|max:200',
            'TanggalPengiriman_Barang' => 'required|date',
            'Jumlah_barang' => 'required|string|max:70',
            'File_SuratJalan' => 'nullable|file|max:2048',
            'Kode_Barang.*' => 'nullable|string|max:200',
            'Nama_Barang.*' => 'required|string|max:200',
            'Jenis_Barang.*' => 'nullable|string|max:50',
            'Id_Kategori_Barang.*' => 'required|exists:kategori_barang,id',
            'JumlahBarang_Masuk.*' => 'required|integer',
            'Garansi_Barang.*' => 'nullable|integer',
            'Kondisi_Barang.*' => 'nullable|string|max:200',
            'Tanggal_Masuk.*' => 'required|date',
            'Gambar_Barang.*' => 'nullable|file|image|max:2048',
            'Id_Status_Barang.*' => 'required|exists:status_barang,id',
        ]);

        // Upload File_SuratJalan if present
        $fileSuratJalanPath = $request->file('File_SuratJalan') ? $request->file('File_SuratJalan')->store('file_surat_jalan') : null;

        // Iterate through the items and save each one
        for ($i = 0; $i < count($request->JumlahBarang_Masuk); $i++) {
            // Upload Gambar_Barang if present
            $gambarBarangPath = $request->file('Gambar_Barang')[$i] ? $request->file('Gambar_Barang')[$i]->store('gambar_barang') : null;

            // Create the BarangMasuk record
            $barangMasuk = new BarangMasuk([
                'Id_Petugas' => $request->Id_Petugas,
                'No_Surat' => $request->No_Surat,
                'NamaPerusahaan_Pengirim' => $request->NamaPerusahaan_Pengirim,
                'TanggalPengiriman_Barang' => $request->TanggalPengiriman_Barang,
                'Jumlah_barang' => $request->Jumlah_barang,
                'File_SuratJalan' => $fileSuratJalanPath,
                'Kode_Barang' => $request->Kode_Barang[$i],
                'Nama_Barang' => $request->Nama_Barang[$i],
                'Jenis_Barang' => $request->Jenis_Barang[$i],
                'Id_Kategori_Barang' => $request->Id_Kategori_Barang[$i],
                'JumlahBarang_Masuk' => $request->JumlahBarang_Masuk[$i],
                'Garansi_Barang' => $request->Garansi_Barang[$i],
                'Kondisi_Barang' => $request->Kondisi_Barang[$i],
                'Tanggal_Masuk' => $request->Tanggal_Masuk[$i],
                'Gambar_Barang' => $gambarBarangPath,
                'Id_Status_Barang' => $request->Id_Status_Barang[$i],
            ]);

            $barangMasuk->save();
        }

        // Redirect to a success page or return a response as needed
        return redirect()->route('barangmasuk.index')->with('success', 'Barang Masuk berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pageTitle = 'Detail Barang Masuk';

        return view('barangmasuk.show', [
            'pageTitle' => $pageTitle,
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'Id_Status_Barang' => 'required|exists:status_barang,id',
        ]);

        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangMasuk->update([
            'Id_Status_Barang' => $request->Id_Status_Barang,
        ]);

        return redirect()->back()->with('success', 'Status barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function loadBarang($noSurat)
    {
        $barangMasuks = BarangMasuk::where('No_Surat', $noSurat)->get();

        return view('barangmasuk.load_barang', compact('barangMasuks'));
    }
    public function editByNoSurat($noSurat)
    {
        // Ambil barang-barang berdasarkan nomor surat
        $barangMasuks = BarangMasuk::where('No_Surat', $noSurat)->get();
        $staffGudangs = StaffGudang::all();
        $kategoriBarangs = KategoriBarang::all();
        $statusBarangs = StatusBarang::all();

        // Tampilkan halaman edit dengan membawa data barang-barang
        return view('barangmasuk.edit_by_no_surat', compact('barangMasuks', 'staffGudangs', 'kategoriBarangs', 'statusBarangs'));
    }


    public function updateByNoSurat(Request $request, $noSurat)
    {
        // Validasi request
        $request->validate([
            'Kode_Barang.*' => 'required|string|max:200',
            'Nama_Barang.*' => 'required|string|max:200',
            'Id_Kategori_Barang.*' => 'required|exists:kategori_barang,id',
            'JumlahBarang_Masuk.*' => 'required|integer',
            // Tambahkan validasi untuk input lainnya
        ]);

        // Ambil barang-barang berdasarkan nomor surat
        $barangMasuks = BarangMasuk::where('No_Surat', $noSurat)->get();

        // Iterasi dan perbarui setiap barang
        foreach ($barangMasuks as $index => $barangMasuk) {
            $barangMasuk->update([
                'Kode_Barang' => $request->Kode_Barang[$index],
                'Nama_Barang' => $request->Nama_Barang[$index],
                'Id_Kategori_Barang' => $request->Id_Kategori_Barang[$index],
                'JumlahBarang_Masuk' => $request->JumlahBarang_Masuk[$index],
                // Tambahkan perubahan untuk input lainnya
            ]);
        }

        // Redirect atau kirim respons sukses sesuai kebutuhan
        return redirect()->route('barangmasuk.index')->with('success', 'Barang Masuk berhasil diperbarui.');
    }
}
