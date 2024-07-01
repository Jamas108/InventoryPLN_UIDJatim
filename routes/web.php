<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\StokBarangController;
use App\Http\Controllers\SuratJalanController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangRusakController;
use App\Http\Controllers\BarangKeluarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('barangmasuk', BarangMasukController::class);


Route::resource('/barangkeluar', BarangKeluarController::class);


Route::resource('/barangrusak', BarangRusakController::class);


Route::resource('/stokbarang', StokBarangController::class);


Route::resource('/masterdata', MasterDataController::class);


Route::resource('/suratjalan', SuratJalanController::class);


Route::resource('/retur', ReturController::class);

// Rute untuk reports
Route::resource('/reports', ReportsController::class);
Route::get('/reports/barangkeluar/index', [ReportsController::class, 'indexbarangkeluar'])->name('indexbarangkeluar');
Route::get('/reports/barangmasuk/index', [ReportsController::class, 'indexbarangmasuk'])->name('indexbarangmasuk');
Route::get('/reports/barangrusak/index', [ReportsController::class, 'indexbarangrusak'])->name('indexbarangrusak');
Route::get('/reports/requesteditem/index', [ReportsController::class, 'indexrequesteditem'])->name('indexrequesteditem');


// Route::get('/suratjalan/create', [BarangMasukController::class, 'createSuratJalan'])->name('createsuratjalan');

Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');


Route::resource('/user', UserController::class);

Route::get('/stokbarang/hardware', [StokBarangController::class, 'hardwareIndex'])->name('stokbarang.hardware.index');
Route::get('/stokbarang/networking', [StokBarangController::class, 'networkingIndex'])->name('stokbarang.networking.index');
