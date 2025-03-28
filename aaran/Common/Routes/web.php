<?php

use Illuminate\Support\Facades\Route;

//Common
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/cities', Aaran\Common\Livewire\Class\CityList::class)->name('cities');
    Route::get('/states', Aaran\Common\Livewire\Class\StateList::class)->name('states');
    Route::get('/countries', Aaran\Common\Livewire\Class\CountryList::class)->name('countries');
    Route::get('/pincodes', Aaran\Common\Livewire\Class\PincodeList::class)->name('pincodes');
    Route::get('/accountType', Aaran\Common\Livewire\Class\AccountTypeList::class)->name('accountType');


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
