<?php

use Aaran\Core\User\Http\Controllers\LoginController;
use Aaran\Core\User\Http\Controllers\MfaController;
use Aaran\Core\User\Http\Controllers\UserApiController;
use Illuminate\Support\Facades\Route;

//// API Routes
//Route::prefix('v1')->group(function () {
//
//    Route::post('/login', [LoginController::class, 'login'])->name('api.v1.auth.login');
//    Route::post('/logout', [LoginController::class, 'logout'])->name('api.v1.auth.logout');
//
//    Route::post('mfa/send', [MfaController::class, 'sendMfa'])->name('api.auth.mfa-send');
//    Route::post('mfa/verify', [MfaController::class, 'verifyMfa'])->name('api.auth.mfa-verify');
//    Route::post('mfa/enable', [MfaController::class, 'enableMfa'])->name('api.auth.mfa-enable');
//});
//
//
//Route::middleware('api')->prefix('v1')->group(function () {
//    Route::get('/users', [UserApiController::class, 'index']);
//    Route::post('/users', [UserApiController::class, 'store']);
//    Route::get('/users/{user}', [UserApiController::class, 'show']);
//    Route::put('/users/{user}', [UserApiController::class, 'update']);
//    Route::delete('/users/{user}', [UserApiController::class, 'destroy']);
//});

