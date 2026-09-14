<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        {{-- El modo oscuro elegido se aplica antes de pintar: sin esto la página
             parpadea en claro hasta que arranca la aplicación. --}}
        <script>
            try {
                var theme = localStorage.getItem('theme');
                if (theme === 'dark' || theme === 'light') {
                    document.documentElement.dataset.theme = theme;
                }
            } catch (e) {}
        </script>

        @vite('resources/vue/app/main.js')
    </head>
    <body>
        <div id="app"></div>
    </body>
</html>
