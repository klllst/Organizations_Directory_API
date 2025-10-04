<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\BuildingController;
use App\Http\Controllers\Api\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::middleware('api.key')->group(function () {
    Route::prefix('organizations')->name('organizations.')->group(function () {
        Route::get('/', [OrganizationController::class, 'index'])->name('index');
        Route::get('/in-radius', [OrganizationController::class, 'inRadius'])->name('in-radius');
        Route::get('/in-rectangle', [OrganizationController::class, 'inRectangle'])->name('in-rectangle');
        Route::get('{organization}}', [OrganizationController::class, 'show'])->name('show');
    });

    Route::prefix('buildings')->name('buildings.')->group(function () {
        Route::get('/in-radius', [BuildingController::class, 'inRadius'])->name('in-radius');
        Route::get('/in-rectangle', [BuildingController::class, 'inRectangle'])->name('in-rectangle');
    });

    Route::prefix('activities')->name('activities.')->group(function () {
        Route::get('{activity}/organizations', [ActivityController::class, 'getOrganizations'])
            ->name('organizations');
    });
});
