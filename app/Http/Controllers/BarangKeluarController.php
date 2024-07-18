<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('barangkeluar.reguler.index');
    }
    public function insidentilIndex()
    {
        return view('barangkeluar.insidentil.index');
    }
    public function allIndex()
    {
        return view('barangkeluar.all.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $type = $request->query('type');
        $pageTitle = 'Tambahkan Barang Keluar';

        if ($type == 'insidentil') {
            return view('barangkeluar.insidentil.create', [
                'pageTitle' => $pageTitle,
            ]);
        } elseif ($type == 'reguler') {
            return view('barangkeluar.reguler.create', [
                'pageTitle' => $pageTitle,
            ]);
        } else {
            return redirect()->route('barangkeluar.index')->with('error', 'Jenis produk tidak valid.');
        }
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
