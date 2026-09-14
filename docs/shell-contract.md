# El contrato de las interfaces de la aplicación base

`app:setup` monta la interfaz en Vue o en React. Las dos son la misma aplicación:
mismas rutas, mismas pantallas, mismo JSON del sitio y mismas llamadas al
backend. Este documento es lo que ambas cumplen; si una cambia algo de aquí, la
otra cambia igual.

## Dónde vive cada cosa

```
stubs/app/common/            backend, igual para las dos
stubs/app/<ui>/              se copia sobre la raíz de la aplicación
  package.json
  vite.config.js
  resources/views/app.blade.php
  resources/<ui>/app/**      la aplicación base (lo de este documento)
  resources/<ui>/routes.json marcador; `php artisan route:json` lo reescribe
resources/<ui>/index.js      el módulo de LaraPack (lo genera larapack:import)
resources/<ui>/src/**        sus modelos: usuarios y lo que se genere después
tests/Frontend/<ui>/         tests de la interfaz, fuera de lo que se copia
```

`resources/<ui>/app/**` es de laravel-setup. `resources/<ui>/index.js` y
`resources/<ui>/src/**` son de LaraPack: la aplicación base los importa y nunca
los edita.

## Arranque

1. `axios.defaults`: `withCredentials`, `withXSRFToken`, `Accept:
   application/json`, `X-Requested-With: XMLHttpRequest`. Una sola copia de axios.
2. `setRoutes(routes.json)` de `innoboxrr-route-resolver`. Ninguna URL del backend
   se escribe a mano: todas salen de `route(nombre)`.
3. `addTranslations` con las del módulo de LaraPack y las de
   `resources/<ui>/app/lang/*.json`; `setLocale(document.documentElement.lang)`.
   Los textos de la aplicación base van con `t('English key')` y su traducción en
   `lang/es.json`.
4. `innoboxrr-form-core/styles` y el `src/theme.js` del módulo, si existe.
5. Cargar la sesión (`auth`) y las opciones (`options`) antes de montar el router.
6. `ToastRegion` y `ConfirmHost` una vez, en la raíz.

## Rutas del front

| Ruta | Nombre | Acceso | Pantalla |
|---|---|---|---|
| `/` | `site.home` | todos | página `home` del sitio |
| `/privacy` | `site.privacy` | todos | página `privacy` |
| `/terms` | `site.terms` | todos | página `terms` |
| `/contact` | `site.contact` | todos | página `contact` |
| `/join` | `site.join` | todos | página `join` |
| `/auth/login` | `auth.login` | invitado | iniciar sesión; respeta `?redirect=` |
| `/auth/register` | `auth.register` | invitado | registro |
| `/auth/forgot-password` | `auth.forgot-password` | invitado | pedir el enlace |
| `/auth/reset-password/:token/:email` | `auth.reset-password` | invitado | nueva contraseña (es la URL del correo de laravel-auth) |
| `/admin` | `admin.dashboard` | sesión | inicio del administrador |
| `/admin/profile` | `admin.profile` | sesión | perfil: nombre, correo, avatar, contraseña |
| `/admin/site` | `admin.site` | administrador | editor del sitio |
| `/admin/<modelo>/...` | los del módulo | sesión (y administrador si está en `adminOnly`) | las rutas que exporta el módulo de LaraPack, hijas de `/admin` |
| cualquier otra | `not-found` | todos | 404 |

Los nombres de ruta del front no chocan con los del backend porque viven en otro
registro (router del front frente a `routes.json`).

**Guardas.** `meta.guest` (o `handle.guest` en React) manda a `/admin` a quien ya
tiene sesión. `meta.auth` manda a `/auth/login?redirect=<ruta>` a quien no la
tiene; las rutas del módulo traen `auth: true`. `meta.admin`, o estar en
`adminOnly`, exige `is_admin`; sin él, a `/admin` con un aviso.

**`resources/<ui>/app/config.js`** exporta `adminOnly`: los nombres (Vue) o ids
(React) de las rutas del módulo que sólo ve un administrador. Por omisión, la de
usuarios.

## El menú del administrador

Se construye, no se escribe: cada ruta de primer nivel del módulo con título
(`meta.title` / `handle.title`) y sin parámetros es una entrada. Las de
`adminOnly` sólo se muestran a un administrador. Además:

- Inicio (`admin.dashboard`), siempre primero.
- Grupo «Administración», sólo administrador: las rutas de `adminOnly`, «Sitio»
  (`admin.site`), «Registros» (`/log-viewer`, pestaña nueva) y «Entorno»
  (`/env-editor`, pestaña nueva).

Un modelo que se genere después aparece solo en el menú al compilar.

## Estado

**auth**
- `load()`: GET `route('auth.get.auth')` → `{user, authenticated, is_admin,
  verified, impersonating}`.
- `login({email, password, remember})`: primero GET `/sanctum/csrf-cookie`
  (`route('sanctum.csrf-cookie')` si está en routes.json), luego el POST de
  `auth.login`, luego `load()`.
- `register`, `logout`, `forgotPassword`, `resetPassword`, `updatePassword`,
  `resendVerification`, `revertImpersonation`: las rutas de laravel-auth 6, con
  nombres con punto (`auth.register`, `auth.logout`, `auth.forgot.password`,
  `auth.reset.password`, `auth.update.password`,
  `auth.email.verification.notification`, `auth.revert.impersonate`).
- `?redirect=` sólo acepta rutas internas (empiezan por `/` y no por `//`).
- Un 401 fuera de `load()` limpia la sesión y manda al login. Un 419 pide otra vez
  la cookie CSRF y repite la petición una vez.

**options**
- `load()`: GET `route('api.laravel-options.option.index', {paginate: 0})`, que es
  público. Guarda `key → value` y el `id` de cada opción. Un `value` que es un
  objeto o un array JSON se guarda decodificado; cualquier otro texto se queda
  como texto (un `site_name` "2024" no se vuelve número), igual que
  `Option::value()` en el backend.
- `option(path, default)`: `option('site_name')`, `option('theme.home')` (entra en
  el JSON con puntos).
- `save(key, value)`: el update de laravel-options (sólo administrador) con
  `option_id`, `name`, `key` y el `value` serializado a JSON si no es texto; si
  la opción no existe todavía, su create. Actualiza el estado.

**notifications** (laravel-notifications 2.1)
- Contador de no leídas al montar el administrador, cada 60 s y al volver a la
  pestaña. Lista de las últimas al abrir la campana.
- Marcar una como leída y navegar a `data.action`: una ruta interna con el
  router, una URL absoluta con `location`. Marcar todas.
- `data.message` se pinta como texto, nunca como HTML.

## El administrador

Layout con `fe-shell`: cabecera (nombre del sitio, botón del menú en móvil con
fondo que lo cierra, campana, modo oscuro, menú de usuario) y barra lateral con el
menú.

- **Aviso de suplantación** cuando `impersonating`: «Estás viendo la cuenta de
  …» y «Volver a mi cuenta».
- **Aviso de verificación** cuando `verified === false`: reenviar el correo.
- **Menú de usuario**: Perfil, Cerrar sesión.
- **Modo oscuro**: `data-theme` en `<html>`, recordado en `localStorage`; sin
  elección, el del sistema.
- **Inicio**: saludo y una tarjeta por entrada del menú.
- **Perfil**: nombre y correo con el `update` del usuario generado
  (`api.app.user.update`, campos `user_id`, `name`, `email`); avatar subido con
  laravel-uploads (`lu.upload.file`, campo `file`) y guardado como meta `avatar`
  con el mismo update, con el `uri` relativo de la subida (quitarla envía
  `avatar: ''`); contraseña con el `update-password` de laravel-auth.
- **Editor del sitio** (ver abajo).

## El sitio

Las páginas se pintan desde la opción `theme` (la siembra `SiteOptionsSeeder`).
Es el formato del theme-manager de siempre, así que el contenido de una
aplicación antigua se sigue viendo:

```json
{
    "home": {
        "title": "Inicio",
        "sections": [
            { "theme": "legacy", "group": "hero", "name": "HeroOne", "props": { "display": true, "title": "..." } }
        ]
    },
    "privacy": { "title": "...", "sections": [] },
    "terms": { "title": "...", "sections": [] },
    "contact": { "title": "...", "sections": [] },
    "join": { "title": "...", "sections": [] }
}
```

- Cada sección se busca en el registro por `<theme>/<group>/<name>`; una que no
  existe no se pinta (y avisa en consola).
- Una sección con `props.display` `false` o `"false"` no se pinta; sin la clave,
  sí.
- El título de la pestaña es `<título de la página> · <site_name>`.
- Toda imagen es opcional: sin ella la sección se ve bien (sin hueco roto).
- Los estilos salen de las variables de form-core (`--fe-*`), así que el sitio
  tiene modo oscuro. Sin Tailwind, sin Headless UI, sin Heroicons: los iconos con
  el `Icon` de form-elements.

### Las secciones y sus props

| Sección | Props |
|---|---|
| `legacy/header/HeaderOne` | `logo`, `nav: [{label, link}]`, `facebook`, `twitter`, `instagram`, `youtube`, `whatsapp`, `linkedin`, `tiktok`. Muestra «Entrar» o «Administrador» según la sesión. |
| `legacy/hero/HeroOne` | `badge`, `badge_value`, `badge_link`, `title`, `message`, `primary_button_text`, `primary_button_link`, `secondary_button_text`, `secondary_button_link`, `videos: [url]` (uno al azar) |
| `legacy/hero/HeroTwo` | los de HeroOne sin `videos`, más `badge_value_link`, `video`, `display_play_button`, `play_button_text`, `imgs_1`, `imgs_2`, `imgs_3: [url]` |
| `legacy/hero/HeroThree` | los de HeroOne sin `videos` |
| `legacy/section/MissionSection` | `title`, `subtitle`, `message`, `button_text`, `button_link`, `images: [url]` (hasta 4) |
| `legacy/section/JoinSection` | `title`, `subtitle`, `image`, `features: [texto]`, `button_text`, `button_link` |
| `legacy/section/FaqSection` | `title`, `subtitle`, `items: [{question, answer}]` |
| `legacy/section/PartnersSection` | `title`, `items: [{name, logo, link}]` |
| `legacy/section/TestimonialsSection` | `title`, `subtitle`, `feature: {body, author: {name, handle, image}}`, `items: [{body, author: {name, handle, image}}]` |
| `legacy/section/PlansSection` | `title`, `subtitle`, `frequencies: [{value, label, price_suffix}]`, `tiers: [{id, name, href, description, price: {<frequency>: texto}, features: [texto], most_popular}]` |
| `legacy/section/HtmlContent` | `content`: HTML que escribe el administrador |
| `legacy/footer/FooterOne` | `logo`, `description`, `cols: [{title, items: [{name, link}]}]`, `newsletter: {title, subtitle, button_text, button_link}`, `social_links: {facebook, instagram, twitter, github, youtube, linkedin, tiktok, whatsapp}` |
| `legacy/cookie-consent/CookieConsentOne` | `message`, `accept_text`, `reject_text`, `policy_link`. Guarda la decisión en la cookie `cookie_consent` (`accepted` / `rejected`) y no vuelve a salir. |

Un enlace que empieza por `/` navega con el router; cualquier otro es un enlace
normal.

### El editor del sitio

`/admin/site`, sólo administrador:

- `site_name` y `site_description`.
- Una pestaña por página. En cada una, sus secciones en orden: activar o
  desactivar (`display`), subir, bajar, quitar, y añadir una del registro.
- Las props de cada sección en un editor JSON (CodeMirror, `json`): un JSON
  inválido se marca y no deja guardar.
- «Ver página» abre la página en otra pestaña.
- Guardar escribe la opción `theme` con `options.save` y avisa con un toast; un
  422 enseña el error.
