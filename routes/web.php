<?php

use App\Http\Controllers\CartridgeController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrinterController;
use Illuminate\Support\Facades\Route;


Route::get('/', HomeController::class);

Route::post('cartridge/{id}/update', [CartridgeController::class, 'update'])->name('cartridge.update');
Route::get('cartridges', [CartridgeController::class, 'index']);

Route::get('colors', [ColorController::class, 'index']);

Auth::routes();

