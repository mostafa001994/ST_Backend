<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Filesystem\Filesystem;

class MigrateModules extends Command
{
    protected $signature = 'migrate:modules {--force : Run migrations without confirmation}';
    protected $description = 'Run migrations for all modules located in app/Modules';

    protected Filesystem $files;

    public function __construct()
    {
        parent::__construct();
        $this->files = new Filesystem();
    }

    public function handle()
    {
        $modulesPath = app_path('Modules');

        if (!is_dir($modulesPath)) {
            $this->warn('Modules directory not found: ' . $modulesPath);
            return 0;
        }

        $modules = array_filter(scandir($modulesPath), fn($d) => $d !== '.' && $d !== '..');

        foreach ($modules as $module) {
            $migrationsPath = "{$modulesPath}/{$module}/Database/Migrations";
            if (is_dir($migrationsPath)) {
                $this->info("Migrating module: {$module}");
                // مسیر را نسبت به base_path تنظیم می‌کنیم
                $relativePath = str_replace(base_path() . DIRECTORY_SEPARATOR, '', $migrationsPath);
                Artisan::call('migrate', [
                    '--path' => $relativePath,
                    '--force' => $this->option('force') ? true : false,
                ]);
                $this->line(Artisan::output());
            } else {
                $this->line("No migrations for module: {$module}");
            }
        }

        $this->info('Module migrations finished.');
        return 0;
    }
}
