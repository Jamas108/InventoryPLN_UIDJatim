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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/barangmasuk', [BarangMasukController::class, 'index'])->name('barangmasuk');
Route::get('/barangkeluar', [BarangKeluarController::class, 'index'])->name('barangkeluar');
Route::get('/barangrusak', [BarangRusakController::class, 'index'])->name('barangrusak');
Route::get('/stokbarang', [StokBarangController::class, 'index'])->name('stokbarang');
Route::get('/masterdata', [MasterDataController::class, 'index'])->name('masterdata');
Route::get('/suratjalan', [SuratJalanController::class, 'index'])->name('suratjalan');
Route::get('/retur', [ReturController::class, 'index'])->name('retur');
Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
Route::get('/user', [UserController::class, 'index'])->name('user');

 // Routing untuk fitur barang keluar
//  Route::prefix('barangkeluar')->group(function () {
//     Route::get('/create-keluar', [BarangkeluarController::class, 'create'])->name('create-keluar');
//     Route::post('/store-keluar', [BarangkeluarController::class, 'store'])->name('store-keluar');
//     Route::get('/edit-keluar/{id}', [BarangkeluarController::class, 'edit'])->name('edit-keluar');
//     Route::post('/update-keluar/{id}', [BarangkeluarController::class, 'update'])->name('update-keluar');
//     Route::get('/show-keluar/{id}', [BarangkeluarController::class, 'show'])->name('show-keluar');
//     Route::delete('/delete-keluar/{id}', [BarangkeluarController::class, 'destroy'])->name('barangkeluar.destroy');
//     // Route::get('/delete-keluar/{id}', [BarangkeluarController::class, 'destroy'])->name('delete-keluar');
//     Route::get('exportExcel', [BarangkeluarController::class, 'exportExcel'])->name('barangkeluar.exportExcel');
//     Route::get('exportPdf', [BarangkeluarController::class, 'exportPdf'])->name('barangkeluar.exportPdf');
//     Route::get('/barangkeluar/getData', [BarangkeluarController::class, 'getData'])->name('barangkeluar.getData');

// });
