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
use App\Http\Controllers\UserInventoryController;

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
Route::post('/logout', function () {
    Auth::logout(); // Proses logout
    return redirect('/login'); // Redirect ke halaman login setelah logout
})->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//USER ROUTE
Route::get('/create-user', [UserController::class, 'viewCreateUser'])->name('viewcreate.user');
Route::post('/create-user', [UserController::class, 'createUser'])->name('create.user');

//BARANG MASUK ROUTE
Route::resource('barangmasuk', BarangMasukController::class);
Route::get('/barangmasuk/edit/{itemId}', [BarangMasukController::class, 'edit'])->name('barangmasuk.edit');
Route::post('/barangmasuk/{itemId}/{barangId}/updateStatus', [BarangMasukController::class, 'updateStatus'])->name('barangmasuk.updateStatus');

//BARANG KELUAR ROUTE
Route::resource('/barangkeluar', BarangKeluarController::class);
Route::post('barangkeluar/store-berita-acara', [BarangKeluarController::class, 'storeBeritaAcara'])->name('barangkeluar.storeBeritaAcara');
Route::get('/barangkeluar/berita-acara/{id}', [BarangKeluarController::class, 'buatBeritaAcara'])->name('barangkeluar.createBeritaAcara');
Route::post('/barangkeluar/berita-acara/{id}', [BarangKeluarController::class, 'storeBeritaAcara'])->name('barangkeluar.storeBeritaAcara');
Route::get('/barangkeluar/detail-reguler/{id}', [BarangKeluarController::class, 'showReguler'])->name('barangkeluar.showReguler');
Route::get('/barangkeluar/berita-acara-reguler/{id}', [BarangKeluarController::class, 'buatBeritaAcaraReguler'])->name('barangkeluar.createBeritaAcaraReguler');
Route::post('/barangkeluar/berita-acara-reguler/{id}', [BarangKeluarController::class, 'storeBeritaAcaraReguler'])->name('barangkeluar.storeBeritaAcaraReguler');
Route::get('/barangkeluar/return/{id}', [BarangKeluarController::class, 'returnBarang'])->name('barangkeluar.return');

//STOK BARANG ROUTE
Route::resource('/stokbarang', StokBarangController::class);
Route::get('/stokbarang/hardware/index', [StokBarangController::class, 'hardwareIndex'])->name('stokbarang.hardware.index');
Route::get('/stokbarang/networking/index', [StokBarangController::class, 'networkingIndex'])->name('stokbarang.networking.index');

//RETUR ROUTE
//RETUR UTAMA (PENGAJUAN)
    Route::resource('/retur', ReturController::class);
    // routes/web.php
    Route::get('/retur/create/{barangKeluarId}/{barangId}', [ReturController::class, 'create'])->name('retur.create');
    Route::get('retur/{id}/edit', [ReturController::class, 'edit'])->name('retur.edit');
    Route::put('retur/{id}', [ReturController::class, 'update'])->name('retur.update');
    Route::delete('retur/destroyRetur/{id}', [ReturController::class, 'destroyRetur'])->name('retur.destroyRetur');
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
Route::get('/reports/stokbarang/pdf', [ReportsController::class, 'downloadStokBarangPdf'])->name('reports.stokbarang.pdf');
Route::get('/reports/barangmasuk/pdf', [ReportsController::class, 'downloadBarangMasukPdf'])->name('reports.barangmasuk.pdf');
Route::get('/reports/barangkeluar/pdf', [ReportsController::class, 'downloadBarangKeluarPdf'])->name('reports.barangkeluar.pdf');
Route::get('/reports/returbarang/pdf', [ReportsController::class, 'downloadReturBarangPdf'])->name('reports.returbarang.pdf');




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


//ROUTE PENGGUNA
//Halaman Index
Route::get('/pengguna/index', [App\Http\Controllers\HomeUserController::class, 'index'])->name('pengguna.index');
Route::get('/success', [App\Http\Controllers\HomeUserController::class, 'landing'])->name('pengguna.success');

// Halaman Peminjaman
Route::resource('/userinventory', UserInventoryController::class);
Route::get('/userinventory/create/reguler', [UserInventoryController::class, 'createReguler'])->name('createreguler.index');
Route::post('userinventory/storeuserreguler', [UserInventoryController::class, 'storeReguler'])->name('userinventory.storereguler');
