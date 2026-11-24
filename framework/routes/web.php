<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// >>> [M4-KATALOG] START
Route::middleware(['auth'])->group(function () {
    Route::get('/barang', [\App\Http\Controllers\Katalog\ItemController::class, 'index'])->name('items.index');
    Route::get('/barang/{item}', [\App\Http\Controllers\Katalog\ItemController::class, 'show'])->name('items.show');
});
// <<< [M4-KATALOG] END
