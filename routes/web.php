<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\RacikanController;

// Route untuk resep - diatur dengan urutan yang tepat
Route::get('/reseps', [ResepController::class, 'index'])->name('reseps.index');
Route::get('/reseps/create', [ResepController::class, 'create'])->name('reseps.create');

// Route untuk form
Route::get('/reseps/form/nonracikan', [ResepController::class, 'formNonracikan'])->name('reseps.form.nonracikan');
Route::get('/reseps/form/racikan', [ResepController::class, 'formRacikan'])->name('reseps.form.racikan');

// Route untuk store
Route::post('/reseps/store-nonracikan', [ResepController::class, 'storeNonracikan'])->name('reseps.storeNonRacikan');
Route::post('/reseps/store-racikan', [ResepController::class, 'storeRacikan'])->name('reseps.storeRacikan');

// Route untuk draft
Route::post('/reseps/simpan', [ResepController::class, 'simpanDraft'])->name('reseps.simpan');
Route::delete('/reseps/remove-draft/{index}', [ResepController::class, 'removeDraft'])->name('reseps.removeDraft');
Route::post('/reseps/batal', [ResepController::class, 'batal'])->name('reseps.batal');

// Route detail
Route::prefix('racikan')->name('racikan.')->group(function () {
    Route::get('detail/{resepDetailId}', [RacikanController::class, 'getDetail'])->name('detail');
    Route::post('store/{resepDetailId}', [RacikanController::class, 'storeDetail'])->name('store');
    Route::get('obat-list', [RacikanController::class, 'getObatList'])->name('obat-list');
});

// Route untuk CRUD resep - harus di bawah route spesifik
Route::get('/reseps/{id}', [ResepController::class, 'show'])->name('reseps.show');
Route::delete('/reseps/{id}', [ResepController::class, 'destroy'])->name('reseps.destroy');

// Route untuk hapus detail resep (AJAX)
Route::delete('/reseps/detail/{id}', [ResepController::class, 'destroyDetail'])->name('reseps.detail.destroy');