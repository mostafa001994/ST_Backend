<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ModuleSeed extends Command
{
    protected $signature = 'module:seed {module : Module name} {--class= : Specific seeder class}';
    protected $description = 'Run seeder for a specific module located in app/Modules/{Module}/Database/Seeders';

    public function handle()
    {
        $module = ucfirst($this->argument('module'));
        $seederClassOption = $this->option('class');

        $baseNamespace = "App\\Modules\\{$module}\\Database\\Seeders";

        if ($seederClassOption) {
            $seederClass = $seederClassOption;
            // اگر نام کامل داده نشده، namespace ماژول را اضافه کن
            if (!str_contains($seederClass, '\\')) {
                $seederClass = "{$baseNamespace}\\{$seederClass}";
            }
        } else {
            $seederClass = "{$baseNamespace}\\DatabaseSeeder";
        }

        if (!class_exists($seederClass)) {
            $this->error("Seeder class not found: {$seederClass}");
            return 1;
        }

        $this->info("Running seeder: {$seederClass}");
        Artisan::call('db:seed', ['--class' => $seederClass, '--force' => true]);
        $this->line(Artisan::output());

        $this->info("Seeding finished for module: {$module}");
        return 0;
    }
}
