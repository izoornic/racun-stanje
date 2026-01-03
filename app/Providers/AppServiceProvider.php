<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\StanDataProviderInterface;
use App\Providers\StanDataApiProvider;
use App\Providers\StanDataDbProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(StanDataProviderInterface::class, function () {
            return match (config('data-source.driver')) {
                'api' => new StanDataApiProvider(),
                'db'  => new StanDataDbProvider(),
                default => throw new \Exception('Invalid data source driver'),
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
