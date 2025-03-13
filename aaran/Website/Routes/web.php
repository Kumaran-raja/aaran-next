<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \Aaran\Website\Livewire\Class\Index::class)->name('home');
