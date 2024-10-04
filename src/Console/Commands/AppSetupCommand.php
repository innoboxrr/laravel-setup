<?php

namespace Innoboxrr\LaravelSetup\Console\Commands;

use Illuminate\Console\Command;
use Innoboxrr\LaravelSetup\Utils\FileManager;
use Innoboxrr\LaravelSetup\Utils\ComposerJsonEditor;
use Innoboxrr\LaravelSetup\Utils\EnvEditor;
use Illuminate\Support\Str;

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
        $this->updateEnvFiles();
        $this->addVue();
        $this->deleteWelcomeBladeFile();
        $this->createAppBladeFile();
        $this->replaceWebRoutesFile();
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
        $editor->addParameter('require.innoboxrr/laravel-notifications', '^1.0');
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

    // Env
    private function updateEnvFiles()
    {
        $editor = new EnvEditor(base_path('.env'), base_path('.env.example'));

        // Base parameters
        $appKey = $editor->getParameter('APP_KEY');
        $databaseName = $editor->getParameter('DB_DATABASE');

        // Configuración general - Respetar APP_KEY
        $editor->addOrUpdateParameter('APP_NAME', 'Laravel');
        $editor->addOrUpdateParameter('APP_ENV', 'local');
        $editor->addOrUpdateParameter('APP_KEY', $appKey);
        $editor->addOrUpdateParameter('APP_DEBUG', 'true');
        $editor->addOrUpdateParameter('APP_TIMEZONE', 'UTC');
        $editor->addOrUpdateParameter('APP_URL', 'http://localhost');

        // Variables de localización y configuración general
        $editor->addOrUpdateParameter('APP_LOCALE', 'en');
        $editor->addOrUpdateParameter('APP_FALLBACK_LOCALE', 'en');
        $editor->addOrUpdateParameter('APP_FAKER_LOCALE', 'en_US');

        // Configuración de Mantenimiento y otros
        $editor->addOrUpdateParameter('APP_MAINTENANCE_DRIVER', 'file');
        $editor->addOrUpdateParameter('# APP_MAINTENANCE_STORE', 'database');
        $editor->addOrUpdateParameter('BCRYPT_ROUNDS', '12');
        
        // Configuración de Logs
        $editor->addOrUpdateParameter('LOG_CHANNEL', 'stack');
        $editor->addOrUpdateParameter('LOG_STACK', 'single');
        $editor->addOrUpdateParameter('LOG_DEPRECATIONS_CHANNEL', 'null');
        $editor->addOrUpdateParameter('LOG_LEVEL', 'debug');

        // Base de datos - Mantener configuraciones actuales
        $editor->addOrUpdateParameter('DB_CONNECTION', 'mysql');
        $editor->addOrUpdateParameter('DB_HOST', '127.0.0.1');
        $editor->addOrUpdateParameter('DB_PORT', '3306');
        $editor->addOrUpdateParameter('DB_DATABASE', $databaseName);
        $editor->addOrUpdateParameter('DB_USERNAME', 'root');
        $editor->addOrUpdateParameter('DB_PASSWORD', '');

        // Sesión
        $editor->addOrUpdateParameter('SESSION_DRIVER', 'database');
        $editor->addOrUpdateParameter('SESSION_LIFETIME', '2400');
        $editor->addOrUpdateParameter('SESSION_ENCRYPT', 'false');
        $editor->addOrUpdateParameter('SESSION_PATH', '/');
        $editor->addOrUpdateParameter('SESSION_DOMAIN', 'null');

        // Configuraciones varias
        $editor->addOrUpdateParameter('BROADCAST_CONNECTION', 'log');
        $editor->addOrUpdateParameter('FILESYSTEM_DISK', 'local');
        $editor->addOrUpdateParameter('QUEUE_CONNECTION', 'database');
        $editor->addOrUpdateParameter('CACHE_STORE', 'database');
        $editor->addOrUpdateParameter('CACHE_PREFIX', '');
        $editor->addOrUpdateParameter('MEMCACHED_HOST', '127.0.0.1');
        $editor->addOrUpdateParameter('REDIS_CLIENT', 'phpredis');
        $editor->addOrUpdateParameter('REDIS_HOST', '127.0.0.1');
        $editor->addOrUpdateParameter('REDIS_PASSWORD', 'null');
        $editor->addOrUpdateParameter('REDIS_PORT', '6379');

        // Configuración de Mail
        $editor->addOrUpdateParameter('MAIL_MAILER', 'log');
        $editor->addOrUpdateParameter('MAIL_HOST', '127.0.0.1');
        $editor->addOrUpdateParameter('MAIL_PORT', '2525');
        $editor->addOrUpdateParameter('MAIL_USERNAME', 'null');
        $editor->addOrUpdateParameter('MAIL_PASSWORD', 'null');
        $editor->addOrUpdateParameter('MAIL_ENCRYPTION', 'null');
        $editor->addOrUpdateParameter('MAIL_FROM_ADDRESS', '"hello@example.com"');
        $editor->addOrUpdateParameter('MAIL_FROM_NAME', '${APP_NAME}');

        // Configuración de AWS
        $editor->addOrUpdateParameter('AWS_ACCESS_KEY_ID', '');
        $editor->addOrUpdateParameter('AWS_SECRET_ACCESS_KEY', '');
        $editor->addOrUpdateParameter('AWS_DEFAULT_REGION', 'us-east-1');
        $editor->addOrUpdateParameter('AWS_BUCKET', '');
        $editor->addOrUpdateParameter('AWS_USE_PATH_STYLE_ENDPOINT', 'false');

        // Configuración de Vite - Respetar sintaxis ${BASE_PROP}
        $editor->addOrUpdateParameter('VITE_APP_NAME', '${APP_NAME}');
        $editor->addOrUpdateParameter('VITE_APP_LANG', 'en');
        $editor->addOrUpdateParameter('VITE_APPLE_TOUCH_ICON_57X57', 'https://picsum.photos/57/57');
        $editor->addOrUpdateParameter('VITE_APPLE_TOUCH_ICON_60X60', 'https://picsum.photos/60/60');
        $editor->addOrUpdateParameter('VITE_APPLE_TOUCH_ICON_72X72', 'https://picsum.photos/72/72');
        $editor->addOrUpdateParameter('VITE_APPLE_TOUCH_ICON_76X76', 'https://picsum.photos/76/76');
        $editor->addOrUpdateParameter('VITE_APPLE_TOUCH_ICON_114X114', 'https://picsum.photos/114/114');
        $editor->addOrUpdateParameter('VITE_APPLE_TOUCH_ICON_120X120', 'https://picsum.photos/120/120');
        $editor->addOrUpdateParameter('VITE_APPLE_TOUCH_ICON_144X144', 'https://picsum.photos/144/144');
        $editor->addOrUpdateParameter('VITE_APPLE_TOUCH_ICON_152X152', 'https://picsum.photos/152/152');
        $editor->addOrUpdateParameter('VITE_APPLE_TOUCH_ICON_180X180', 'https://picsum.photos/180/180');
        $editor->addOrUpdateParameter('VITE_ICON_192X192', 'https://picsum.photos/192/192');
        $editor->addOrUpdateParameter('VITE_ICON_32X32', 'https://picsum.photos/32/32');
        $editor->addOrUpdateParameter('VITE_ICON_96X96', 'https://picsum.photos/96/96');
        $editor->addOrUpdateParameter('VITE_ICON_16X16', 'https://picsum.photos/16/16');
        $editor->addOrUpdateParameter('VITE_ICON', '${VITE_ICON_192X192}');
        $editor->addOrUpdateParameter('VITE_MICROSOFT_LOGIN', 'true');
        $editor->addOrUpdateParameter('VITE_GOOGLE_LOGIN', 'true');
        $editor->addOrUpdateParameter('VITE_FACEBOOK_LOGIN', 'true');
    }



    // CSS //
    private function addVue()
    {
        // De la App original elimianr las carpetas css y js
        $this->rrDir(resource_path('css'));
        $this->rrDir(resource_path('js'));
        $this->cpDir(__DIR__ . '/../../../stubs/laravel/resources/vue', dst: resource_path('vue'));
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
}
