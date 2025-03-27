<?php

use Illuminate\Support\Facades\Route;

//Common
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/cities', Aaran\Common\Livewire\Class\CityList::class)->name('cities');


});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/banks', Aaran\Common\Livewire\Class\BankList::class)->name('banks');


});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/categories', Aaran\Common\Livewire\Class\CategoryList::class)->name('categories');


});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/colour-list', Aaran\Common\Livewire\Class\ColourList::class)->name('colours');


});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/contact-type', Aaran\Common\Livewire\Class\ContactTypeList::class)->name('contact_types');


});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/departments', Aaran\Common\Livewire\Class\DepartmentList::class)->name('departments');


});
