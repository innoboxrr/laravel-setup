<?php

namespace App\Services\App;

use Illuminate\Support\Facades\Log;

class BotDetectionService
{
    protected $robotsFile;

    public function __construct()
    {
        $this->robotsFile = storage_path('app/files/bots-list.txt'); // Ruta al archivo con la lista de bots
    }

    /**
     * Determina si el visitante es un bot.
     *
     * @param string|null $userAgent El User-Agent a evaluar. Si no se proporciona, se utiliza el User-Agent actual.
     * @return bool
     */
    public function isBot(string $userAgent = null): bool
    {
        $userAgent = $userAgent ?: request()->header('User-Agent');
        $userAgent = strtolower(trim($userAgent));

        if (empty($userAgent)) {
            return false;
        }

        // Obtener la lista de bots desde el archivo
        $robotsList = $this->getRobotsList();

        // Verificar si el User-Agent coincide con algún bot en la lista
        foreach ($robotsList as $bot) {
            if (strpos($userAgent, strtolower(trim($bot))) !== false) {
                $this->logBot($userAgent); // Registrar en log personalizado
                return true;
            }
        }

        return false;
    }

    /**
     * Lee y devuelve la lista de bots desde el archivo.
     *
     * @return array
     */
    protected function getRobotsList(): array
    {
        if (!file_exists($this->robotsFile)) {
            throw new \Exception("El archivo de robots no existe: {$this->robotsFile}");
        }

        // Leer el archivo y devolver cada línea como un elemento del array
        $robotsList = file($this->robotsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return $robotsList;
    }

    /**
     * Registra en el log personalizado cuando se detecta un bot.
     *
     * @param string $userAgent El User-Agent del bot.
     * @return void
     */
    protected function logBot(string $userAgent): void
    {
        Log::channel('bots')->info('Bot detectado', ['user-agent' => $userAgent]);
    }
}
