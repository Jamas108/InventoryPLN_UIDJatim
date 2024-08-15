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

//USER ROUTE
Route::get('/create-user', [UserController::class, 'viewCreateUser'])->name('viewcreate.user');
Route::post('/create-user', [UserController::class, 'createUser'])->name('create.user');

//BARANG MASUK ROUTE
Route::resource('barangmasuk', BarangMasukController::class);
Route::get('/barangmasuk/edit/{noSurat}', [BarangMasukController::class, 'edit'])->name('barangmasuk.edit');
Route::put('/barangmasuk/update/{noSurat}', [BarangMasukController::class, 'update'])->name('barangmasuk.update');
Route::post('/barangmasuk/{id}/updateStatus', [BarangMasukController::class, 'updateStatus'])->name('barangmasuk.updateStatus');
Route::put('/barangmasuk/update-status-ajax', [BarangMasukController::class, 'updateStatusAjax'])->name('barangmasuk.updateStatusAjax');

//BARANG KELUAR ROUTE
Route::resource('/barangkeluar', BarangKeluarController::class);
Route::post('barangkeluar/store-berita-acara', [BarangKeluarController::class, 'storeBeritaAcara'])->name('barangkeluar.storeBeritaAcara');
Route::get('/barangkeluar/berita-acara/{id}', [BarangKeluarController::class, 'buatBeritaAcara'])->name('barangkeluar.createBeritaAcara');
Route::post('/barangkeluar/berita-acara/{id}', [BarangKeluarController::class, 'storeBeritaAcara'])->name('barangkeluar.storeBeritaAcara');

//STOK BARANG ROUTE
Route::resource('/stokbarang', StokBarangController::class);
Route::get('/stokbarang/hardware/index', [StokBarangController::class, 'hardwareIndex'])->name('stokbarang.hardware.index');
Route::get('/stokbarang/networking/index', [StokBarangController::class, 'networkingIndex'])->name('stokbarang.networking.index');

//RETUR ROUTE
//RETUR UTAMA (PENGAJUAN)
Route::resource('/retur', ReturController::class);
Route::get('retur/{id}/edit', [ReturController::class, 'edit'])->name('retur.edit');
Route::put('retur/{id}', [ReturController::class, 'update'])->name('retur.update');
Route::get('/retur/{id}/showImage', [ReturController::class, 'showImage'])->name('retur.showImage');
Route::get('/retur/{id}/showSuratJalan', [ReturController::class, 'showSuratJalan'])->name('retur.showSuratJalan');
//RETUR KATEGORI HANDAL
Route::get('/retur/handal/index', [ReturController::class, 'indexHandal'])->name('returhandal.index');
//RETUR KATEGORI RUSAK
Route::get('/retur/rusak/index', [ReturController::class, 'indexRusak'])->name('returrusak.index');
//RETUR KATEGORI BERGARANSI
Route::get('/retur/bergaransi/index', [ReturController::class, 'indexBergaransi'])->name('returbergaransi.index');





Route::resource('/barangrusak', BarangRusakController::class);
Route::get('/barangrusak/{id}', [BarangRusakController::class, 'show'])->name('barangrusak.show');

Route::resource('/masterdata', MasterDataController::class);
Route::get('/masterdata/{id}', [MasterDataController::class, 'show'])->name('masterdata.show');

Route::get('/master-data', [MasterDataController::class, 'index'])->name('master-data.index');



Route::resource('/suratjalan', SuratJalanController::class);



// Rute untuk reports
// Resource route untuk reports
Route::resource('/reports', ReportsController::class);


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
