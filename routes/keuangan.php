<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function(){

    Route::get('/keuangan/kategoriakun', [App\Http\Controllers\Keuangan\KategoriAkunController::class, 'index']);
    Route::patch('/keuangan/kategoriakun', [App\Http\Controllers\Keuangan\KategoriAkunController::class, 'kategoriAkunList'])
        ->name('kategoriAkunList');
    Route::post('/keuangan/kategoriakun', [\App\Http\Controllers\Keuangan\KategoriAkunController::class, 'store'])
        ->name('kategoriAkunStore');
    Route::get('/keuangan/kategoriakun/{id}', [\App\Http\Controllers\Keuangan\KategoriAkunController::class, 'edit']);
    Route::delete('/keuangan/kategoriakun/{id}', [\App\Http\Controllers\Keuangan\KategoriAkunController::class, 'destroy']);


});
