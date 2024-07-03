<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StokBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('stokbarang.index');
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

    public function hardwareIndex(Request $request)
    {
        $filter = $request->input('filter');

        $items = collect([
            (object)[
                'image' => 'logo.png',
                'name' => 'Roll Cable',
                'category' => 'Cable',
                'location' => 'Rak/Kolom',
                'style' => '1 m',
                'color' => 'Black',
                'quantity' => 25,
                'date_added' => now()->subDays(1)
            ],
            (object)[
                'image' => 'logo.png',
                'name' => 'Roll Cable',
                'category' => 'Cable',
                'location' => 'Rak/Kolom',
                'style' => '1 m',
                'color' => 'Black',
                'quantity' => 1,
                'date_added' => now()->subDays(2)
            ],
            (object)[
                'image' => 'logo.png',
                'name' => 'Roll Cable',
                'category' => 'Cable',
                'location' => 'Rak/Kolom',
                'style' => '1 m',
                'color' => 'Black',
                'quantity' => 0,
                'date_added' => now()->subDays(3)
            ],
            (object)[
                'image' => 'logo.png',
                'name' => 'Roll Cable',
                'category' => 'Cable',
                'location' => 'Rak/Kolom',
                'style' => '1 m',
                'color' => 'Black',
                'quantity' => 2,
                'date_added' => now()->subDays(4)
            ],
            (object)[
                'image' => 'logo.png',
                'name' => 'Roll Cable',
                'category' => 'Cable',
                'location' => 'Rak/Kolom',
                'style' => '1 m',
                'color' => 'Black',
                'quantity' => 10,
                'date_added' => now()->subDays(5)
            ],
            (object)[
                'image' => 'logo.png',
                'name' => 'Roll Cable',
                'category' => 'Cable',
                'location' => 'Rak/Kolom',
                'style' => '1 m',
                'color' => 'Black',
                'quantity' => 8,
                'date_added' => now()->subDays(6)
            ],
            (object)[
                'image' => 'logo.png',
                'name' => 'Roll Cable',
                'category' => 'Cable',
                'location' => 'Rak/Kolom',
                'style' => '1 m',
                'color' => 'Black',
                'quantity' => 4,
                'date_added' => now()->subDays(7)
            ]
        ]);

        if ($filter) {
            if ($filter == 'available') {
                $items = $items->filter(function($item) {
                    return $item->quantity > 5;
                });
            } elseif ($filter == 'low-stock') {
                $items = $items->filter(function($item) {
                    return $item->quantity <= 5 && $item->quantity > 2;
                });
            } elseif ($filter == 'last-stock') {
                $items = $items->filter(function($item) {
                    return $item->quantity <= 2;
                });
            }
            $items = $items->sortByDesc('quantity');
        } else {
            $items = $items->sortByDesc('date_added');
        }

        return view('stokbarang.hardware.index', compact('items'));
    }


    public function networkingIndex(Request $request)
    {
        $filter = $request->input('filter1');

        $items = collect([
            (object)[
                'image' => 'logo.png',
                'name' => 'Roll Cable',
                'category' => 'Cable',
                'location' => 'Rak/Kolom',
                'style' => '1 m',
                'color' => 'Black',
                'quantity' => 10,
                'date_added' => now()->subDays(1)
            ],
            (object)[
                'image' => 'logo.png',
                'name' => 'Roll Cable',
                'category' => 'Cable',
                'location' => 'Rak/Kolom',
                'style' => '1 m',
                'color' => 'Black',
                'quantity' => 30,
                'date_added' => now()->subDays(2)
            ],
            (object)[
                'image' => 'logo.png',
                'name' => 'Roll Cable',
                'category' => 'Cable',
                'location' => 'Rak/Kolom',
                'style' => '1 m',
                'color' => 'Black',
                'quantity' => 7,
                'date_added' => now()->subDays(3)
            ],
            (object)[
                'image' => 'logo.png',
                'name' => 'Roll Cable',
                'category' => 'Cable',
                'location' => 'Rak/Kolom',
                'style' => '1 m',
                'color' => 'Black',
                'quantity' => 2,
                'date_added' => now()->subDays(4)
            ],
            (object)[
                'image' => 'logo.png',
                'name' => 'Roll Cable',
                'category' => 'Cable',
                'location' => 'Rak/Kolom',
                'style' => '1 m',
                'color' => 'Black',
                'quantity' => 5,
                'date_added' => now()->subDays(5)
            ],
            (object)[
                'image' => 'logo.png',
                'name' => 'Roll Cable',
                'category' => 'Cable',
                'location' => 'Rak/Kolom',
                'style' => '1 m',
                'color' => 'Black',
                'quantity' => 0,
                'date_added' => now()->subDays(5)
            ]
        ]);

        if ($filter) {
            if ($filter == 'available') {
                $items = $items->filter(function($item) {
                    return $item->quantity > 5;
                });
            } elseif ($filter == 'low-stock') {
                $items = $items->filter(function($item) {
                    return $item->quantity <= 5 && $item->quantity > 2;
                });
            } elseif ($filter == 'last-stock') {
                $items = $items->filter(function($item) {
                    return $item->quantity <= 2;
                });
            }
            $items = $items->sortByDesc('quantity');
        } else {
            $items = $items->sortByDesc('date_added');
        }

        return view('stokbarang.networking.index', compact('items'));
    }
}
