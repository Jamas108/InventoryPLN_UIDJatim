<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use Kreait\Firebase\Factory;

use Illuminate\Http\Request;

class SuratJalanController extends Controller
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
        // Ambil data dari Firebase Database
        $barangMasukSnapshot = $this->database->getReference('barang_masuk')->getSnapshot();
        $barangMasukData = $barangMasukSnapshot->getValue();

        // Convert Firebase data menjadi array objek dan tambahkan URL file
        $barangMasuks = collect($barangMasukData)->map(function ($item, $key) {
            $storage = app('firebase.storage');
            $bucket = $storage->getBucket();

            // Ambil URL download file dari Firebase Storage
            $file = $bucket->object($item['File_SuratJalan']);
            if ($file->exists()) {
                $item['File_SuratJalan_URL'] = $file->signedUrl(new \DateTime('1 hour')); // URL valid selama 1 jam
            } else {
                $item['File_SuratJalan_URL'] = null;
            }

            return (object) $item;
        });

        // Kirim data ke view
        return view('suratjalan.index', ['barangMasuks' => $barangMasuks]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
