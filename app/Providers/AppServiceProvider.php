<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if (!app()->runningInConsole()) {
            //
            try {
                if (!Schema::hasTable('settings')) {
                    $currentRoute = $this->app->request->getRequestUri();
                    if (!str_contains($currentRoute, "/install")) {
                        redirect("install")->send();
                    }
                }
            } catch (\Exception $ex) {
                //
                $currentRoute = $this->app->request->getRequestUri();
                if (!str_contains($currentRoute, "/install")) {
                    redirect("install")->send();
                }
            }
        }

        try {
            if (Schema::hasTable('settings')) {
                date_default_timezone_set(setting('timeZone', 'UTC'));
                app()->setLocale(setting('localeCode', 'en'));
            } else {
                date_default_timezone_set('UTC');
                app()->setLocale('en');
            }
        } catch (\Exception $ex) {
            //
            date_default_timezone_set('UTC');
            app()->setLocale('en');
        }
    }
}
