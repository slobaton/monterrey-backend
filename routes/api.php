<?php

use App\Http\Controllers\AccountMovementController;
use App\Http\Controllers\ChargeParameterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientEffectPriceController;
use App\Http\Controllers\ClientParameterPriceController;
use App\Http\Controllers\ClientWashTypePriceController;
use App\Http\Controllers\EffectController;
use App\Http\Controllers\WashTypeController;
use App\Http\Controllers\ClothSizeController;
use App\Http\Controllers\ClothTypeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WashOrderController;
use App\Http\Controllers\WashOrderDetailController;
use App\Http\Controllers\UserPasswordController;

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
    Route::post('/user/{user}/assign-roles', [UserRoleController::class, 'assignRoles']);
    Route::get('/user/{user}/roles', [UserRoleController::class, 'getUserRoles']);
    Route::get('/roles', RoleController::class);
    Route::post('/users/update-password', [UserPasswordController::class, 'updatePassword']);

    Route::apiResource('clients', ClientController::class);
    Route::get('clients/{client}/wash-types', [ClientController::class, 'getWashTypes']);
    Route::get('clients/{client}/effects', [ClientController::class, 'getEffects']);
    Route::get('clients/{client}/parameters', [ClientController::class, 'getParameters']);
    Route::get('clients/{client}/movements', [ClientController::class, 'getAccountMovements']);
    Route::post('clients/{client}/payment', [ClientController::class, 'addPaymentMovement']);
    Route::post('clients/{client}/discount', [ClientController::class, 'addDiscountMovement']);

    Route::apiResource('wash-types', WashTypeController::class);
    Route::apiResource('effects', EffectController::class);
    Route::apiResource('cloth-types', ClothTypeController::class);
    Route::apiResource('cloth-sizes', ClothSizeController::class);

    Route::apiResource('wash-orders', WashOrderController::class)
        ->parameters(['wash-orders' => 'order']);
    Route::post('wash-orders/{washOrder}/approve', [WashOrderController::class, 'approveOrder']);

    Route::apiResource('wash-order-details', WashOrderDetailController::class)
        ->parameters(['wash-order-details' => 'washOrderDetail']);
    Route::post('wash-order-details/calculate', [WashOrderDetailController::class, 'calculatePrices']);

    Route::controller(ClientWashTypePriceController::class)->group(function () {
        Route::get('clients/{client}/wash-types/{washTypeId}/prices/{id}', 'getPriceById');
        Route::post('clients/{client}/wash-types/{washType}/prices', 'assignPrice');
        Route::patch('clients/{client}/wash-types/{washType}/prices/{id}', 'updatePrice');
        Route::delete('clients/{clientId}/wash-types/{washTypeId}/prices/{id}', 'deletePrice');
    });

    Route::controller(ClientEffectPriceController::class)->group(function () {
        Route::get('clients/{client}/effects/{effectId}/prices/{id}', 'getPriceById');
        Route::post('clients/{client}/effects/{effect}/prices', 'assignPrice');
        Route::patch('clients/{client}/effects/{effect}/prices/{id}', 'updatePrice');
        Route::delete('clients/{clientId}/effects/{effectId}/prices/{id}', 'deletePrice');
    });

    Route::controller(ClientParameterPriceController::class)->group(function () {
        Route::get('clients/{client}/parameters/{parameterId}/prices/{id}', 'getPriceById');
        Route::post('clients/{client}/parameters/{parameter}/prices', 'assignPrice');
        Route::patch('clients/{client}/parameters/{parameter}/prices/{id}', 'updatePrice');
        Route::delete('clients/{clientId}/parameters/{parameterId}/prices/{id}', 'deletePrice');
    });

    Route::controller(ChargeParameterController::class)->group(function () {
        Route::get('parameters', 'index');
        Route::get('parameters/{parameter}', 'show');
        Route::patch('parameters/{parameter}', 'update');
    });

    Route::controller(AccountMovementController::class)->group(function () {
        Route::get('account-movements/{movement}', 'getMovementById');
    });

    Route::controller(ReportController::class)->group(function () {
        Route::get('reports/general-count', 'generalReportCount');
    });

    // Get authorization hash key
    Route::get('auth/key', [LoginController::class, 'getPublicKey']);
});


Route::controller(ReportController::class)
    ->middleware('auth.publicKey')
    ->group(function () {
        Route::get('reports/washOrder/{washOrderId}', [ReportController::class, 'washOrderReport']);
    });
