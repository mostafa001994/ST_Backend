<?php
namespace App\Modules\Company\Providers;

use Illuminate\Support\ServiceProvider;

class CompanyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/Company.php', strtolower('Company'));
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadViewsFrom(__DIR__.'/../Resources/views', strtolower('Company'));
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }
}