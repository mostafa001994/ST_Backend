<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;

class ConsoleServiceProvider extends ServiceProvider
{
    protected Filesystem $files;

    public function __construct($app)
    {
        parent::__construct($app);
        $this->files = new Filesystem();
    }

    public function register()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        // لیست کامندهای عمومی در app/Console/Commands
        $commands = [];

        $commandsPath = app_path('Console/Commands');
        if ($this->files->isDirectory($commandsPath)) {
            foreach ($this->files->files($commandsPath) as $file) {
                $class = $this->getClassFromFile($file->getPathname());
                if ($class && class_exists($class)) {
                    $commands[] = $class;
                }
            }
        }

        // همچنین کامندهای ماژول‌ها در app/Modules/*/Console/Commands
        $modulesPath = app_path('Modules');
        if ($this->files->isDirectory($modulesPath)) {
            foreach ($this->files->directories($modulesPath) as $moduleDir) {
                $cmdDir = $moduleDir . DIRECTORY_SEPARATOR . 'Console' . DIRECTORY_SEPARATOR . 'Commands';
                if ($this->files->isDirectory($cmdDir)) {
                    foreach ($this->files->files($cmdDir) as $file) {
                        $class = $this->getClassFromFile($file->getPathname());
                        if ($class && class_exists($class)) {
                            $commands[] = $class;
                        }
                    }
                }
            }
        }

        if (!empty($commands)) {
            $this->commands($commands);
        }
    }

    public function boot()
    {
        //
    }

    /**
     * سعی می‌کند namespace و class name را از فایل PHP استخراج کند.
     * این روش ساده است و برای ساختارهای معمول PSR-4 کار می‌کند.
     */
    protected function getClassFromFile(string $path): ?string
    {
        $content = $this->files->get($path);

        // namespace
        if (preg_match('/^namespace\s+(.+?);/m', $content, $m)) {
            $namespace = trim($m[1]);
        } else {
            $namespace = null;
        }

        // class name
        if (preg_match('/class\s+([A-Za-z0-9_]+)/m', $content, $m2)) {
            $class = trim($m2[1]);
        } else {
            return null;
        }

        return $namespace ? $namespace . '\\' . $class : $class;
    }
}
