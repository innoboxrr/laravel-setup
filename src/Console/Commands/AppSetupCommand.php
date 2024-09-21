<?php

namespace Innoboxrr\LaravelSetup\Console\Commands;

use Illuminate\Console\Command;
use Innoboxrr\LaravelSetup\Utils\FileManager;
use Innoboxrr\LaravelSetup\Utils\ComposerJsonEditor;

class AppSetupCommand extends Command
{
    use FileManager;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configurar la instalación de la aplicación';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->testNode()) return;
        $this->replacePackageJson();
        $this->replaceViteConfig();
        $this->addTailwindCssConfig();
        $this->addPostCssConfig();
        $this->addCommands();
        $this->addPhpDoc();
        $this->addAppHelpers();
        $this->addHttp();
        $this->addMigrations();
        $this->updateComposerJson();
        $this->addVue();
        $this->deleteWelcomeBladeFile();
        $this->createAppBladeFile();
        $this->replaceWebRoutesFile();
        $this->replaceProvidersFiles();
        $this->registerServiceProvider();
        $this->registerAppConfig();
        $this->info('¡La configuración se ha completado con éxito!');
    }

    // NODE //
    private function testNode()
    {

        $node = shell_exec('node -v'); // v18.12.1 -> 18.12

        if (is_null($node)) {

            $this->info('NodeJS no está instalado en el sistema');

            return 0; // Considerar lanzar una excepción.

        }

        $node =  str_replace('v', '', $node);

        $node = explode('.', $node);

        $node = (float) ($node[0] . '.' . $node[1]);

        if ($node < 16) {

            $this->info('La versión de node no es compatible');

            return 0;
        }

        return 1;
    }

    // CONFIG //
    private function replacePackageJson()
    {
        $packageJson = file_get_contents(__DIR__ . '/../../../stubs/laravel/package.json.stub');
        file_put_contents(base_path('package.json'), $packageJson);
    }

    private function replaceViteConfig()
    {
        $viteConfig = file_get_contents(__DIR__ . '/../../../stubs/laravel/vite.config.js.stub');
        file_put_contents(base_path('vite.config.js'), $viteConfig);
    }

    // TAILWIND
    private function addTailwindCssConfig()
    {
        $tailwindCssConfig = file_get_contents(__DIR__ . '/../../../stubs/laravel/tailwind.config.js.stub');
        file_put_contents(base_path('tailwind.config.js'), $tailwindCssConfig);
    }

    private function addPostCssConfig()
    {
        $postCssConfig = file_get_contents(__DIR__ . '/../../../stubs/laravel/postcss.config.js.stub');
        file_put_contents(base_path('postcss.config.js'), $postCssConfig);
    }

    // COMMANDS //
    private function addCommands()
    {
        $this->mkDir(base_path('app/Console/Commands'));
        $this->cpDir(__DIR__ . '/../../../stubs/laravel/app/Console/Commands', base_path('app/Console/Commands'));
    }

    // PHPDOC //
    private function addPhpDoc()
    {
        $phpDocFile = file_get_contents(__DIR__ . '/../../../stubs/laravel/phpDoc.phar');
        file_put_contents(base_path('phpDoc.phar'), $phpDocFile);
    }

    // HELPERS //
    private function addAppHelpers()
    {
        $this->mkDir(base_path('app/Helpers'));
        $helpersFile = file_get_contents(__DIR__ . '/../../../stubs/laravel/app/Helpers/app.php.stub');
        file_put_contents(base_path('app/Helpers/app.php'), $helpersFile);
    }

    // HTTP //
    private function addHttp()
    {
        $this->mkDir(base_path('app/Http'));
        $this->cpDir(__DIR__ . '/../../../stubs/laravel/app/Http', base_path('app/Http'));
    }



    // MIGRATIONS //
    private function addMigrations()
    {
        $this->cpDir(__DIR__ . '/../../../stubs/laravel/database/migrations', base_path('database/migrations'));
    }

    // COMPOSER PACKAGES INSTALATION //

    private function updateComposerJson()
    {
        $editor = new ComposerJsonEditor(base_path('composer.json'));
        $editor->addParameter('require.algolia/scout-extended', '^3.1');
        $editor->addParameter('require.google/recaptcha', '^1.3');
        $editor->addParameter('require.innoboxrr/aws-file-manager', '^0.0');
        $editor->addParameter('require.innoboxrr/laravel-audit', '^1.0');
        $editor->addParameter('require.innoboxrr/laravel-auth', '^4.0');
        $editor->addParameter('require.innoboxrr/laravel-env-editor', 'dev-master');
        $editor->addParameter('require.innoboxrr/laravel-notifications', '^1.7');
        $editor->addParameter('require.innoboxrr/laravel-uploads', '^1.0');
        $editor->addParameter('require.innoboxrr/locale-generator', '^1.0');
        $editor->addParameter('require.innoboxrr/routes-to-json', '^1.0');
        $editor->addParameter('require.innoboxrr/search-surge', '^2.0');
        $editor->addParameter('require.innoboxrr/traits', '^1.0');
        $editor->addParameter('require.maatwebsite/excel', '^3.1'); // Excel
        $editor->addParameter('require.opcodesio/log-viewer', '^3.0'); // Excel
        $editor->addParameter('require.league/flysystem-aws-s3-v3', '^3.0'); // AWS S3
        $editor->addParameter('require.staudenmeir/belongs-to-through', '^2.1'); // **
        $editor->addParameter('require.staudenmeir/eloquent-has-many-deep', '^1.0'); // **
        $editor->addParameter('require-dev.innoboxrr/larapack-generator', '^5.0');
        $editor->addParameter('require-dev.lab404/laravel-impersonate', '^1.7');
        $editor->addParameter('autoload.files', ['app/Helpers/app.php']);
    }

    // CSS //
    private function addVue()
    {
        // De la App original elimianr las carpetas css y js
        $this->rrDir(resource_path('css'));
        $this->rrDir(resource_path('js'));
        $this->cpDir(__DIR__ . '/../../../stubs/laravel/resources/vue', base_path('vue'));
    }

    // VIEWS //

    private function deleteWelcomeBladeFile()
    {
        $this->rrDir(resource_path('views/welcome.blade.php'));
    }

    private function createAppBladeFile()
    {
        // Arroja error
        $path = $this->mkDir(resource_path('views'));
        $bladeFile = file_get_contents(__DIR__ . '/../../../stubs/laravel/resources/views/app.blade.php.stub');
        file_put_contents(resource_path('views/app.blade.php'), $bladeFile);
    }


    // ROUTES //
    private function replaceWebRoutesFile()
    {
        $webRoutesFile = file_get_contents(__DIR__ . '/../../../stubs/laravel/routes/web.php.stub');
        file_put_contents(base_path('routes/web.php'), $webRoutesFile);
    }

    // PROVIDERS
    private function replaceProvidersFiles()
    {

        $appServiceProvider = file_get_contents(__DIR__ . '/../../../stubs/laravel/app/Providers/AppServiceProvider.php.stub');
        $authServiceProvider = file_get_contents(__DIR__ . '/../../../stubs/laravel/app/Providers/AuthServiceProvider.php.stub');
        $eventServiceProvider = file_get_contents(__DIR__ . '/../../../stubs/laravel/app/Providers/EventServiceProvider.php.stub');
        $broadcastServiceProvider = file_get_contents(__DIR__ . '/../../../stubs/laravel/app/Providers/BroadcastServiceProvider.php.stub');
        $routeServiceProvider = file_get_contents(__DIR__ . '/../../../stubs/laravel/app/Providers/RouteServiceProvider.php.stub');

        file_put_contents(base_path('app/Providers/AppServiceProvider.php'), $appServiceProvider);
        file_put_contents(base_path('app/Providers/AuthServiceProvider.php'), $authServiceProvider);
        file_put_contents(base_path('app/Providers/EventServiceProvider.php'), $eventServiceProvider);
        file_put_contents(base_path('app/Providers/BroadcastServiceProvider.php'), $broadcastServiceProvider);
        file_put_contents(base_path('app/Providers/RouteServiceProvider.php'), $routeServiceProvider);
    }

    private function registerAppConfig()
    {
        // Buscar el stub en  __DIR__ . '/../../../stubs/laravel/bootstrap/app.php.stub'
        $appFile = file_get_contents(__DIR__ . '/../../../stubs/laravel/bootstrap/app.php.stub');
        // Poner el contenido en el archivo bootstrap/app.php
        file_put_contents(base_path('bootstrap/app.php'), $appFile);
    }

    private function registerServiceProvider()
    {
        // Buscar el stub en  __DIR__ . '/../../../stubs/laravel/bootstrap/providers.php.stub'
        $providersFile = file_get_contents(__DIR__ . '/../../../stubs/laravel/bootstrap/providers.php.stub');
        // Poner el contenido en el archivo bootstrap/providers.php
        file_put_contents(base_path('bootstrap/providers.php'), $providersFile);
    }
}
