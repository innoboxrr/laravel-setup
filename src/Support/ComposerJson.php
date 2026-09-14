<?php

namespace Innoboxrr\LaravelSetup\Support;

use JsonException;

/**
 * Cambia el composer.json de la aplicación.
 *
 * El editor anterior llamaba a `array_has` y `array_forget`, helpers que Laravel
 * quitó hace años, y lanzaba `Exception` sin importarla: cualquier camino que no
 * fuera añadir una clave terminaba en un error fatal.
 */
final class ComposerJson
{
    /**
     * @var array<string, mixed>
     */
    private array $data;

    /**
     * @throws JsonException
     */
    public function __construct(private readonly string $path)
    {
        $this->data = json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Añade o sube las dependencias. Una que ya está con otra versión se
     * reemplaza: es lo que pide la línea base de la aplicación.
     *
     * @param  array<string, string>  $packages
     */
    public function require(array $packages, bool $dev = false): self
    {
        $section = $dev ? 'require-dev' : 'require';

        foreach ($packages as $name => $constraint) {
            // Una dependencia no puede estar a la vez en require y require-dev.
            unset($this->data[$dev ? 'require' : 'require-dev'][$name]);

            $this->data[$section][$name] = $constraint;
        }

        $this->sort($section);

        return $this;
    }

    /**
     * @param  array<int, string>  $packages
     */
    public function remove(array $packages): self
    {
        foreach ($packages as $name) {
            unset($this->data['require'][$name], $this->data['require-dev'][$name]);
        }

        return $this;
    }

    public function requires(string $package): ?string
    {
        return $this->data['require'][$package] ?? $this->data['require-dev'][$package] ?? null;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->data;
    }

    public function save(): void
    {
        file_put_contents(
            $this->path,
            json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)."\n"
        );
    }

    /**
     * Composer ordena así cuando `sort-packages` está activo, como en el
     * esqueleto de Laravel: php y las extensiones primero, luego por nombre.
     */
    private function sort(string $section): void
    {
        if (! isset($this->data[$section]) || ! is_array($this->data[$section])) {
            return;
        }

        uksort($this->data[$section], function (string $a, string $b): int {
            $rank = fn (string $name): int => match (true) {
                $name === 'php' => 0,
                str_starts_with($name, 'ext-') => 1,
                default => 2,
            };

            return [$rank($a), $a] <=> [$rank($b), $b];
        });
    }
}
