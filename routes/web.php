<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MasterDataController;
// use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\StokBarangController;
use App\Http\Controllers\SuratJalanController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangRusakController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\NotificationController;

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

Auth::routes();
Route::redirect('/', '/login');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('barangmasuk', BarangMasukController::class);


Route::resource('/barangkeluar', BarangKeluarController::class);


Route::resource('/barangrusak', BarangRusakController::class);
Route::get('/barangrusak/{id}', [BarangRusakController::class, 'show'])->name('barangrusak.show');


//Route Stok Barang
Route::resource('/stokbarang', StokBarangController::class);
Route::get('/stokbarang/hardware/index', [StokBarangController::class, 'hardwareIndex'])->name('stokbarang.hardware.index');
Route::get('/stokbarang/networking/index', [StokBarangController::class, 'networkingIndex'])->name('stokbarang.networking.index');


Route::resource('/masterdata', MasterDataController::class);
Route::get('/masterdata/{id}', [MasterDataController::class, 'show'])->name('masterdata.show');


Route::resource('/suratjalan', SuratJalanController::class);



Route::resource('/retur', ReturController::class);


// Rute untuk reports
Route::resource('/reports', ReportsController::class);
Route::get('/reports/barangkeluar/index', [ReportsController::class, 'indexbarangkeluar'])->name('indexbarangkeluar');
Route::get('/reports/barangmasuk/index', [ReportsController::class, 'indexbarangmasuk'])->name('indexbarangmasuk');
Route::get('/reports/barangrusak/index', [ReportsController::class, 'indexbarangrusak'])->name('indexbarangrusak');
Route::get('/reports/requesteditem/index', [ReportsController::class, 'indexrequesteditem'])->name('indexrequesteditem');



Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications/destroy-all', [NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');
    Route::post('/notifications/bulk-mark-as-read', [NotificationController::class, 'bulkMarkAsRead'])->name('notifications.bulkMarkAsRead');
    Route::post('/notifications/bulk-delete', [NotificationController::class, 'bulkDelete'])->name('notifications.bulkDelete');
});


Route::resource('/user', UserController::class);
