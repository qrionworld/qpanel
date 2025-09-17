<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContentApiController;

Route::prefix('contents')->group(function () {
    Route::get('/', [ContentApiController::class, 'index']);      // GET all
    Route::get('/{id}', [ContentApiController::class, 'show']);   // GET by ID
    Route::post('/', [ContentApiController::class, 'store']);     // CREATE
    Route::put('/{id}', [ContentApiController::class, 'update']); // UPDATE
    Route::delete('/{id}', [ContentApiController::class, 'destroy']); // DELETE
});

