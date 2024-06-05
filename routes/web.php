<?php

use App\Http\Controllers\AddStokProdukController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/admin');
});

Auth::routes();

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::resource('products', ProductController::class);
    Route::get('/product/add_stok', [ProductController::class, 'add_stok'])->name('products.add_stok');

    //laporan tambah stok
    Route::get('/laporan-tambah-stok', [AddStokProdukController::class, 'view_tambah_stok'])->name('laporan.addstok');
    Route::post('/laporan-tambah-stok', [AddStokProdukController::class, 'tambah_stok'])->name('laporan.addstok.post');
    //laporan kurang stok
    Route::get('/laporan-kurang-stok', [AddStokProdukController::class, 'view_kurang_stok'])->name('laporan.kurangstok');
    Route::post('/laporan-kurang-stok', [AddStokProdukController::class, 'kurang_stok'])->name('laporan.kurangstok.post');


    Route::resource('customers', CustomerController::class);

    Route::resource('orders', OrderController::class);
    Route::get('/orders/{id}/cetak-nota', [OrderController::class, 'cetak_nota'])->name('orders.cetak_nota');
    Route::get('/laporan-penjualan', [OrderController::class, 'view_penjualan'])->name('orders.laporan_penjualan');
    Route::post('/laporan-penjualan', [OrderController::class, 'penjualan'])->name('orders.laporan_penjualan.post');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/change-qty', [CartController::class, 'changeQty']);
    Route::delete('/cart/delete', [CartController::class, 'delete']);
    Route::delete('/cart/empty', [CartController::class, 'empty']);


    Route::get('add-stok-produk', [AddStokProdukController::class, 'index'])->name('addstokproduk.index');
    Route::get('add-stok-produk/create', [AddStokProdukController::class, 'create'])->name('addstokproduk.create');
    Route::get('add-stok-produk/{id}/edit', [AddStokProdukController::class, 'edit'])->name('addstokproduk.edit');
    Route::put('add-stok-produk/{id}', [AddStokProdukController::class, 'update'])->name('addstokproduk.update');
    Route::post('add-stok-produk', [AddStokProdukController::class, 'store'])->name('addstokproduk.store');
    Route::delete('add-stok-produk/{id}', [AddStokProdukController::class, 'destroy'])->name('addstokproduk.destroy');


    // Transaltions route for React component
    Route::get('/locale/{type}', function ($type) {
        $translations = trans($type);
        return response()->json($translations);
    });
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');