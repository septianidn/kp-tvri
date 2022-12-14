<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/logout', function(){
    return abort(404);
});
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/api/chart-data', [HomeController::class, 'get'])->name('grafik');
Route::get('/barang', [BarangController::class, 'index'])->name('barang');
Route::get('/barang/get', [BarangController::class, 'get'])->name('/barang/get');

    Route::middleware(['is_admin'])->group(function () {
        Route::post('/barang', [BarangController::class, 'store'])->name('barang/store');
        Route::get('/barang/{id}', [BarangController::class, 'show'])->name('/barang/edit');
        Route::get('/barang/{id}/riwayat-edit', [BarangController::class, 'history'])->name('/barang/history-edit');
        Route::put('/barang/{id}/edit', [BarangController::class, 'update'])->name('/barang/update');
        Route::delete('/barang/{id}/delete', [BarangController::class, 'destroy'])->name('/barang/delete');
    });



    Route::put('/profil/{id}/edit', [App\Http\Controllers\ProfilController::class, 'update'])->name('profil/edit');
    Route::get('/profil/{id}/get', [App\Http\Controllers\ProfilController::class, 'get'])->name('profil/get');
Route::get('/profil', [App\Http\Controllers\ProfilController::class, 'index'])->name('profil');
Route::post('/profil/change-password', [App\Http\Controllers\ProfilController::class, 'changePassword'])->name('edit-password');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/history', [PeminjamanController::class, 'history'])->name('history');
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
Route::get('/peminjaman/get', [PeminjamanController::class, 'get'])->name('peminjaman/get');
Route::get('/peminjaman/detail/{id}', [PeminjamanController::class, 'show'])->name('peminjaman/show');
Route::get('/peminjaman/cetak/{id}', [PeminjamanController::class, 'show'])->name('peminjaman/show');
Route::delete('/peminjaman/{id}/delete', [PeminjamanController::class, 'destroy'])->name('peminjaman/delete');
Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])->name('peminjaman/store');

Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian');
Route::get('/pengembalian/{id}', [PengembalianController::class, 'show'])->name('pengembalian/kembalikan');
Route::post('/pengembalian/store', [PengembalianController::class, 'store'])->name('pengembalian/store');


});
