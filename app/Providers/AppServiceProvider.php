<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

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
        $host = request()->getHost();
        $localHosts = ['localhost', '127.0.0.1', '::1'];

        // On LAN/mobile access, always use built assets and ignore Vite hot file.
        if (!in_array($host, $localHosts, true)) {
            Vite::useHotFile(storage_path('framework/vite.hot.disabled'));
        }
    }
}
