<?php
namespace App\Modules\Setting\Providers;

use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/Setting.php', strtolower('Setting'));
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadViewsFrom(__DIR__.'/../Resources/views', strtolower('Setting'));
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }
}