# Changelog

## 7.0.0

Reescrito para Laravel 13. La versión anterior montaba una interfaz de Laravel
10 con Vuex, UIkit, Flowbite y Tailwind 3, pedía versiones de los paquetes que
ya no arrancaban y muchas pantallas no funcionaban.

- **Vue o React** (`app:setup --react`): la misma aplicación, con el contrato de
  `docs/shell-contract.md`, sobre form-core y con modo oscuro.
- **El usuario lo genera LaraPack** con `authenticatable`: API, políticas, tests
  y su módulo en el administrador. Cada quien puede ver y editar su propia cuenta.
- **Sitio editable** con las secciones del theme-manager de siempre, en el mismo
  formato de opciones, y un sitio de ejemplo completo en `SiteOptionsSeeder`.
- **Administrador** con menú que se construye desde las rutas de los módulos,
  notificaciones, perfil, editor del sitio, y enlaces a los registros y al `.env`
  sólo para quien está en `ADMIN_EMAILS`.
- **`app:install` por pasos**, con `--pretend` y `--without-build`; ya no borra
  `composer.lock` ni usa `cp`.
- **Las versiones de los paquetes** viven en `Dependencies`, en las publicadas
  para Laravel 13. `lab404/laravel-impersonate` se quita: lo sustituye
  laravel-auth.
- **No toca una aplicación que no es nueva** sin `--force`, y no pisa lo que el
  `.env` ya decidió.
- **Probada en un navegador**, en Vue y en React, sobre una aplicación Laravel 13
  recién creada: instalar, sitio y su editor, registro, perfil con contraseña y
  foto, usuarios sólo para administradores y un modelo nuevo generado con
  LaraPack que aparece en el menú. Lo que encontró se corrigió en laravel-auth
  6.0.2 y 6.0.3 y en LaraPack 7.10.1 y 7.10.2, que son las versiones mínimas que
  pide.
- **Genera y registra el proveedor de eventos**: sin él, exportar desde el
  administrador no avisaba.

### Para aplicaciones creadas con la 6.x

No hay migración automática: la 7 es para aplicaciones nuevas.
