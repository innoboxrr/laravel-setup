<?php

namespace Innoboxrr\LaravelSetup\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Innoboxrr\LaravelSetup\Support\ComposerJson;
use Innoboxrr\LaravelSetup\Support\Dependencies;
use Innoboxrr\LaravelSetup\Support\EnvFile;
use RuntimeException;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Convierte una aplicación Laravel 13 recién creada en la aplicación base.
 *
 * No instala nada: deja escritos composer.json, package.json, la configuración,
 * las pantallas y el usuario generado con LaraPack, y `app:install` instala,
 * migra y compila. Así se puede revisar lo que cambió antes de instalar.
 */
class AppSetupCommand extends Command
{
    protected $signature = 'app:setup
        {--react : Monta la interfaz en React; por omisión, Vue}
        {--force : Configura aunque la aplicación no parezca recién creada}';

    protected $description = 'Convierte una aplicación Laravel 13 recién creada en la aplicación base: acceso, sitio, administrador y usuarios';

    private Filesystem $files;

    public function handle(Filesystem $files): int
    {
        $this->files = $files;

        $framework = $this->option('react') ? 'react' : 'vue';

        if (! $this->option('force') && ! $this->isFresh()) {
            $this->components->error('La aplicación ya no parece recién creada: app:setup reemplaza archivos como bootstrap/app.php, routes/web.php y package.json. Usa --force si de verdad quieres configurarla.');

            return self::FAILURE;
        }

        $this->components->info("Configurando la aplicación base con {$framework}.");

        $this->components->task('Dependencias de Composer', fn () => $this->requireDependencies());
        $this->components->task('Variables de entorno', fn () => $this->configureEnvironment());
        $this->components->task('Administradores en config/auth.php', fn () => $this->configureAdmins());
        $this->components->task('Backend de la aplicación', fn () => $this->publishBackend());
        $this->components->task('Interfaz en '.$framework, fn () => $this->publishFrontend($framework));
        $this->components->task('Rutas para el front', fn () => $this->configureRoutesToJson($framework));
        $this->components->task('Usuarios, con LaraPack', fn () => $this->generateUsers($framework));

        $this->newLine();
        $this->components->info('Listo. Revisa los cambios y ejecuta: php artisan app:install');
        $this->line('  Pon tu correo en ADMIN_EMAILS, en el .env, para entrar al administrador.');

        return self::SUCCESS;
    }

    /**
     * Una aplicación recién creada todavía tiene la bienvenida de Laravel y no
     * tiene la interfaz ni el laraimport de la aplicación base.
     */
    private function isFresh(): bool
    {
        return is_file(resource_path('views/welcome.blade.php'))
            && ! is_file(base_path('laraimport.json'))
            && ! is_dir(resource_path('vue/app'))
            && ! is_dir(resource_path('react/app'));
    }

    private function requireDependencies(): void
    {
        (new ComposerJson(base_path('composer.json')))
            ->remove(Dependencies::composerRemoved())
            ->require(Dependencies::composer())
            ->require(Dependencies::composerDev(), dev: true)
            ->save();
    }

    /**
     * Las claves que la aplicación base necesita. En .env.example van sin
     * secretos; en .env no se pisa lo que ya estuviera escrito, salvo lo que la
     * aplicación base cambia a propósito.
     */
    private function configureEnvironment(): void
    {
        $defaults = [
            'ADMIN_EMAILS' => '',
            'LARAVEL_UPLOADS_DISK' => 'public',
            'LARAVEL_OPTIONS_EXPORT_DISK' => 'local',
            'LARAVEL_AUDIT_EXPORT_DISK' => 'local',
            'VITE_APP_NAME' => '${APP_NAME}',
            'VITE_GOOGLE_LOGIN' => 'false',
            'VITE_FACEBOOK_LOGIN' => 'false',
            'VITE_MICROSOFT_LOGIN' => 'false',
        ];

        $decided = [
            'APP_LOCALE' => 'es',
            'APP_FALLBACK_LOCALE' => 'en',
            'APP_FAKER_LOCALE' => 'es_MX',
            'SESSION_DRIVER' => 'database',
        ];

        foreach ([base_path('.env.example'), base_path('.env')] as $path) {
            if (! is_file($path)) {
                continue;
            }

            (new EnvFile($path))->setMany($decided)->setMany($defaults, onlyMissing: true)->save();
        }
    }

    /**
     * `auth.admins` es lo que lee isAdmin() en el usuario generado.
     */
    private function configureAdmins(): void
    {
        $path = config_path('auth.php');
        $config = (string) file_get_contents($path);

        if (str_contains($config, "'admins'")) {
            return;
        }

        $entry = <<<'PHP'

    /*
    |--------------------------------------------------------------------------
    | Administradores
    |--------------------------------------------------------------------------
    |
    | Los correos de quienes administran la aplicación, separados por comas en
    | ADMIN_EMAILS. Es lo que responde isAdmin() en el usuario: las políticas
    | les dejan pasar y pueden entrar como otros usuarios.
    |
    */

    'admins' => array_values(array_filter(array_map('trim', explode(',', (string) env('ADMIN_EMAILS', ''))))),

];
PHP;

        $position = strrpos($config, '];');

        file_put_contents($path, substr($config, 0, $position).ltrim($entry, "\n").substr($config, $position + 2));
    }

    private function publishBackend(): void
    {
        $this->files->copyDirectory($this->stubs('common'), base_path());

        $this->files->delete(resource_path('views/welcome.blade.php'));
        $this->files->deleteDirectory(resource_path('js'));
        $this->files->deleteDirectory(resource_path('css'));
    }

    private function publishFrontend(string $framework): void
    {
        $this->files->copyDirectory($this->stubs($framework), base_path());
    }

    private function configureRoutesToJson(string $framework): void
    {
        $this->files->ensureDirectoryExists(config_path());

        file_put_contents(config_path('routes-to-json.php'), <<<PHP
<?php

return [

    // Las rutas con nombre que lee el front con route(): las del administrador,
    // las del paquete de autenticación y las de la API generada por LaraPack.
    'path' => env('JSON_ROUTES_FILE', resource_path('{$framework}/routes.json')),

];

PHP);
    }

    /**
     * El usuario de Laravel se sustituye por el que genera LaraPack desde
     * laraimport.json: la misma arquitectura que cualquier otro modelo, con su
     * API, sus políticas, sus tests y su módulo en el administrador.
     */
    private function generateUsers(string $framework): void
    {
        $this->files->delete(app_path('Models/User.php'));

        $this->larapack('larapack:import', [
            'jsonPath' => base_path('laraimport.json'),
            "--{$framework}" => true,
            '--root' => base_path(),
        ]);

        $this->larapack('larapack:route-service-provider', [
            '--root' => base_path(),
        ]);

        // La política generada nace cerrada; el perfil necesita que cada quien
        // vea y edite su propia cuenta. Las políticas son código de la
        // aplicación, así que LaraPack no la vuelve a pisar al regenerar.
        $this->files->copyDirectory($this->stubs('overrides'), base_path());
    }

    /**
     * Sin su salida, un laraimport que LaraPack rechaza dejaba la aplicación sin
     * usuario y el comando decía que todo había ido bien.
     *
     * @param  array<string, mixed>  $arguments
     */
    private function larapack(string $command, array $arguments): void
    {
        $output = new BufferedOutput;

        if ($this->runCommand($command, $arguments, $output) !== self::SUCCESS) {
            throw new RuntimeException("{$command} terminó con error:\n".$output->fetch());
        }
    }

    private function stubs(string $path): string
    {
        return dirname(__DIR__, 3).'/stubs/app/'.$path;
    }
}
