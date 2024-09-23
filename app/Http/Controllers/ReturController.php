<?php

namespace App\Http\Controllers;

use App\Models\JenisReturBarang;
use App\Models\ReturBarang;
use App\Models\StatusReturBarang;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Log;

class ReturController extends Controller
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
        // Ambil data dari Firebase menggunakan instance $this->database
        $returBarangSnapshot = $this->database->getReference('Retur_Barang')->getSnapshot();
        $returBarangData = $returBarangSnapshot->getValue();

        // Kirim data ke view
        return view('retur.index', ['returBarangData' => $returBarangData]);
    }

    public function bergaransiIndex()
    {
        $bekasBergaransis = ReturBarang::where('Id_Jenis_Retur', 2)->get();
        return view('retur.bekasbergaransi.index', compact('bekasBergaransis'));
    }
    public function handalIndex()
    {
        $bekasHandals = ReturBarang::where('Id_Jenis_Retur', 1)->get();
        return view('retur.bekashandal.index', compact('bekasHandals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($itemId, $barangId)
    {
        // Fetch Barang Keluar data from Firebase using itemId
        $barangKeluarSnapshot = $this->database->getReference('Barang_Keluar/' . $itemId)->getSnapshot();
        $barangKeluarData = $barangKeluarSnapshot->getValue();

        // Find the specific barang data within Barang Keluar
        $barangData = null;
        if ($barangKeluarData && isset($barangKeluarData['barang'])) {
            foreach ($barangKeluarData['barang'] as $barang) {
                if ($barang['id'] === $barangId) {
                    $barangData = $barang;
                    $barangNama = $barang['nama_barang'] ?? 'N/A';
                    $barangKode = $barang['kode_barang'] ?? 'N/A';
                    $barangKategori = $barang['kategori_barang'] ?? 'N/A';
                    $garansiAwal = $barang['garansi_barang_awal'] ?? 'N/A';
                    $garansiAkhir = $barang['garansi_barang_akhir'] ?? 'N/A';
                    $jumlahBarang = $barang['jumlah_barang'] ?? 'N/A';
                    break;
                }
            }
        }

        // Convert data to object format
        $formattedBarangKeluar = (object) [
            'barangId' => $barangKeluarData['id'] ?? null,
            'kategori_peminjaman' => $barangKeluarData['kategori_peminjaman'] ?? 'N/A',
            'Nama_PihakPeminjam' => $barangKeluarData['Nama_PihakPeminjam'] ?? 'N/A',
            'tanggal_peminjamanbarang' => $barangKeluarData['tanggal_peminjamanbarang'] ?? 'N/A',
            'status' => $barangKeluarData['status'] ?? 'N/A',
            'file_berita_acara' => $barangKeluarData['file_berita_acara'] ?? null,
            'catatan' => $barangKeluarData['catatan'] ?? 'N/A',
            'barang' => $barangData
        ];

        // Send data to the return form view
        return view('retur.create', [
            'barangKeluar' => $formattedBarangKeluar,
            'barangId' => $barangId,
            'nama_barang' => $barangNama,
            'kode_barang' => $barangKode,
            'kategori_barang' => $barangKategori,
            'garansi_barang_awal' => $garansiAwal,
            'garansi_barang_akhir' => $garansiAkhir,
            'jumlah_barang' => $jumlahBarang,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form input
        $validatedData = $request->validate([
            'Id_User' => 'required|string',
            'Pihak_Pemohon' => 'required|string',
            'Nama_Barang' => 'required|string',
            'Kode_Barang' => 'required|string',
            'Kategori_Barang' => 'required|string',
            'Jumlah_Barang' => 'required|integer',
            'Tanggal_Retur' => 'required|date',
            'Surat_Retur' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'Gambar_Retur' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'Deskripsi' => 'nullable|string',
            'garansi_barang_awal' => 'nullable|string',
            'garansi_barang_akhir' => 'nullable|string',
            'barangId' => 'required|string',
            'status' => 'required|string'
        ]);

        // Handle file uploads
        $suratReturPath = null;
        $gambarReturPath = null;

        if ($request->hasFile('Surat_Retur')) {
            $suratReturFile = $request->file('Surat_Retur');
            $suratReturPath = $suratReturFile->store('retur_files', 'public');
        }

        if ($request->hasFile('Gambar_Retur')) {
            $gambarReturFile = $request->file('Gambar_Retur');
            $gambarReturPath = $gambarReturFile->store('retur_images', 'public');
        }

        // Prepare data for saving
        $returData = [
            'id' => uniqid(),
            'UserId' => $validatedData['Id_User'],
            'Pihak_Pemohon' => $validatedData['Pihak_Pemohon'],
            'nama_barang' => $validatedData['Nama_Barang'],
            'kode_barang' => $validatedData['Kode_Barang'],
            'kategori_barang' => $validatedData['Kategori_Barang'],
            'jumlah_barang' => $validatedData['Jumlah_Barang'],
            'Tanggal_Retur' => $validatedData['Tanggal_Retur'],
            'Surat_Retur' => $suratReturPath,
            'Gambar_Retur' => $gambarReturPath,
            'Deskripsi' => $validatedData['Deskripsi'],
            'garansi_barang_awal' => $validatedData['garansi_barang_awal'],
            'garansi_barang_akhir' => $validatedData['garansi_barang_akhir'],
            'barangId' => $validatedData['barangId'],
            'status' => $validatedData['status'],
            'Kategori_Retur' => '',
        ];

        // Save the retur data to Firebase
        $newReturRef = $this->database->getReference('Retur_Barang')->push($returData);
        $itemId = $newReturRef->getKey();
        $newReturRef->update(['id' => $itemId]);

        // Update stock in Barang Keluar
        $this->updateStockBarangKeluar($validatedData['barangId'], $validatedData['Jumlah_Barang']);

        // Redirect or return a response
        return redirect()->route('retur.index')->with('success', 'Retur created successfully.');
    }

    public function updateStockBarangKeluar($barangId, $jumlahBarangRetur)
    {
        // Ambil data Barang Keluar
        $barangKeluarRef = $this->database->getReference('Barang_Keluar');
        $barangKeluarData = $barangKeluarRef->getValue();

        // Periksa setiap item di Barang Keluar untuk menemukan barang yang sesuai
        foreach ($barangKeluarData as $itemId => $itemData) {
            if (isset($itemData['barang'])) {
                foreach ($itemData['barang'] as $key => $barang) {
                    // Cek apakah barang_id pada item cocok dengan barangId
                    if ($barang['id'] == $barangId) {
                        // Ambil jumlah stok saat ini dari barang yang ditemukan
                        $jumlahStokSaatIni = $barang['jumlah_barang'] ?? 0;

                        // Kurangi stok sesuai dengan jumlah barang retur
                        $stokTerbaru = max(0, $jumlahStokSaatIni - $jumlahBarangRetur);

                        // Update stok Barang Keluar di Firebase
                        $barangKeluarRef->getChild($itemId . '/barang/' . $key)->update(['jumlah_barang' => $stokTerbaru]);

                        return true;  // Berhenti setelah update sukses
                    }
                }
            }
        }

        // Jika barangId tidak ditemukan
        return false;
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
        // Ambil data dari Firebase menggunakan instance $this->database
        $returBarangSnapshot = $this->database->getReference('Retur_Barang/' . $id)->getSnapshot();
        $returBarang = $returBarangSnapshot->getValue();

        // Pastikan $returBarang tidak null
        if (!$returBarang) {
            // Handle case when no data is found, e.g., redirect or show an error
            return redirect()->route('retur.index')->withErrors('Data tidak ditemukan.');
        }

        // Menghitung sisa waktu garansi
        $garansiBarangAkhir = new \DateTime($returBarang['garansi_barang_akhir']);
        $garansiBarangAwal = new \DateTime($returBarang['garansi_barang_awal']);
        $now = new \DateTime();

        // Jika tanggal saat ini berada di antara tanggal awal dan akhir garansi
        if ($now > $garansiBarangAwal && $now <= $garansiBarangAkhir) {
            $interval = $now->diff($garansiBarangAkhir);
            $sisaGaransi = $interval->format('%m bulan, %d hari');
        } else {
            $sisaGaransi = 'Garansi sudah habis';
        }

        // Kirim data ke view
        return view('retur.edit', [
            'returBarang' => $returBarang,
            'sisaGaransi' => $sisaGaransi,
        ]);
    }


    public function update(Request $request, string $id)
    {
        // Validasi data dari request
        $validatedData = $request->validate([
            'Kategori_Retur' => 'nullable|string|in:Bekas Handal,Barang Rusak,Bekas Bergaransi',
            'status' => 'nullable|string',
            'jumlah_barang' => 'required|integer|min:1', // Pastikan jumlah barang tidak kurang dari 1
        ]);

        // Ambil data retur dari Firebase berdasarkan ID retur
        $returRef = $this->database->getReference('Retur_Barang/' . $id);
        $returData = $returRef->getValue();

        // Pastikan data retur ada
        if (!$returData) {
            return redirect()->route('retur.index')->with('error', 'Data retur tidak ditemukan.');
        }

        // Ambil jumlah barang retur yang ada di database
        $jumlahBarangRetur = $returData['jumlah_barang'] ?? 0;

        // Hitung jumlah barang yang di-ACC
        $jumlahBarangAcc = $validatedData['jumlah_barang'];

        // Hitung jumlah barang yang tidak di-ACC
        $jumlahBarangTidakAcc = $jumlahBarangRetur - $jumlahBarangAcc;

        // Jika ada barang yang tidak di-ACC, update stok barang masuk
        if ($jumlahBarangTidakAcc > 0) {
            $this->updateStockBarangMasuk($returData['kode_barang'], $jumlahBarangTidakAcc); // Update stok dengan barang yang tidak di-ACC
        }

        // Update data retur di Firebase dengan data yang telah divalidasi
        $returRef->update($validatedData);

        // Redirect ke halaman retur dengan pesan sukses
        return redirect()->route('retur.index')->with('success', 'Retur barang berhasil diperbarui.');
    }




    private function updateStockBarangMasuk(string $kodeBarang, int $jumlahBarangTidakAcc)
    {
        Log::info("Memulai proses update stok barang masuk.");

        // Ambil data barang masuk dari Firebase
        $barangMasukRef = $this->database->getReference('barang_masuk')->getSnapshot();
        $barangMasuk = $barangMasukRef->getValue();

        $found = false; // Flag untuk menemukan barang

        // Loop untuk setiap entry di barang_masuk
        foreach ($barangMasuk as $entryKey => $entry) {
            // Memastikan bahwa field 'barang' ada dan merupakan array
            if (isset($entry['barang']) && is_array($entry['barang'])) {
                // Loop untuk setiap barang di dalam 'barang'
                foreach ($entry['barang'] as $itemKey => $item) {
                    // Periksa apakah kode barang cocok
                    if (isset($item['kode_barang']) && $item['kode_barang'] === $kodeBarang) {
                        $found = true; // Tandai barang ditemukan
                        $stokLama = $item['jumlah_barang'] ?? 0; // Menggunakan jumlah_barang
                        Log::info("Stok lama untuk Kode $kodeBarang: $stokLama");

                        // Tambah stok berdasarkan barang yang tidak di-ACC
                        $stokBaru = $stokLama + $jumlahBarangTidakAcc;
                        Log::info("Menghitung stok baru untuk Kode $kodeBarang: $stokBaru");

                        // Update stok barang masuk di Firebase
                        $this->database->getReference("barang_masuk/$entryKey/barang/$itemKey")->update(['jumlah_barang' => $stokBaru]);
                        Log::info("Stok untuk Kode $kodeBarang telah diperbarui menjadi $stokBaru.");
                        break 2; // Hentikan semua loop setelah menemukan barang yang cocok
                    }
                }
            } else {
                Log::warning("Data barang tidak valid di entry: " . json_encode($entry));
            }
        }

        if (!$found) {
            Log::warning("Barang dengan Kode $kodeBarang tidak ditemukan dalam data barang masuk.");
        }

        Log::info("Proses update stok barang masuk selesai.");
    }





    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showImage($id)
    {
        $returBarang = $this->database->getReference('Retur_Barang/' . $id)->getValue();

        if (isset($returBarang['Gambar_Retur'])) {
            return response()->redirectTo($returBarang['Gambar_Retur']);
        }

        return redirect()->back()->with('error', 'Gambar tidak ditemukan.');
    }

    public function showSuratJalan($id)
    {
        $returBarang = $this->database->getReference('Retur_Barang/' . $id)->getValue();

        if (isset($returBarang['Surat_Retur'])) {
            return response()->redirectTo($returBarang['Surat_Retur']);
        }

        return redirect()->back()->with('error', 'Surat Jalan tidak ditemukan.');
    }


    // KONFIGURASI CONTROLER BEKAS HANDAL

    public function indexHandal()
    {
        // Ambil data dari Firebase
        $returBarangSnapshot = $this->database->getReference('Retur_Barang')->getSnapshot();
        $returBarangData = $returBarangSnapshot->getValue();

        // Filter data berdasarkan Kategori_Retur "Bekas Handal"
        $bekasHandals = [];
        if ($returBarangData) {
            foreach ($returBarangData as $key => $value) {
                if (isset($value['Kategori_Retur']) && $value['Kategori_Retur'] === 'Bekas Handal') {
                    $bekasHandals[$key] = $value;
                }
            }
        }

        // Kirim data yang sudah difilter ke view
        return view('retur.bekashandal.index', ['bekasHandals' => $bekasHandals]);
    }

    // KONFIGURASI CONTROLER BEKAS  BERGARANSI
    public function indexBergaransi()
    {
        // Ambil data dari Firebase
        $returBarangSnapshot = $this->database->getReference('Retur_Barang')->getSnapshot();
        $returBarangData = $returBarangSnapshot->getValue();

        // Filter data berdasarkan Kategori_Retur "Bekas Handal"
        $bekasBergaransi = [];
        if ($returBarangData) {
            foreach ($returBarangData as $key => $value) {
                if (isset($value['Kategori_Retur']) && $value['Kategori_Retur'] === 'Bekas Bergaransi') {
                    $bekasBergaransi[$key] = $value;
                }
            }
        }

        // Kirim data yang sudah difilter ke view
        return view('retur.bekasbergaransi.index', ['bekasBergaransi' => $bekasBergaransi]);
    }


    // KONFIGURASI CONTROLER BARANG RUSAK

    public function indexRusak()
    {
        // Ambil data dari Firebase
        $returBarangSnapshot = $this->database->getReference('Retur_Barang')->getSnapshot();
        $returBarangData = $returBarangSnapshot->getValue();

        // Filter data berdasarkan Kategori_Retur "Bekas Handal"
        $barangRusak = [];
        if ($returBarangData) {
            foreach ($returBarangData as $key => $value) {
                if (isset($value['Kategori_Retur']) && $value['Kategori_Retur'] === 'Barang Rusak') {
                    $barangRusak[$key] = $value;
                }
            }
        }

        // Kirim data yang sudah difilter ke view
        return view('retur.barangrusak.index', ['barangRusak' => $barangRusak]);
    }
}
