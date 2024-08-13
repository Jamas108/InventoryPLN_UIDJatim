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
// Route::put('/barangmasuk/updateStatus/{id}', [BarangMasukController::class, 'updateStatus'])->name('barangmasuk.updateStatus');
Route::get('/barangmasuk/edit/{noSurat}', [BarangMasukController::class, 'edit'])->name('barangmasuk.edit');
Route::put('/barangmasuk/update/{noSurat}', [BarangMasukController::class, 'update'])->name('barangmasuk.update');
Route::put('/barangmasuk/{id}/update-status', [BarangMasukController::class, 'updateStatus'])->name('barangmasuk.updateStatus');
Route::put('/barangmasuk/update-status-ajax', [BarangMasukController::class, 'updateStatusAjax'])->name('barangmasuk.updateStatusAjax');





//BARANG KELUAR ROUTE
Route::resource('/barangkeluar', BarangKeluarController::class);
Route::get('/barangkeluar/all/index', [BarangKeluarController::class, 'allIndex'])->name('barangkeluar.all.index');
//BARANG KELUAR REGULER
Route::get('/barangkeluar/reguler/index', [BarangKeluarController::class, 'regulerIndex'])->name('barangkeluar.reguler.index');
Route::get('/barangkeluar/reguler/create', [BarangKeluarController::class, 'createReguler'])->name('barangkeluar.reguler.create');
Route::post('/barangkeluar/reguler/store', [BarangKeluarController::class, 'storeReguler'])->name('barangkeluar.reguler.store');
Route::get('/barangkeluar/{Kode_BarangKeluar}/buat-berita-acara-reguler', [BarangKeluarController::class, 'buatBeritaAcaraReguler'])->name('barangkeluar.buat-berita-acara-reguler');
Route::post('barangkeluar/store-berita-acara-reguler', [BarangKeluarController::class, 'storeBeritaAcaraReguler'])->name('barangkeluar.storeBeritaAcaraReguler');
//BARANG KELUAR INSIDENTIL
Route::get('/barangkeluar/insidentil/index', [BarangKeluarController::class, 'insidentilIndex'])->name('barangkeluar.insidentil.index');
Route::get('/barangkeluar/insidentil/create', [BarangKeluarController::class, 'createInsidentil'])->name('barangkeluar.insidentil.create');
Route::post('/barangkeluar/insidentil/store', [BarangKeluarController::class, 'storeInsidentil'])->name('barangkeluar.insidentil.store');
Route::get('/barangkeluar/{Kode_BarangKeluar}/buat-berita-acara-insidentil', [BarangKeluarController::class, 'buatBeritaAcaraInsidentil'])->name('barangkeluar.buat-berita-acara-insidentil');
Route::post('barangkeluar/store-berita-acara', [BarangKeluarController::class, 'storeBeritaAcara'])->name('barangkeluar.storeBeritaAcara');
Route::get('barangkeluar/buat-berita-acara-insidentil/{id}', [BarangKeluarController::class, 'storeBeritaAcara'])->name('barangkeluar.buat-berita-acara-insidentil');





Route::resource('/barangrusak', BarangRusakController::class);
Route::get('/barangrusak/{id}', [BarangRusakController::class, 'show'])->name('barangrusak.show');


//Route Stok Barang
Route::resource('/stokbarang', StokBarangController::class);
Route::get('/stokbarang/hardware/index', [StokBarangController::class, 'hardwareIndex'])->name('stokbarang.hardware.index');
Route::get('/stokbarang/networking/index', [StokBarangController::class, 'networkingIndex'])->name('stokbarang.networking.index');


Route::resource('/masterdata', MasterDataController::class);
Route::get('/masterdata/{id}', [MasterDataController::class, 'show'])->name('masterdata.show');

Route::get('/master-data', [MasterDataController::class, 'index'])->name('master-data.index');



Route::resource('/suratjalan', SuratJalanController::class);

//RUTE UNTUK RETUR
Route::resource('/retur', ReturController::class);
Route::get('/retur/bergaransi/index', [ReturController::class, 'bergaransiIndex'])->name('retur.bergaransi.index');
Route::get('/retur/handal/index', [ReturController::class, 'handalIndex'])->name('retur.handal.index');


// Rute untuk reports
// Resource route untuk reports
Route::resource('/reports', ReportsController::class);

// Rute untuk berbagai laporan
Route::get('/reports/barangkeluar/index', [ReportsController::class, 'indexBarangKeluar'])->name('indexbarangkeluar');
Route::get('/reports/barangmasuk/index', [ReportsController::class, 'indexBarangMasuk'])->name('indexbarangmasuk');
Route::get('/reports/barangrusak/index', [ReportsController::class, 'indexBarangRusak'])->name('reports.barangrusak.index');
Route::get('/reports/requesteditem/index', [ReportsController::class, 'indexRequestedItem'])->name('reports.requesteditem.index');

// Rute untuk mengekspor laporan ke PDF
Route::get('/reports/barangmasuk/pdf', [ReportsController::class, 'exportPdfBarangMasuk'])->name('reports.barangmasuk.pdf');
Route::get('/reports/barangkeluar/pdf', [ReportsController::class, 'exportPdfBarangKeluar'])->name('reports.barangkeluar.pdf');
Route::get('/reports/barangrusak/pdf', [ReportsController::class, 'exportPdfBarangRusak'])->name('reports.exportPdfBarangRusak');
Route::get('/reports/requesteditem/pdf', [ReportsController::class, 'exportPdfRequestedItem'])->name('reports.exportPdfRequestedItem');



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
Route::get('/users', [UserController::class, 'index']);
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::post('/user/{id}/update', [UserController::class, 'update'])->name('user.update');
