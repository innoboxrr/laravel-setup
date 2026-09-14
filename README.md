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

`app:install` actualiza las dependencias, crea las tablas, siembra el sitio de
ejemplo, enlaza el almacenamiento público, exporta las rutas para la interfaz y
la compila. Con `--pretend` enseña los pasos sin ejecutarlos, y con
`--without-build` no toca npm.

Regístrate con el correo de `ADMIN_EMAILS` y entra en `/admin`.

**`APP_URL` tiene que ser la dirección con la que abres la aplicación**, con su
puerto. El administrador llama a la API con la cookie de sesión, y Sanctum sólo
la acepta desde los dominios de `SANCTUM_STATEFUL_DOMAINS`: por omisión
`localhost`, `127.0.0.1:8000` y el de `APP_URL`. Con otra dirección, la sesión
se abre pero cada tabla del administrador responde 401 y te devuelve al login.

Para hacerlo todo de una vez: `php artisan app:init` (acepta `--react`).

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

`app:setup` reemplaza archivos como `bootstrap/app.php`, `routes/web.php` y
`package.json`. Sólo corre sobre una aplicación recién creada; en cualquier otra
se niega, salvo con `--force`.
