<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['website'])->group(function () {

    Route::get('/ff', \Aaran\Website\Livewire\Class\Index::class)->name('home');

    Route::get('/about', \Aaran\Website\Livewire\Class\About::class)->name('about');
});
