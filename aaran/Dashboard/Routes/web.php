<?php

use Illuminate\Support\Facades\Route;

Route::get('dashboard', \Aaran\Dashboard\Livewire\Class\Index::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
