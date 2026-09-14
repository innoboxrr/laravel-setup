<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        {{-- El modo oscuro elegido se aplica antes de pintar: si esperara a React, la página parpadearía en claro. --}}
        <script>
            try {
                const theme = localStorage.getItem('theme');

                if (theme === 'dark' || theme === 'light') {
                    document.documentElement.dataset.theme = theme;
                }
            } catch (error) {}
        </script>

        @viteReactRefresh
        @vite('resources/react/app/main.jsx')
    </head>
    <body>
        <div id="app"></div>

        <noscript>{{ config('app.name') }} necesita JavaScript.</noscript>
    </body>
</html>
