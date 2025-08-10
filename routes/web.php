<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PersenanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestockProdukController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PerhiasanTuaController;
use App\Http\Controllers\PerhiasanMudaController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/persenan', [PersenanController::class, 'index'])->name('persenan');

    Route::get('/restock-produk', [RestockProdukController::class, 'index'])->name('restock.produk');
    Route::post('/restocks/toggle-status', [RestockProdukController::class, 'toggleStatus'])->name('restocks.toggleStatus');
    Route::post('/restocks/store', [RestockProdukController::class, 'store'])->name('restocks.store');
    Route::delete('/restocks/{id}', [RestockProdukController::class, 'destroy'])->name('restocks.destroy');

    // Route::view('/input-produk', 'input-produk')->name('input.produk');
    
    Route::get('/input-produk', [StockController::class, 'index'])->name('input.produk');
    Route::post('/input-produk', [StockController::class, 'store'])->name('stock.store');
    Route::put('/input-produk/{stock}', [StockController::class, 'update'])->name('stock.update');
    Route::delete('/input-produk/{stock}', [StockController::class, 'destroy'])->name('stock.destroy');
    
    
    Route::prefix('perhiasan-tua')->name('perhiasan.tua.')->group(function () {
        Route::get('/', fn() => redirect()->route('perhiasan.tua.penjualan'));
        Route::get('/penjualan', [PerhiasanTuaController::class, 'penjualan'])->name('penjualan');
        Route::post('/penjualan', [PerhiasanTuaController::class, 'penjualanStore'])->name('penjualan.store');
        Route::put('/penjualan/{id}', [PerhiasanTuaController::class, 'penjualanUpdate'])->name('penjualan.update');
        Route::delete('/penjualan/{id}', [PerhiasanTuaController::class, 'penjualanDestroy'])->name('penjualan.destroy');

        Route::get('/pembelian', [PerhiasanTuaController::class, 'pembelianGet'])->name('pembelian');
        Route::post('/pembelian', [PerhiasanTuaController::class, 'pembelianStore'])->name('pembelian.store');
        Route::put('/pembelian/{id}', [PerhiasanTuaController::class, 'pembelianUpdate'])->name('pembelian.update');
        Route::delete('/pembelian/{id}', [PerhiasanTuaController::class, 'pembelianDestroy'])->name('pembelian.destroy');

        Route::get('/ringkasan', [PerhiasanTuaController::class, 'ringkasan'])->name('ringkasan');
        Route::post('/ringkasan/pengeluaran', [PerhiasanTuaController::class, 'ringkasanPengeluaranStore'])->name('ringkasan.pengeluaran.store');
        Route::put('/ringkasan/pengeluaran/{id}', [PerhiasanTuaController::class, 'ringkasanPengeluaranUpdate'])->name('ringkasan.pengeluaran.update');
        Route::delete('/ringkasan/pengeluaran/{id}', [PerhiasanTuaController::class, 'ringkasanPengeluaranDestroy'])->name('ringkasan.pengeluaran.destroy');

        Route::post('/ringkasan/penjualanLain', [PerhiasanTuaController::class, 'ringkasanPenjualanLainStore'])->name('ringkasan.penjualanLain.store');
        Route::delete('/ringkasan/penjualanLain/{id}', [PerhiasanTuaController::class, 'ringkasanPenjualanLainDestroy'])->name('ringkasan.penjualanLain.destroy');

        Route::post('/ringkasan/pricelist', [PerhiasanTuaController::class, 'ringkasanPricelistStore'])->name('ringkasan.pricelist.store');
        Route::delete('/ringkasan/pricelist/{id}', [PerhiasanTuaController::class, 'ringkasanPricelistDestroy'])->name('ringkasan.pricelist.destroy');
        Route::put('/ringkasan/pricelist/{id}', [PerhiasanTuaController::class, 'ringkasanPricelistUpdate'])->name('ringkasan.pricelist.update');

        Route::get('/gesek', [PerhiasanTuaController::class, 'gesek'])->name('gesek');
        Route::post('/gesek', [PerhiasanTuaController::class, 'gesekStore'])->name('gesek.store');
        Route::delete('/gesek/{id}', [PerhiasanTuaController::class, 'gesekDestroy'])->name('gesek.destroy');

        Route::get('/penjualan-harian/{id}', [PerhiasanTuaController::class, 'penjualanHarian'])->name('penjualanHarian');
    });

    Route::prefix('perhiasan-muda')->name('perhiasan.muda.')->group(function () {
        Route::get('/', fn() => redirect()->route('perhiasan.muda.penjualan'));
        Route::get('/penjualan', [PerhiasanMudaController::class, 'penjualan'])->name('penjualan');
        Route::post('/penjualan', [PerhiasanMudaController::class, 'penjualanStore'])->name('penjualan.store');
        Route::put('/penjualan/{id}', [PerhiasanMudaController::class, 'penjualanUpdate'])->name('penjualan.update');
        Route::delete('/penjualan/{id}', [PerhiasanMudaController::class, 'penjualanDestroy'])->name('penjualan.destroy');

        Route::get('/pembelian', [PerhiasanMudaController::class, 'pembelianGet'])->name('pembelian');
        Route::post('/pembelian', [PerhiasanMudaController::class, 'pembelianStore'])->name('pembelian.store');
        Route::put('/pembelian/{id}', [PerhiasanMudaController::class, 'pembelianUpdate'])->name('pembelian.update');
        Route::delete('/pembelian/{id}', [PerhiasanMudaController::class, 'pembelianDestroy'])->name('pembelian.destroy');

        Route::get('/ringkasan', [PerhiasanMudaController::class, 'ringkasan'])->name('ringkasan');
        Route::post('/ringkasan/pengeluaran', [PerhiasanMudaController::class, 'ringkasanPengeluaranStore'])->name('ringkasan.pengeluaran.store');
        Route::put('/ringkasan/pengeluaran/{id}', [PerhiasanMudaController::class, 'ringkasanPengeluaranUpdate'])->name('ringkasan.pengeluaran.update');
        Route::delete('/ringkasan/pengeluaran/{id}', [PerhiasanMudaController::class, 'ringkasanPengeluaranDestroy'])->name('ringkasan.pengeluaran.destroy');

        Route::post('/ringkasan/penjualanLain', [PerhiasanMudaController::class, 'ringkasanPenjualanLainStore'])->name('ringkasan.penjualanLain.store');
        Route::delete('/ringkasan/penjualanLain/{id}', [PerhiasanMudaController::class, 'ringkasanPenjualanLainDestroy'])->name('ringkasan.penjualanLain.destroy');

        Route::post('/ringkasan/pricelist', [PerhiasanMudaController::class, 'ringkasanPricelistStore'])->name('ringkasan.pricelist.store');
        Route::delete('/ringkasan/pricelist/{id}', [PerhiasanMudaController::class, 'ringkasanPricelistDestroy'])->name('ringkasan.pricelist.destroy');
        Route::put('/ringkasan/pricelist/{id}', [PerhiasanMudaController::class, 'ringkasanPricelistUpdate'])->name('ringkasan.pricelist.update');


        Route::get('/gesek', [PerhiasanMudaController::class, 'gesek'])->name('gesek');
        Route::post('/gesek', [PerhiasanMudaController::class, 'gesekStore'])->name('gesek.store');
        Route::delete('/gesek/{id}', [PerhiasanMudaController::class, 'gesekDestroy'])->name('gesek.destroy');

        Route::get('/penjualan-harian/{id}', [PerhiasanMudaController::class, 'penjualanHarian'])->name('penjualanHarian');
    });


});

require __DIR__.'/auth.php';
