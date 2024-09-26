<?php

namespace Innoboxrr\LaravelSetup\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ConfigureDomain extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'configure:domain {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configura un nuevo dominio para el entorno de desarrollo en Laragon con Nginx y modifica el archivo hosts y el .env automáticamente';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Obtener el dominio desde los argumentos
        $domain = $this->argument('domain');

        // Modificar el archivo hosts
        $this->modifyHostsFile($domain);

        // Modificar configuración de Nginx en Laragon
        $this->modifyNginxConfig($domain);

        // Actualizar el archivo .env
        $this->updateEnvFile($domain);

        // Reiniciar Nginx
        $this->restartNginx();

        $this->info("El dominio {$domain} ha sido configurado correctamente.");
        return 0;
    }

    /**
     * Modifica el archivo hosts de Windows pidiendo permisos de administrador.
     */
    private function modifyHostsFile($domain)
    {
        // Ruta al archivo hosts
        $hostsFilePath = 'C:\Windows\System32\drivers\etc\hosts';
        // Comando que se va a agregar al archivo hosts
        $lineToAdd = "127.0.0.1\t" . $domain . "# Dominio configurado automáticamente por Laravel" . PHP_EOL;

        // Crear el contenido del archivo .bat para modificar el archivo hosts con permisos de administrador
        $batchContent = "
@echo off
:: Verifica si se está ejecutando como administrador
NET SESSION >nul 2>&1
if %errorLevel% == 0 (
    echo Modificando el archivo hosts...
    echo 127.0.0.1 {$domain} # Add by Laravel Setup >> \"{$hostsFilePath}\"
    exit /b
) else (
    echo Solicitando permisos de administrador...
    powershell -Command \"Start-Process cmd -ArgumentList '/c %~dpnx0' -Verb RunAs\"
    exit /b
)
";

        // Guardar el archivo .bat en la raíz del proyecto
        $batFilePath = base_path('update_hosts.bat');
        file_put_contents($batFilePath, $batchContent);

        // Ejecutar el archivo .bat automáticamente solicitando permisos de administrador
        $output = null;
        $returnVar = null;
        exec("start /wait {$batFilePath}", $output, $returnVar);

        // Verificar si el archivo fue modificado correctamente
        if ($returnVar == 0) {
            $this->info('El archivo hosts ha sido modificado correctamente.');
            // Eliminar el archivo .bat después de la ejecución
        if (File::exists($batFilePath)) {
            File::delete($batFilePath);
            $this->info('El archivo update_hosts.bat ha sido eliminado.');
        }
        } else {
            $this->error('No se pudo modificar el archivo hosts. Por favor, ejecuta el comando como administrador.');
        }
    }

    /**
     * Modifica la configuración de Nginx en Laragon.
     */
    private function modifyNginxConfig($domain)
    {
        // Ruta donde se encuentran los archivos de configuración de Nginx en Laragon
        $nginxConfigPath = 'C:\laragon\etc\nginx\sites-enabled\\' . $domain . '.conf';

        // Obtener la ruta pública de la aplicación Laravel actual
        $rootPath = public_path();

        // Contenido del archivo de configuración de Nginx para el nuevo dominio
        $nginxConfigContent = "
server {
    listen 80;
    listen 443 ssl;
    server_name {$domain};
    root \"{$rootPath}\";
    
    index index.html index.htm index.php;

    # Access Restrictions
    allow 127.0.0.1;
    deny all;

    include \"C:/laragon/etc/nginx/alias/*.conf\";

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass php_upstream;
    }

    # Enable SSL
    ssl_certificate \"C:/laragon/etc/ssl/laragon.crt\";
    ssl_certificate_key \"C:/laragon/etc/ssl/laragon.key\";
    ssl_session_timeout 5m;
    ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
    ssl_ciphers ALL:!ADH:!EXPORT56:RC4+RSA:+HIGH:+MEDIUM:+LOW:+SSLv3:+EXP;
    ssl_prefer_server_ciphers on;

    charset utf-8;

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    location ~ /\.ht {
        deny all;
    }
}
";

        // Crear el archivo de configuración para el nuevo dominio
        if (file_put_contents($nginxConfigPath, $nginxConfigContent)) {
            $this->info('El archivo de configuración de Nginx ha sido actualizado.');
        } else {
            $this->error('No se pudo escribir en la configuración de Nginx.');
        }
    }

    /**
     * Modifica el archivo .env de la aplicación.
     */
    private function updateEnvFile($domain)
    {
        // Ruta al archivo .env
        $envFilePath = base_path('.env');

        // Verificar si el archivo .env existe
        if (File::exists($envFilePath)) {
            // Leer el contenido del archivo .env
            $envContent = File::get($envFilePath);

            // Reemplazar APP_URL y SESSION_DOMAIN
            $envContent = preg_replace('/APP_URL=.*\n/', "APP_URL=https://{$domain}\n", $envContent);
            $envContent = preg_replace('/SESSION_DOMAIN=.*\n/', "SESSION_DOMAIN=.{$domain}\n", $envContent);

            // Escribir los cambios en el archivo .env
            File::put($envFilePath, $envContent);

            $this->info('.env ha sido actualizado con APP_URL y SESSION_DOMAIN.');
        } else {
            $this->error('No se encontró el archivo .env');
        }
    }

    /**
     * Reinicia el servidor Nginx en Laragon.
     */
    private function restartNginx()
    {
        $this->info('Reinicia el servidor Nginx...');
    }
}
