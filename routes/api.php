<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::group(['prefix' => 'v1'], function () {
    Route::post('/sendotp', [AuthController::class, 'index']);
    Route::post('/verifyotp', [AuthController::class, 'store']);
    Route::get('/profile',[AuthController::class,'profile'])->middleware('auth:sanctum');
});


