<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function(){

    Route::get('/stock/daftargudang', [\App\Http\Controllers\Stock\BranchStockController::class, 'index']);
    Route::patch('/stock/daftargudang', [\App\Http\Controllers\Stock\BranchStockController::class, 'branchStockList']);
    Route::post('/stock/daftargudang', [\App\Http\Controllers\Stock\BranchStockController::class, 'store']);
    Route::get('/stock/daftargudang/{id}', [\App\Http\Controllers\Stock\BranchStockController::class, 'edit']);
    Route::delete('/stock/daftargudang/{id}', [\App\Http\Controllers\Stock\BranchStockController::class, 'destroy']);

    Route::get('/stock/daftarmasuk', [\App\Http\Controllers\Stock\StockMasukController::class, 'index']);
    Route::patch('/stock/daftarmasuk', [\App\Http\Controllers\Stock\StockMasukController::class, 'stockMasukList']);

    // transaction
    Route::get('/stock/transaksi', [App\Http\Controllers\Stock\StockMasukController::class, 'create']);
    Route::get('/stock/transaksi/{id}/edit', [App\Http\Controllers\Stock\StockMasukController::class, 'edit']);
    Route::post('/stock/transaksi', [App\Http\Controllers\Stock\StockMasukController::class, 'store'])
        ->name('simpanStockMasuk');
    Route::patch('/stock/transaksiproduk', [App\Http\Controllers\Stock\StockMasukController::class, 'produkList']); // list produk
    Route::get('/stock/transaksi/setproduk/{id}', [App\Http\Controllers\Stock\StockMasukController::class, 'setProduk']); // set produk to form
    Route::patch('/stock/transaksisupplier', [App\Http\Controllers\Stock\StockMasukController::class, 'supplierList']); // list supplier
    Route::get('/stock/transaksi/setsupplier/{id}', [App\Http\Controllers\Stock\StockMasukController::class, 'setSupplier']); // set produk to form

    // temporary
    Route::patch('/stock/temp/detil/{id}', [\App\Http\Controllers\Stock\StockTempController::class, 'detilTempList']); // list stock temp
    Route::get('/stock/temp/detil/{id}', [\App\Http\Controllers\Stock\StockTempController::class, 'edit']); // edit stock temp
    Route::delete('/stock/temp/detil/{id}', [\App\Http\Controllers\Stock\StockTempController::class, 'destroy']); // delete stock temp
    Route::post('/stock/temp/detil', [\App\Http\Controllers\Stock\StockTempController::class, 'store']);// store detiltemp

    // inventory
    Route::get('/inventory/refresh', [\App\Http\Controllers\Stock\InventoryController::class, 'index']);
    Route::patch('/inventory/refresh', [\App\Http\Controllers\Stock\InventoryController::class, 'inventoyList']);
    Route::put('/inventory/refresh', [\App\Http\Controllers\Stock\InventoryController::class, 'addStockFromLast']);
    Route::put('/inventory/refresh/fromstockmasuk', [\App\Http\Controllers\Stock\InventoryController::class, 'addStockFromGudang']);


});
