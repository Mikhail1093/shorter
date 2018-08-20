<?php

namespace App\Providers;

use App\Business\Statistic\Fabric;
use App\Business\Statistic\StatisticStorageInterFace;
use Illuminate\Support\ServiceProvider;

class StatisticServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StatisticStorageInterFace::class, function ($app) {
            return Fabric::getStorageFromSettingsValue(config('statistic.statistic_storage', 'unknown'));
        });
    }
}
