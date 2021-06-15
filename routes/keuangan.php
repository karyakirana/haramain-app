<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function(){

    Route::get('/keuangan/kategoriakun', [App\Http\Controllers\Keuangan\KategoriAkunController::class, 'index']);

});
