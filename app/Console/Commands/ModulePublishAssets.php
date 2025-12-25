<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ModulePublishAssets extends Command
{
    protected $signature = 'module:publish-assets {module : Module name} {--to=public : Destination public or config}';
    protected $description = 'Publish module assets to public/modules/{module} or publish config to config/';

    protected Filesystem $files;

    public function __construct()
    {
        parent::__construct();
        $this->files = new Filesystem();
    }

    public function handle()
    {
        $module = ucfirst($this->argument('module'));
        $to = $this->option('to');

        $moduleBase = app_path("Modules/{$module}");
        if (!is_dir($moduleBase)) {
            $this->error("Module not found: {$moduleBase}");
            return 1;
        }

        // انتشار assets به public/modules/{module}
        $assetsPath = "{$moduleBase}/Resources/assets";
        if ($to === 'public') {
            if (!is_dir($assetsPath)) {
                $this->warn("No assets directory for module: {$module}");
            } else {
                $dest = public_path("modules/" . strtolower($module));
                $this->files->ensureDirectoryExists($dest);
                $this->files->copyDirectory($assetsPath, $dest);
                $this->info("Assets copied to: {$dest}");
            }
        }

        // انتشار config
        $configPath = "{$moduleBase}/Config";
        if (is_dir($configPath)) {
            $files = $this->files->files($configPath);
            foreach ($files as $file) {
                $filename = $file->getFilename();
                $this->files->copy($file->getPathname(), config_path($filename));
                $this->info("Config published: {$filename}");
            }
        } else {
            $this->line("No config directory for module: {$module}");
        }

        $this->info("Publish finished for module: {$module}");
        return 0;
    }
}
