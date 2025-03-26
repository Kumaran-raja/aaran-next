<?php

use Aaran\Core\User\Http\Controllers\LoginController;
use Aaran\Core\User\Http\Controllers\MfaController;
use Aaran\Core\User\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//// Web Routes
//Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
//Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');

//Route::post('mfa/send', [MfaController::class, 'sendMfa'])->name('auth.mfa-send');
//Route::post('mfa/verify', [MfaController::class, 'verifyMfa'])->name('auth.mfa-verify');
//Route::post('mfa/enable', [MfaController::class, 'enableMfa'])->name('auth.mfa-enable');

//
//Route::middleware('web')->group(function () {
//    Route::get('/users', [UserController::class, 'index'])->name('users.index');
//    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
//    Route::post('/users', [UserController::class, 'store'])->name('users.store');
//    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
//    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
//    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
//});
