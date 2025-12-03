<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('task')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\TaskController::class, 'index']);
    Route::post('/', [\App\Http\Controllers\Api\TaskController::class, 'store']);
    Route::get('/{task}', [\App\Http\Controllers\Api\TaskController::class, 'show']);
    Route::put('/{task}', [\App\Http\Controllers\Api\TaskController::class, 'update']);
    Route::delete('/{task}', [\App\Http\Controllers\Api\TaskController::class, 'destroy']);
});
