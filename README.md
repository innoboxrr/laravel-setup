# LaravelSetUp: ¡Pon tu aplicación Laravel en marcha en minutos!

¿Estás cansado de configurar manualmente una aplicación Laravel cada vez que inicias un nuevo proyecto? ¡Te presentamos **LaravelSetUp** de **InnoboxRR**! Esta poderosa herramienta te permite arrancar tu desarrollo en **Laravel** en cuestión de **minutos**, automatizando todas las configuraciones tediosas y necesarias para que puedas concentrarte en lo que realmente importa: **crear algo increíble**.

Con solo un par de comandos, tendrás un proyecto Laravel completamente listo, equipado con configuraciones optimizadas, archivos esenciales y paquetes clave para acelerar tu flujo de trabajo.

## ¿Qué hace LaravelSetUp por ti?

**LaravelSetUp** realiza un conjunto completo de configuraciones en tu aplicación Laravel que, de otro modo, tomarían tiempo y esfuerzo. Este paquete te facilita la vida realizando tareas como:

- **Verificación de NodeJS**: Asegúrate de que tienes la versión adecuada de NodeJS instalada para que tu aplicación Laravel funcione perfectamente.
- **Optimización de `package.json` y `vite.config.js`**: Reemplaza estos archivos con versiones predefinidas y optimizadas para el desarrollo moderno.
- **Soporte para helpers**: Agrega el archivo `app/Helpers/app.php` a la sección de autoload en `composer.json`, asegurando que tus helpers personalizados siempre estén disponibles.
- **Controladores precargados**: Añade el archivo `app/Http/Controllers/AppController.php` para que puedas empezar con controladores listos para usar.
- **Instalación de paquetes clave**: Integra automáticamente los paquetes `innoboxrr/routes-to-json` y `innoboxrr/laravel-auth` para mejorar la gestión de rutas y autenticación en tu aplicación.
- **Estilos y scripts preconfigurados**: Agrega archivos CSS y JS predefinidos para que tengas un punto de partida con los mejores estilos y scripts para tu aplicación.
- **Archivos JSON de navegación**: Carga automáticamente un archivo `resources/json/nav.json` para configurar la navegación de tu aplicación.
- **Elimina el archivo innecesario** `welcome.blade.php` y lo reemplaza con un archivo base `app.blade.php` listo para el desarrollo.
- **Copia la estructura Vue.js**: Integra automáticamente el directorio `resources/vue` para que tengas tu frontend preparado para empezar a construir interfaces dinámicas.
- **Actualización de rutas**: Reemplaza el archivo `routes/web.php` con una versión mejorada y optimizada para tu flujo de trabajo.

## ¿Cómo usar LaravelSetUp?

Configurar tu aplicación Laravel nunca fue tan fácil. Solo necesitas ejecutar los siguientes comandos en tu terminal:

## Opción A.

### Paso 1: Configurar la aplicación

```bash
php artisan app:setup
```
Este comando configurará todos los aspectos clave de tu aplicación Laravel para que esté lista en minutos.

### Paso 2: Instalar los paquetes
```bash
php artisan app:install
```
Instala automáticamente todos los paquetes y configuraciones necesarias para tu aplicación.

### Paso 3: Configuración del dominio
```bash
php artisan configure:domain mydomain.test
```
Configura el dominio que utilizarás para tu entorno de desarrollo en Laravel.

### Paso 4: Compilar tus assets
Para producción:

```bash
npm run build
```

Para desarrollo:

```bash
npm run dev
```

## Opción B (Beta):

Si prefieres una intalación más rápida puedes ejecutar simplemente:

```bash
php artisan app:init mydomain.test
``` 

Y después compilar tus assets
Para producción:

```bash
npm run build
```

Para desarrollo:

```bash
npm run dev
```

## Advertencia

**LaravelSetUp** está diseñado únicamente para ser utilizado durante el **setup inicial** de la aplicación. Una vez configurada tu aplicación, **no debe ejecutarse nuevamente**, ya que podría sobrescribir archivos importantes y causar daños en la configuración existente. Asegúrate de usarlo solo al inicio del proyecto y de realizar una copia de seguridad antes de su uso en cualquier entorno.
