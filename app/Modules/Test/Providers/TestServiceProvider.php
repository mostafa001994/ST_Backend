<?php
namespace App\Modules\Test\Providers;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/Test.php', strtolower('Test'));
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadViewsFrom(__DIR__.'/../Resources/views', strtolower('Test'));
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }
}