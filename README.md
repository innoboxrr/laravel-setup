# AppSetupCommand

El comando `AppSetupCommand` es una herramienta útil para configurar una nueva aplicación de Laravel. Este comando se encarga de realizar varias tareas de configuración que pueden ser tediosas de realizar manualmente.

## Funcionalidad

El comando `AppSetupCommand` realiza las siguientes tareas de configuración:

 - Verifica si NodeJS está instalado en el sistema y si la versión es compatible con la aplicación de Laravel.
 - Reemplaza el archivo package.json con una versión predefinida.
 - Reemplaza el archivo vite.config.js con una versión predefinida.
 - Agrega el archivo app/Helpers/app.php a la sección de autoload del archivo composer.json.
 - Agrega el archivo app/Http/Controllers/AppController.php a la aplicación de Laravel.
 - Agrega los paquetes innoboxrr/routes-to-json y innoboxrr/laravel-auth al archivo composer.json.
 - Agrega los archivos CSS y JS predefinidos a la aplicación de Laravel.
 - Agrega el archivo resources/json/nav.json a la aplicación de Laravel.
 - Elimina el archivo resources/views/welcome.blade.php.
 - Crea el archivo resources/views/app.blade.php.
 - Copia el directorio resources/vue a la aplicación de Laravel.
 - Reemplaza el archivo routes/web.php con una versión predefinida.


## Instrucciones de uso

Para utilizar el comando `AppSetupCommand`, debes ejecutar el siguiente comando en la terminal:

`php artisan app:setup`


Este comando ejecutará todas las tareas de configuración descritas anteriormente.

Al finalizar la instalación debe ejecutar los siguintes comandos:

`composer update`

`npm install`

`php artisan route:json`

Después arranca el servidor con

`php artisan serve`

Y compila los assets con

`npm run dev`

Si lo deseas compilar para producción ejecuta

`npm run prod`

## Nota

Este comando debe ser utilizado con precaución, ya que realiza cambios importantes en la aplicación de Laravel. Si no estás seguro de lo que estás haciendo, es recomendable que realices una copia de seguridad de la aplicación antes de ejecutar este comando.
