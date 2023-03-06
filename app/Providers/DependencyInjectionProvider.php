<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use function app_path;
use function file_exists;

class DependencyInjectionProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;
        if (file_exists($dependenies = app_path()."/dependencies.php")) {
            require $dependenies;
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
