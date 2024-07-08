<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarangRusakController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $barangrusaks = collect ([
            (object)[
                'id' => 1,
                'nama' => 'Switch',
                'no_seri' => '11 16700 1905',
                'tipe' => 'SW2987',
                'merk' => 'Cisco',
                'keterangan' => 'Berfungsi 1/24',
                'image' => 'logo.png',
            ],
            // Tambahkan data dummy lainnya sesuai kebutuhan
            (object)[
                'id' => 2,
                'nama' => 'Router',
                'no_seri' => '12 16700 1906',
                'tipe' => 'RT2988',
                'merk' => 'Cisco',
                'keterangan' => 'Berfungsi 2/24',
                'image' => 'logo.png',
            ],
            (object)[
                'id' => 3,
                'nama' => 'Tower Part',
                'no_seri' => '12 16700 1906',
                'tipe' => 'RT2988',
                'merk' => 'Cisco',
                'keterangan' => 'Berfungsi 2/24',
                'image' => 'logo.png',
            ],
            (object)[
                'id' => 4,
                'nama' => 'GI Part',
                'no_seri' => '12 16700 1906',
                'tipe' => 'RT2988',
                'merk' => 'Cisco',
                'keterangan' => 'Berfungsi 2/24',
                'image' => 'logo.png',
            ],
            (object)[
                'id' => 5,
                'nama' => 'UP3 Part',
                'no_seri' => '12 16700 1906',
                'tipe' => 'RT2988',
                'merk' => 'Cisco',
                'keterangan' => 'Berfungsi 2/24',
                'image' => 'logo.png',
            ]
            // Data dummy tambahan
        ]);

        return view('barangrusak.index', compact('barangrusaks'));
    }

    public function show($id)
{
    $barangrusaks = collect ([
        (object)[
            'id' => 1,
            'nama' => 'Switch',
            'no_seri' => '11 16700 1905',
            'tipe' => 'SW2987',
            'merk' => 'Cisco',
            'keterangan' => 'Berfungsi 1/24',
            'image' => 'logo.png',
        ],
        (object)[
            'id' => 2,
            'nama' => 'Router',
            'no_seri' => '12 16700 1906',
            'tipe' => 'RT2988',
            'merk' => 'Cisco',
            'keterangan' => 'Berfungsi 2/24',
            'image' => 'logo.png',
        ],
        (object)[
            'id' => 3,
            'nama' => 'Tower Part',
            'no_seri' => '12 16700 1906',
            'tipe' => 'RT2988',
            'merk' => 'Cisco',
            'keterangan' => 'Berfungsi 2/24',
            'image' => 'logo.png',
        ],
        (object)[
            'id' => 4,
            'nama' => 'GI Part',
            'no_seri' => '12 16700 1906',
            'tipe' => 'RT2988',
            'merk' => 'Cisco',
            'keterangan' => 'Berfungsi 2/24',
            'image' => 'logo.png',
        ],
        (object)[
            'id' => 5,
            'nama' => 'UP3 Part',
            'no_seri' => '12 16700 1906',
            'tipe' => 'RT2988',
            'merk' => 'Cisco',
            'keterangan' => 'Berfungsi 2/24',
            'image' => 'logo.png',
        ]
    ]);

    $barangrusak = $barangrusaks->firstWhere('id', $id);
    return view('barangrusak.show', compact('barangrusak'));
}

}
