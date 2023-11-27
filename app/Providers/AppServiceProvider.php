<?php

namespace App\Providers;

use App\Models\Offer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Observers\OrderActionObserver;
use App\Observers\OrderProcessObserver;
use App\Observers\OfferObserver;
use App\Observers\ProductObserver;
use App\Observers\UserObserver;


class AppServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    Paginator::useBootstrap();
    Schema::defaultStringLength(191);

    Offer::observe(OfferObserver::class);
    Product::observe(ProductObserver::class);
    User::observe(UserObserver::class);
    Order::observe(OrderActionObserver::class);
    Order::observe(OrderProcessObserver::class);


  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    // if ($this->app->environment('local')) {
    //     $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
    //     $this->app->register(TelescopeServiceProvider::class);
    // }
  }
}
