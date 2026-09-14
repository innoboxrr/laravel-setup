# laravel-setup

Convierte una aplicación Laravel 13 recién creada en la aplicación base del
ecosistema innoboxrr, en Vue o en React:

- **Sitio público** editable desde el administrador: inicio, únete, contacto,
  aviso de privacidad y términos, con un sitio de ejemplo completo.
- **Acceso** con [laravel-auth](https://github.com/innoboxrr/laravel-auth):
  iniciar sesión, registro, recuperar la contraseña, verificación de correo y
  suplantación para administradores.
- **Administrador** con menú que se construye solo, notificaciones, perfil con
  avatar y contraseña, editor del sitio y enlaces a los registros
  ([log-viewer](https://github.com/opcodesio/log-viewer)) y al editor del `.env`.
- **Usuarios generados con [LaraPack](https://github.com/innoboxrr/larapack-generator)**,
  con la misma arquitectura que cualquier otro modelo: API, políticas, tests y su
  módulo en el administrador. Lo que generes después aparece en el menú.

**Documentación completa** (español e inglés), con la instalación paso a paso,
Vue y React, el sitio, el administrador, el contrato de las interfaces y cómo
ampliarla: <https://innoboxrr.github.io/docs/app-base/>.

## Requisitos

- PHP 8.3 o superior y Composer.
- Node 20 o superior y npm 10.
- Una aplicación **recién creada** con `laravel new` o
  `composer create-project laravel/laravel`, con su base de datos configurada.

## Uso

```bash
composer require --dev innoboxrr/laravel-setup

php artisan app:setup            # Vue
php artisan app:setup --react    # React
```

`app:setup` no instala nada: escribe `composer.json`, `package.json`, la
configuración, las pantallas y el usuario generado. Revisa los cambios con
`git diff`, pon tu correo en `ADMIN_EMAILS` del `.env` y después:

```bash
php artisan app:install
composer run dev
```

`app:install` corre `composer update`, publica las migraciones de Sanctum y de
notificaciones, migra, siembra el sitio de ejemplo, enlaza el almacenamiento
público, exporta las rutas para la interfaz y la compila. Opciones:

| Opción | Qué hace |
|---|---|
| `--pretend` | Enseña los pasos sin ejecutarlos |
| `--without-build` | No toca npm |
| `--composer=<ruta>` | El Composer que usar. Un `composer.phar` se lanza con el mismo PHP que corre artisan (útil en Windows con Laragon, cuyo `composer` del PATH corre en PHP 8.2) |
| `--npm=<ruta>` | El npm que usar |

Regístrate con el correo de `ADMIN_EMAILS` y entra en `/admin`.

**`APP_URL` tiene que ser la dirección con la que abres la aplicación**, con su
puerto. El administrador llama a la API con la cookie de sesión, y Sanctum sólo
la acepta desde los dominios de `SANCTUM_STATEFUL_DOMAINS`: por omisión
`localhost`, `localhost:3000`, `127.0.0.1`, `127.0.0.1:8000`, `::1` y el de
`APP_URL`. Con otra dirección, la sesión se abre pero cada tabla del
administrador responde 401 y te devuelve al login.

Para hacerlo todo de una vez: `php artisan app:init [dominio] [--react] [--force]
[--without-build]`. No pasa `--composer` ni `--npm` a `app:install`: en Windows
con un `composer.phar`, corre `app:setup` y `app:install` por separado.

> **Cuidado con el dominio.** Pasar un dominio a `app:init` llama a
> `configure:domain`, que sólo funciona con Laragon instalado en `C:\laragon`,
> edita el archivo `hosts` con permisos de administrador y escribe una
> configuración de nginx con protocolos TLS y cifrados inseguros. No se
> recomienda: configura el dominio a mano.

## Qué queda en la aplicación

| Dónde | Qué | De quién |
|---|---|---|
| `resources/<ui>/app/` | Sitio, acceso, administrador, estados y rutas | Tuyo desde que se instala |
| `resources/<ui>/index.js`, `resources/<ui>/src/` | Los módulos generados | De LaraPack: se regeneran |
| `laraimport.json` | La declaración del usuario y de lo que añadas | Tuyo |
| `database/seeders/SiteOptionsSeeder.php` | El sitio de ejemplo | Tuyo |
| `app/Http/Middleware/EnsureUserIsAdmin.php` | El middleware `admin` | Tuyo |
| `config/auth.php` → `admins` | Quién administra: `ADMIN_EMAILS` | Tuyo |

El contrato que cumplen las dos interfaces (rutas, guardas, menú, formato del
sitio y props de cada sección) está en
[docs/shell-contract.md](docs/shell-contract.md).

## Añadir un modelo

Se declara en `laraimport.json` y se genera como en cualquier proyecto con
LaraPack:

```bash
php artisan larapack:validate laraimport.json --vue
php artisan larapack:import laraimport.json --vue
php artisan migrate
php artisan route:json
npm run build
```

Su pantalla aparece sola en el menú del administrador. Para que sólo la vea un
administrador, añade el nombre de su ruta a `adminOnly` en
`resources/<ui>/app/config.js`.

## Advertencia

`app:setup` sólo corre sobre una aplicación recién creada; en cualquier otra se
niega, salvo con `--force`, porque:

- **Reemplaza** `bootstrap/app.php`, `bootstrap/providers.php`, `routes/web.php`,
  `app/Providers/AppServiceProvider.php`, `package.json` y `vite.config.js`.
- **Borra** `resources/views/welcome.blade.php`, `resources/js`, `resources/css`
  y `app/Models/User.php`, que se genera de nuevo con LaraPack.
- **Fija en el `.env`** `APP_LOCALE=es`, `APP_FALLBACK_LOCALE=en`,
  `APP_FAKER_LOCALE=es_MX` y `SESSION_DRIVER=database`, y añade las claves que
  falten sin pisar las que ya tengas.
