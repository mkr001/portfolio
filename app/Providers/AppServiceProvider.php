<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\Models\Contact;
use App\Models\Callback;

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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        View::composer('admin.*', function ($view) {
            $view->with('unreadContactsCount', Contact::where('is_read', false)->count());
            $view->with('unreadCallbacksCount', Callback::where('is_read', false)->count());
        });
    }
}
