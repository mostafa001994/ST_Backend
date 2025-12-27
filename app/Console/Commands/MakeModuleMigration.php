<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeModuleMigration extends Command
{
    protected $signature = 'module:make-migration 
                            {name : The name of the migration} 
                            {module : The module name} 
                            {--create= : The table to be created} 
                            {--table= : The table to migrate}';
    protected $description = 'Create a new migration file inside a specific module';

    public function handle()
    {
        $name   = $this->argument('name');
        $module = ucfirst($this->argument('module'));

        $path = app_path("Modules/{$module}/Database/Migrations");

        if (!is_dir($path)) {
            $this->error("No Migrations directory found for module: {$module}");
            return 1;
        }

        $options = [
            'name'   => $name,
            '--path' => str_replace(base_path() . DIRECTORY_SEPARATOR, '', $path),
        ];

        if ($this->option('create')) {
            $options['--create'] = $this->option('create');
        }
        if ($this->option('table')) {
            $options['--table'] = $this->option('table');
        }

        $this->info("Creating migration '{$name}' for module: {$module}");
        Artisan::call('make:migration', $options);
        $this->line(Artisan::output());

        return 0;
    }
}
