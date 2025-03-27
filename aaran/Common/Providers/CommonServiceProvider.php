<?php

namespace Aaran\Common\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

use Aaran\Common\Livewire\Class; // Example


class CommonServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Common';
    protected string $moduleNameLower = 'common';

    public function register(): void
    {
        $this->app->register(CommonRouteServiceProvider::class);
//        $this->loadConfigs();
        $this->loadViews();
    }

    public function boot(): void
    {
        $this->loadMigrations();
//        $this->mapApiRoutes();
//        $this->mapWebRoutes();

        // Register Livewire components
        Livewire::component('common::city-list', Class\CityList::class);
//        Livewire::component('common::state-list', State\StateList::class);
//        Livewire::component('common::pincode-list', Pincode\PincodeList::class);
//        Livewire::component('common::country-list', Country\CountryList::class);
          Livewire::component('common::hsncode-list', Class\HsncodeList::class);
//        Livewire::component('common::unit-list', Unit\UnitList::class);
//        Livewire::component('common::category-list', Category\CategoryList::class);
//        Livewire::component('common::colour-list', Colour\ColourList::class);
//        Livewire::component('common::size-list', Size\SizeList::class);
//        Livewire::component('common::department-list', Department\DepartmentList::class);
//        Livewire::component('common::transport-list', Transport\TransportList::class);
//        Livewire::component('common::bank-list', Bank\BankList::class);
          Livewire::component('common::gst-list', Class\GstList::class);
          Livewire::component('common::receipt-type-list', Class\ReceiptTypeList::class);
          Livewire::component('common::dispatch-list', Class\DispatchList::class);
//        Livewire::component('common::contact-type-list', ContactType\ContactTypeList::class);
          Livewire::component('common::payment-mode-list', Class\PaymentModeList::class);
//        Livewire::component('common::account-type-list', AccountType\AccountTypeList::class);
//        Livewire::component('common::transaction-type-list', TransactionType\TransactionTypeList::class);

    }

    protected function loadConfigs(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config.php', $this->moduleNameLower);
    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', $this->moduleNameLower);
    }

    protected function loadMigrations(): void
    {

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
//
//    protected function mapWebRoutes()
//    {
//        Route::middleware('web')
//            ->prefix($this->moduleNameLower)
//            ->namespace("Modules\\{$this->moduleName}\\Http\\Controllers")
//            ->group(__DIR__ . '/../Routes/web.php');
//    }
//
//    protected function mapApiRoutes()
//    {
//        Route::prefix('api')
//            ->middleware('api')
//            ->namespace("Modules\\{$this->moduleName}\\Http\\Controllers")
//            ->group(__DIR__ . '/../Routes/api.php'); // Optional API routes
//    }

}
