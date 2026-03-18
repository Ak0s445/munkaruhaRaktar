<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Location;
use App\Policies\CategoryPolicy;
use App\Policies\LocationPolicy;
use App\Policies\ProductPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Product::class, ProductPolicy::class);
		Gate::policy(Category::class, CategoryPolicy::class);
		Gate::policy(Location::class, LocationPolicy::class);
    }
}
