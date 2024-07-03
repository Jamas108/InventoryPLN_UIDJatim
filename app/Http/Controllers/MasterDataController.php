<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $items = collect([
            (object)[
                'name' => 'Roll Cable',
               'image' => 'logo.png',
                'merk' => 'Merk A',
                'kode' => 'Kode123',
                'satuan_ukuran' => '1 m',
                'location' => 'Rak/Kolom',
                'jenis_barang' => 'Networking',
                'category' => 'Cable',
                'date_added' => now()->subDays(1)
            ],
            (object)[
                'name' => 'Roll Cable',
               'image' => 'logo.png',
                'kode' => 'Kode123',
                'location' => 'Rak/Kolom',
                'category' => 'Cable',
                'date_added' => now()->subDays(2)
            ],
            (object)[
                'name' => 'Roll Cable',
               'image' => 'logo.png',
                'kode' => 'Kode123',
                'location' => 'Rak/Kolom',
                'category' => 'Cable',
                'date_added' => now()->subDays(3)
            ],
            (object)[
                'name' => 'Roll Cable',
               'image' => 'logo.png',
                'kode' => 'Kode123',
                'location' => 'Rak/Kolom',
                'category' => 'Cable',
                'date_added' => now()->subDays(4)
            ],
            (object)[
                'name' => 'Roll Cable',
               'image' => 'logo.png',
                'kode' => 'Kode123',
                'location' => 'Rak/Kolom',
                'category' => 'Cable',
                'date_added' => now()->subDays(5)
            ],
            (object)[
                'name' => 'Roll Cable',
               'image' => 'logo.png',
                'kode' => 'Kode123',
                'location' => 'Rak/Kolom',
                'category' => 'Cable',
                'date_added' => now()->subDays(6)
            ],
            (object)[
                'name' => 'Roll Cable',
               'image' => 'logo.png',
                'kode' => 'Kode123',
                'location' => 'Rak/Kolom',
                'category' => 'Cable',
                'date_added' => now()->subDays(7)
            ],
            // Tambahkan item dummy lainnya di sini
        ]);

        return view('masterdata.index', compact('items'));
    }
}
