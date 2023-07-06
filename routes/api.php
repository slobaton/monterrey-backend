<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClothSizeController;
use App\Http\Controllers\EffectController;
use App\Http\Controllers\ClothTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WashTypeController;
use App\Http\Controllers\WashOrderController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('wash-types', WashTypeController::class);
    Route::apiResource('effects', EffectController::class);
    Route::apiResource('cloth-types', ClothTypeController::class);
    Route::apiResource('cloth-sizes', ClothSizeController::class);
    Route::apiResource('wash-orders', WashOrderController::class);
});
