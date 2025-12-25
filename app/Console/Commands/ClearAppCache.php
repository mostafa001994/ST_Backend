<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearAppCache extends Command
{
    protected $signature = 'app:clear-cache';
    protected $description = 'Clear all Laravel caches (config, route, view, cache)';

    public function handle()
    {
        $this->info("Clearing application caches...");

        Artisan::call('config:clear');
        $this->line(Artisan::output());

        Artisan::call('route:clear');
        $this->line(Artisan::output());

        Artisan::call('view:clear');
        $this->line(Artisan::output());

        Artisan::call('cache:clear');
        $this->line(Artisan::output());

        $this->info("All caches cleared successfully.");
    }
}
