<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeUserController extends Controller
{
    public function index()
    {
        return view('pengguna.index');
    }
    public function landing()
    {
        return view('pengguna.landingsuccess');
    }
}
