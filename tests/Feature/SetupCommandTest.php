<?php

namespace Innoboxrr\LaravelSetup\Tests\Feature;

use Illuminate\Filesystem\Filesystem;
use Innoboxrr\LarapackGenerator\Providers\GeneratorServiceProvider;
use Innoboxrr\LaravelSetup\Support\EnvFile;
use Innoboxrr\LaravelSetup\Tests\TestCase;

/**
 * `app:setup` sobre una copia exacta de una aplicación Laravel 13 recién creada
 * (`composer create-project laravel/laravel`), guardada en tests/Fixtures.
 */
final class SetupCommandTest extends TestCase
{
    private string $project;

    protected function getPackageProviders($app): array
    {
        return [...parent::getPackageProviders($app), GeneratorServiceProvider::class];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->project = sys_get_temp_dir().'/laravel-setup-'.bin2hex(random_bytes(4));

        (new Filesystem)->copyDirectory(dirname(__DIR__).'/Fixtures/laravel-13', $this->project);

        copy($this->project.'/.env.example', $this->project.'/.env');

        $this->app->setBasePath($this->project);
    }

    protected function tearDown(): void
    {
        (new Filesystem)->deleteDirectory($this->project);

        parent::tearDown();
    }

    public function test_configura_una_aplicacion_nueva_con_vue(): void
    {
        $this->artisan('app:setup')->assertSuccessful();

        $composer = json_decode($this->read('composer.json'), true);

        $this->assertSame('^6.0.3', $composer['require']['innoboxrr/laravel-auth']);
        $this->assertSame('^2.1', $composer['require']['innoboxrr/laravel-options']);
        $this->assertArrayHasKey('innoboxrr/larapack-generator', $composer['require-dev']);

        $env = new EnvFile($this->project.'/.env');

        $this->assertTrue($env->has('ADMIN_EMAILS'));
        $this->assertSame('es', $env->get('APP_LOCALE'));
        $this->assertSame('public', $env->get('LARAVEL_UPLOADS_DISK'));

        $this->assertStringContainsString("'admins' =>", $this->read('config/auth.php'));
        $this->assertStringContainsString('$middleware->statefulApi();', $this->read('bootstrap/app.php'));
        $this->assertStringContainsString("'admin' => EnsureUserIsAdmin::class", $this->read('bootstrap/app.php'));
        $this->assertStringContainsString('Route::fallback(', $this->read('routes/web.php'));
        $this->assertStringContainsString("resource_path('vue/routes.json')", $this->read('config/routes-to-json.php'));

        $this->assertFileDoesNotExist($this->project.'/resources/views/welcome.blade.php');
        $this->assertDirectoryDoesNotExist($this->project.'/resources/js');
        $this->assertFileExists($this->project.'/database/migrations/0001_01_01_000010_add_payload_and_soft_deletes_to_users_table.php');
    }

    /**
     * El usuario sale de LaraPack como cualquier otro modelo: su API, su
     * RouteServiceProvider para cargarla y su módulo del administrador.
     */
    public function test_genera_el_usuario_con_larapack(): void
    {
        $this->artisan('app:setup')->assertSuccessful();

        $this->assertStringContainsString('class User extends Authenticatable', $this->read('app/Models/User.php'));
        $this->assertStringContainsString('public function isAdmin(): bool', $this->read('app/Models/User.php'));
        $this->assertFileExists($this->project.'/routes/api/models/user.php');
        $this->assertFileExists($this->project.'/app/Http/Controllers/UserController.php');
        $this->assertFileExists($this->project.'/app/Providers/RouteServiceProvider.php');
        $this->assertStringContainsString('RouteServiceProvider::class', $this->read('bootstrap/providers.php'));
        $this->assertFileExists($this->project.'/resources/vue/src/models/user/index.js');
        $this->assertFileDoesNotExist($this->project.'/resources/vue/package.json');
        $this->assertFileExists($this->project.'/.larapack/manifest.json');
    }

    /**
     * La política generada nace cerrada y el perfil necesita que cada quien
     * vea y edite su propia cuenta: la de la aplicación base sustituye a la
     * generada en el mismo sitio que el modelo referencia.
     */
    public function test_cada_usuario_puede_ver_y_editar_su_propia_cuenta(): void
    {
        $this->artisan('app:setup')->assertSuccessful();

        $policy = $this->read('app/Policies/UserPolicy.php');

        $this->assertStringContainsString('#[UsePolicy(UserPolicy::class)]', $this->read('app/Models/User.php'));
        $this->assertStringContainsString('namespace App\Policies;', $policy);
        $this->assertSame(2, substr_count($policy, '$user->getAuthIdentifier() === $model->getKey()'));
        $this->assertStringContainsString("\$exceptAbilities = ['forceDelete'];", $policy);
    }

    public function test_todo_el_php_que_deja_compila(): void
    {
        $this->artisan('app:setup')->assertSuccessful();

        $errors = [];

        foreach (['app', 'bootstrap', 'config', 'database', 'routes'] as $directory) {
            foreach ((new Filesystem)->allFiles($this->project.'/'.$directory) as $file) {
                if ($file->getExtension() !== 'php') {
                    continue;
                }

                exec(escapeshellarg(PHP_BINARY).' -l '.escapeshellarg($file->getPathname()).' 2>&1', $output, $code);

                if ($code !== 0) {
                    $errors[] = $file->getPathname().': '.implode(' ', $output);
                }
            }
        }

        $this->assertSame([], $errors);
    }

    public function test_con_react_genera_el_modulo_react(): void
    {
        $this->artisan('app:setup', ['--react' => true])->assertSuccessful();

        $this->assertFileExists($this->project.'/resources/react/src/models/user/index.js');
        $this->assertDirectoryDoesNotExist($this->project.'/resources/vue');
        $this->assertStringContainsString("resource_path('react/routes.json')", $this->read('config/routes-to-json.php'));
    }

    public function test_no_pisa_lo_que_el_env_ya_decidio(): void
    {
        (new EnvFile($this->project.'/.env'))->set('DB_DATABASE', 'mi_base')->set('ADMIN_EMAILS', 'ana@example.com')->save();

        $this->artisan('app:setup')->assertSuccessful();

        $env = new EnvFile($this->project.'/.env');

        $this->assertSame('mi_base', $env->get('DB_DATABASE'));
        $this->assertSame('ana@example.com', $env->get('ADMIN_EMAILS'));
    }

    /**
     * app:setup reemplaza archivos de la aplicación: una segunda vez, sin
     * pedirlo, destruiría lo que se hubiera escrito después.
     */
    public function test_una_aplicacion_que_ya_no_es_nueva_no_se_toca_sin_force(): void
    {
        $this->artisan('app:setup')->assertSuccessful();

        $this->artisan('app:setup')->assertFailed();

        $this->artisan('app:setup', ['--force' => true])->assertSuccessful();

        $this->assertSame(1, substr_count($this->read('config/auth.php'), "'admins' =>"));
    }

    private function read(string $relative): string
    {
        return (string) file_get_contents($this->project.'/'.$relative);
    }
}
