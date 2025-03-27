<?php

use Illuminate\Support\Facades\Route;

//Common
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/cities', Aaran\Common\Livewire\Class\CityList::class)->name('cities');
    Route::get('/dispatch', Aaran\Common\Livewire\Class\DispatchList::class)->name('dispatch');
    Route::get('/gst_percents', Aaran\Common\Livewire\Class\GstList::class)->name('gst_percents');
    Route::get('/hsn_code', Aaran\Common\Livewire\Class\HsncodeList::class)->name('hsn_code');
    Route::get('/payment_mode', Aaran\Common\Livewire\Class\PaymentModeList::class)->name('payment_mode');
    Route::get('/receipt_type', Aaran\Common\Livewire\Class\ReceiptTypeList::class)->name('receipt_type');
});
