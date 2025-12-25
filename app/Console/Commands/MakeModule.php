<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeModule extends Command
{
    protected $signature = 'make:module {name}';
    protected $description = 'Create a new module skeleton under app/Modules/{Name}';
    protected Filesystem $files;

    public function __construct()
    {
        parent::__construct();
        $this->files = new Filesystem();
    }

    public function handle()
    {
        $name = ucfirst($this->argument('name'));
        $base = app_path("Modules/{$name}");

        $structure = [
            'Http/Controllers/Api' => [],
            'Models' => [],
            'Database/Migrations' => [],
            'Resources/views' => [],
            'routes' => [],
            'Providers' => [],
            'Config' => [],
            'Tests' => [],
        ];

        if ($this->files->exists($base)) {
            $this->error("Module {$name} already exists.");
            return 1;
        }

        foreach ($structure as $dir => $files) {
            $path = "{$base}/{$dir}";
            $this->files->makeDirectory($path, 0755, true);
        }

        // Create a sample ServiceProvider
        $providerPath = "{$base}/Providers/{$name}ServiceProvider.php";
        $providerStub = $this->getProviderStub($name);
        $this->files->put($providerPath, $providerStub);

        // Create sample routes file
        $routesPath = "{$base}/routes/api.php";
        $routesStub = $this->getRoutesStub($name);
        $this->files->put($routesPath, $routesStub);

        // Create sample Controller
        $controllerPath = "{$base}/Http/Controllers/Api/{$name}Controller.php";
        $controllerStub = $this->getControllerStub($name);
        $this->files->put($controllerPath, $controllerStub);

        // Create sample Model
        $modelPath = "{$base}/Models/{$name}.php";
        $modelStub = $this->getModelStub($name);
        $this->files->put($modelPath, $modelStub);

        // Create sample config
        $configPath = "{$base}/Config/" . strtolower($name) . ".php";
        $this->files->put($configPath, "<?php\n\nreturn [\n    'example' => true,\n];\n");

        $this->info("Module {$name} created successfully under app/Modules/{$name}.");
        $this->info("Run composer dump-autoload if needed.");
        return 0;
    }

    protected function getProviderStub($name)
    {
        return <<<PHP
<?php
namespace App\Modules\\{$name}\Providers;

use Illuminate\Support\ServiceProvider;

class {$name}ServiceProvider extends ServiceProvider
{
    public function register()
    {
        \$this->mergeConfigFrom(__DIR__.'/../Config/{$name}.php', strtolower('{$name}'));
    }

    public function boot()
    {
        \$this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        \$this->loadViewsFrom(__DIR__.'/../Resources/views', strtolower('{$name}'));
        \$this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }
}
PHP;
    }

    protected function getRoutesStub($name)
    {
        $prefix = strtolower($name);
        return <<<PHP
<?php
use Illuminate\Support\Facades\Route;
use App\Modules\\{$name}\Http\Controllers\Api\\{$name}Controller;

Route::prefix('api/{$prefix}')->group(function () {
    Route::get('/', [{$name}Controller::class, 'index']);
    Route::get('{id}', [{$name}Controller::class, 'show']);
});
PHP;
    }

    protected function getControllerStub($name)
    {
        return <<<PHP
<?php
namespace App\Modules\\{$name}\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\\{$name}\Models\\{$name};

class {$name}Controller extends Controller
{
    public function index()
    {
        return response()->json({$name}::paginate(10));
    }

    public function show(\$id)
    {
        return response()->json({$name}::findOrFail(\$id));
    }
}
PHP;
    }

    protected function getModelStub($name)
    {
        return <<<PHP
<?php
namespace App\Modules\\{$name}\Models;

use Illuminate\Database\Eloquent\Model;

class {$name} extends Model
{
    protected \$table = strtolower('{$name}s');
    protected \$fillable = [];
}
PHP;
    }
}
