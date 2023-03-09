<?php

namespace Innoboxrr\LaravelSetup\Console\Commands;

use Illuminate\Console\Command;
use Innoboxrr\LaravelSetup\Utils\ComposerJsonEditor;

class AppSetupCommand extends Command
{
    
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

        if(!$this->testNode()) return;

        $this->replacePackageJson();

        $this->replaceViteConfig();

        $this->addTailwindCssConfig();

        $this->addPostCssConfig();

        $this->addAppHelpers();

        $this->addAppController();

        $this->updateComposerJson();

        $this->replaceCssApp();

        $this->addCssCustom();

        $this->replaceJsBootstrap();

        $this->addJsEnv();

        $this->addJsGlobalComponents();

        $this->addJsMixin();
        
        $this->addJsonNav();
        
        $this->deleteWelcomeBladeFile();
        
        $this->createAppBladeFile();
        
        $this->copyVueDir();
        
        $this->replaceWebRoutesFile();

        $this->info('¡La configuración se ha completado con éxito!'); 
       
    }

    // NODE //

    private function testNode()
    {

        $node = shell_exec('node -v'); // v18.12.1 -> 18.12

        if(is_null($node)) {

            $this->info('NodeJS no está instalado en el sistema');

            return 0; // Considerar lanzar una excepción.

        }
        
        $node =  str_replace('v', '', $node);

        $node = explode('.', $node);

        $node = (float) ($node[0] . '.' . $node[1]);

        if($node < 16) {

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

    // HELPERS //

    private function addAppHelpers()
    {

        $helpersFile = file_get_contents(__DIR__ . '/../../../stubs/laravel/app/Helpers/app.php.stub');

        $this->mkDir(base_path('app/Helpers'));

        file_put_contents(base_path('app/Helpers/app.php'), $helpersFile);

    }

    // CONTROLLER //

    private function addAppController()
    {

        $viteConfig = file_get_contents(__DIR__ . '/../../../stubs/laravel/app/Http/Controllers/AppController.php.stub');

        file_put_contents(base_path('app/Http/Controllers/AppController.php'), $viteConfig);

    }

    // COMPOSER PACKAGES INSTALATION //

    private function updateComposerJson()
    {

        $editor = new ComposerJsonEditor(base_path('composer.json'));

        $editor->addParameter('require.innoboxrr/routes-to-json', '^1.0');

        $editor->addParameter('require.innoboxrr/laravel-auth', '^1.0');

        $editor->addParameter('require.innoboxrr/search-surge', '^1.0');

        $editor->addParameter('require.innoboxrr/traits', '^1.0');

        $editor->addParameter('require.maatwebsite/excel', '^3.1');

        $editor->addParameter('require.staudenmeir/belongs-to-through', '^2.1');

        $editor->addParameter('require.staudenmeir/eloquent-has-many-deep', '^1.0');

        $editor->addParameter('require-dev.innoboxrr/larapack-generator', '^1.0');

        $editor->addParameter('autoload.files', ['app/Helpers/app.php']);

    }

    // CSS //

    private function replaceCssApp()
    {

        $viteConfig = file_get_contents(__DIR__ . '/../../../stubs/laravel/resources/css/app.css.stub');

        file_put_contents(base_path('resources/css/app.css'), $viteConfig);

    }

    private function addCssCustom()
    {

        $viteConfig = file_get_contents(__DIR__ . '/../../../stubs/laravel/resources/css/custom.css.stub');

        file_put_contents(base_path('resources/css/custom.css'), $viteConfig);

    }

    // JS //

    private function replaceJsBootstrap()
    {

        $viteConfig = file_get_contents(__DIR__ . '/../../../stubs/laravel/resources/js/bootstrap.js.stub');

        file_put_contents(base_path('resources/js/bootstrap.js'), $viteConfig);

    }

    private function addJsEnv()
    {

        $viteConfig = file_get_contents(__DIR__ . '/../../../stubs/laravel/resources/js/env.js.stub');

        file_put_contents(base_path('resources/js/env.js'), $viteConfig);

    }

    private function addJsGlobalComponents()
    {

        $viteConfig = file_get_contents(__DIR__ . '/../../../stubs/laravel/resources/js/global-components.js.stub');

        file_put_contents(base_path('resources/js/global-components.js'), $viteConfig);

    }

    private function addJsMixin()
    {

        $viteConfig = file_get_contents(__DIR__ . '/../../../stubs/laravel/resources/js/mixin.js.stub');

        file_put_contents(base_path('resources/js/mixin.js'), $viteConfig);

    }

    // JSON //

    private function addJsonNav()
    {

        $viteConfig = file_get_contents(__DIR__ . '/../../../stubs/laravel/resources/json/nav.json.stub');

        $this->mkDir(base_path('resources/json'));

        file_put_contents(base_path('resources/json/nav.json'), $viteConfig);

    }

    // VIEWS //

    private function deleteWelcomeBladeFile()
    {

        $this->rrDir(resource_path('views/welcome.blade.php'));

    }

    private function createAppBladeFile()
    {

        // Arroja error
        //$this->rrDir(resource_path('views'));

        $path = $this->mkDir(resource_path('views'));

        $bladeFile = file_get_contents(__DIR__ . '/../../../stubs/laravel/resources/views/app.blade.php.stub');

        file_put_contents(resource_path('views/app.blade.php'), $bladeFile);

    }

    // VUE // 
    private function copyVueDir()
    {   

        $src = __DIR__ . '/../../../stubs/laravel/resources/vue';

        $dst = resource_path('vue');

        $this->cpDir($src, $dst);

    }

    // ROUTES //

    private function replaceWebRoutesFile()
    {

        $webRoutesFile = file_get_contents(__DIR__ . '/../../../stubs/laravel/routes/web.php.stub');

        file_put_contents(base_path('routes/web.php'), $webRoutesFile);

    }

    //////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////

    public function rrDir($path)
    {

        if(!file_exists($path)) {

            return true;

        }

        if(!is_dir($path)) {

            return unlink($path);

        }

        foreach(glob($path . '/*') as $item) {

            if(is_dir($item)) {

                $this->rrDir($item);

            } else {

                unlink($item);

            }

        }

        return rmdir($path);

    }

    public function mkDir($path)
    {

        if(!file_exists($path)) {

            mkdir($path, 0777, true);

        }

        if(is_dir($path)) {

            chmod($path, 0777);

        }

        return $path;

    }

    public function cpDir($src, $dst) {

        $dir = opendir($src);

        @mkdir($dst);

        while (($file = readdir($dir)) !== false) {

            if ($file != '.' && $file != '..') {

                if (is_dir($src . '/' . $file)) {

                    $this->cpDir($src . '/' . $file, $dst . '/' . $file);

                } else {

                    copy($src . '/' . $file, $dst . '/' . $file);

                }

            }
        }

        closedir($dir);

    }

}
