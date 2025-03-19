<?php
use Illuminate\Support\Facades\Route;

Route::prefix('Tenant')->group(function () {

    Route::post('/tenants', [\Aaran\Core\Tenant\Http\Controllers\TenantController::class, 'store']);
});


Route::middleware(['auth', 'tenant'])->group(function () {

    Route::get('/tenant-dashboard', \Aaran\Core\Tenant\Livewire\Class\TenantDashboard::class)->name('tenant.dashboard');

});
