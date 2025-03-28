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
