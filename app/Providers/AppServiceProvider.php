<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Location;
use App\Models\User;
use App\Observers\CategoryObserver;
use App\Observers\LocationObserver;
use App\Observers\ProductObserver;
use App\Policies\CategoryPolicy;
use App\Policies\LocationPolicy;
use App\Policies\ProductPolicy;
use App\Policies\UserPolicy;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

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
		Gate::policy(User::class, UserPolicy::class);

        Product::observe(ProductObserver::class);
        Category::observe(CategoryObserver::class);
        Location::observe(LocationObserver::class);

        Event::listen(Attempting::class, function (Attempting $event) {
            Log::channel('auth')->info('login_attempt', [
                'email' => $event->credentials['email'] ?? null,
                'ip' => request()?->ip(),
            ]);
        });

        Event::listen(Failed::class, function (Failed $event) {
            Log::channel('auth')->warning('login_failed', [
                'email' => $event->credentials['email'] ?? null,
                'ip' => request()?->ip(),
            ]);
        });

        Event::listen(Login::class, function (Login $event) {
            Log::channel('auth')->info('login_success', [
                'user_id' => $event->user?->id,
                'role' => $event->user?->role,
                'ip' => request()?->ip(),
            ]);
        });

        Event::listen(Logout::class, function (Logout $event) {
            Log::channel('auth')->info('logout', [
                'user_id' => $event->user?->id,
                'role' => $event->user?->role,
                'ip' => request()?->ip(),
            ]);
        });

        Event::listen(Registered::class, function (Registered $event) {
            Log::channel('auth')->info('register', [
                'user_id' => $event->user?->id,
                'email' => $event->user?->email,
                'role' => $event->user?->role,
                'ip' => request()?->ip(),
            ]);
        });
    }
}
