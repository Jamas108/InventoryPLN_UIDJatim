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

        // Kirim data ke view
        return view('retur.edit', ['returBarang' => $returBarang]);
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'Pihak_Pemohon' => 'required|string|max:255',
            'Nama_Barang' => 'required|string|max:255',
            'Kode_Barang' => 'required|string|max:255',
            'Kategori_Barang' => 'required|string|max:255',
            'Kategori_Retur' => 'nullable|string|in:Bekas Handal,Barang Rusak,Bekas Bergaransi',
            'Jumlah_Barang' => 'required|integer|min:1',
            'Deskripsi' => 'nullable|string',
            'Tanggal_Retur' => 'required|date',
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
}
