<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PartnerService;
use App\Services\ProductService;
use App\Services\OrderService;
use App\Services\CartService;
use App\Services\InterviewService;
use App\Services\InvoiceService;

use App\Models\Partner;
use App\Observers\PartnerObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
