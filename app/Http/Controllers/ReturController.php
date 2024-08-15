<?php

namespace App\Http\Controllers;

use App\Models\JenisReturBarang;
use App\Models\ReturBarang;
use App\Models\StatusReturBarang;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

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
    public function create()
    {
        $statusRetur = StatusReturBarang::all();
        $jenisRetur = JenisReturBarang::all();
        return view('retur.create', compact('statusRetur', 'jenisRetur'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Id_Barang_Keluar' => 'required|exists:barang_keluar,id',
            'Id_User' => 'required|exists:users,id',
            'Id_Status_Retur' => 'required|exists:status_retur_barang,id',
            'Id_Jenis_Retur' => 'required|exists:jenis_retur_barang,id',
            'Pihak_Pemohon' => 'required|string|max:255',
            'Nama_Barang' => 'required|string|max:255',
            'Kode_Barang' => 'required|string|max:255',
            'Kategori_Barang' => 'required|string|max:255',
            'Jumlah_Barang' => 'required|integer|min:1',
            'Deskripsi' => 'nullable|string',
            'Tanggal_Retur' => 'required|date',
            'Gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Menyimpan gambar jika ada
        if ($request->hasFile('Gambar')) {
            $image = $request->file('Gambar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $imageName);
            $validatedData['Gambar'] = $imageName;
        }

        // Membuat entri ReturBarang baru
        $returBarang = ReturBarang::create($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('retur.index')->with('success', 'Retur barang berhasil ditambahkan.');
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
        $garansiBarangAkhir = new \DateTime($returBarang['Garansi_Barang_Akhir']);
        $garansiBarangAwal = new \DateTime($returBarang['Garansi_Barang_Awal']);
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
        $validatedData = $request->validate([
            'Kategori_Retur' => 'nullable|string|in:Bekas Handal,Barang Rusak,Bekas Bergaransi',
            'status' => 'nullable|string|',
            'Jumlah_Barang' => 'nullable|integer|',
        ]);

        // Update data di Firebase
        $this->database->getReference('Retur_Barang/' . $id)->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('retur.index')->with('success', 'Retur barang berhasil diperbarui.');
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
