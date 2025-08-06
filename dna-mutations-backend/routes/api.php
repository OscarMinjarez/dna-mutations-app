<?php

use App\Http\Controllers\Api\DnaMutationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/mutation', [DnaMutationController::class, 'checkMutation']);
Route::get('/stats', [DnaMutationController::class, 'stats']);
Route::get('/stats/all', [DnaMutationController::class, 'all']);
