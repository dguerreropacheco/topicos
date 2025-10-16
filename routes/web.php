<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;

Route::middleware(['web'])->group(function () {
    Route::resource('vehicles', VehicleController::class);

    // AJAX: modelos por marca (JSON)
    Route::get('/ajax/brands/{brand}/models', [VehicleController::class,'modelsByBrand'])
        ->name('ajax.brand.models');
});
