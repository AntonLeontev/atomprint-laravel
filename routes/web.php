<?php

use App\Http\Controllers\CartridgeController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PricelistController;
use App\Http\Controllers\PrinterController;
use App\Models\Cartridge;
use Illuminate\Support\Facades\Route;


Route::get('/', HomeController::class);

Route::post('cartridges/{cartridge}/update', [CartridgeController::class, 'update'])->name('cartridge.update');
Route::get('cartridges', [CartridgeController::class, 'index'])->name('cartridges.index');

Route::get('colors', [ColorController::class, 'index']);

Route::post('pricelists/load', [PricelistController::class, 'upload'])->name('pricelists.upload');
Route::get('pricelists/download', [PricelistController::class, 'download'])->name('pricelists.download');

Auth::routes();
