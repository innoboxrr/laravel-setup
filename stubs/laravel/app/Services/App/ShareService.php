<?php

namespace App\Services\App;

use App\Services\App\BotDetectionService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

class ShareService
{
    protected static $botDetectionService;

    public static function share($url, $forceBot = false)
    {
        if (!$url) {
            return response('URL no proporcionada', 400);
        }

        $path = parse_url($url, PHP_URL_PATH);

        $mapPaths = config('shareable');

        foreach ($mapPaths as $routeName => $pattern) {
            $patternRegex = preg_replace('/\{[^\}]+\}/', '([^\/]+)', $pattern);
            if (preg_match('#^' . $patternRegex . '$#', $path, $matches)) {
                array_shift($matches);

                preg_match_all('/\{([^\}]+)\}/', $pattern, $paramNames);
                $params = array_combine($paramNames[1], $matches);

                // Convertir los parámetros en modelos de Laravel
                foreach ($params as $key => $value) {
                    $params[$key] = self::resolveModel($key, $value);
                }

                if (self::isBot() || $forceBot) {
                    return View::make('share.show-certificate', $params);
                } else {
                    return redirect()->to($url);
                }
            }
        }
        return response('Ruta no encontrada', 404);
    }

    protected static function resolveModel(string $key, $value)
    {
        $modelClass = Str::studly($key);

        if (strpos($modelClass, '.') !== false) {
            $modelClass = str_replace('.', '\\', $modelClass);
        } else {
            $modelClass = 'App\\Models\\' . $modelClass;
        }

        if (class_exists($modelClass)) {
            return App::make($modelClass)->findOrFail($value);
        }

        throw new \Exception("El modelo {$modelClass} no existe.");
    }

    protected static function isBot()
    {
        // Asegurarse de que el servicio de detección de bots esté instanciado
        if (is_null(self::$botDetectionService)) {
            self::$botDetectionService = new BotDetectionService();
        }

        return self::$botDetectionService->isBot();
    }
}
