<?php
namespace App\Modules\User\Providers;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/User.php', strtolower('User'));
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadViewsFrom(__DIR__.'/../Resources/views', strtolower('User'));
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }
}