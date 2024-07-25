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

        // Hitung total barang untuk setiap grup
        $groupedBarangMasuks = $groupedBarangMasuks->map(function ($items) {
            $items->Jumlah_barang = $items->sum('JumlahBarang_Masuk');
            return $items;
        });

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

    public function store(Request $request)
    {
        $request->validate([
            'Id_Petugas' => 'required|exists:users,id',
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

        $fileSuratJalanPath = $request->file('File_SuratJalan') ? $request->file('File_SuratJalan')->store('file_surat_jalan') : null;

        foreach ($request->JumlahBarang_Masuk as $i => $jumlah) {
            $gambarBarangPath = isset($request->file('Gambar_Barang')[$i]) ? $request->file('Gambar_Barang')[$i]->store('gambar_barang') : null;

            BarangMasuk::create([
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
        }

        $existingNotification = Notification::where('message', 'LIKE', '%' . $request->No_Surat . '%')->first();

        if (!$existingNotification) {
            $notification = Notification::create([
                'title' => 'Approval Barang Masuk',
                'message' => 'Barang berhasil ditambahkan dengan No. Surat: ' . $request->No_Surat,
                'status' => 'unread',
            ]);

            event(new NewNotification($notification));
        }


    Alert::success('Berhasil', 'Barang Berhasil Ditambahkan.');


        return redirect()->route('barangmasuk.index')->with('success', 'Barang Masuk berhasil ditambahkan.');
    }

    public function edit($noSurat)
    {
        $barangMasuks = BarangMasuk::where('No_Surat', $noSurat)->get();
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

}
