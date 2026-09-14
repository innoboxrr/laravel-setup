<?php

namespace Innoboxrr\LaravelSetup\Support;

/**
 * Lee y cambia claves de un archivo .env sin tocar lo demás.
 *
 * El editor anterior sustituía con una expresión que no escapaba la clave ni el
 * valor, escribía la clave en .env.example siempre vacía, y cada llamada
 * guardaba los dos archivos. Aquí cada archivo se edita por separado, las claves
 * se buscan literalmente y los valores con espacios o `#` se entrecomillan.
 */
final class EnvFile
{
    private string $contents;

    public function __construct(private readonly string $path)
    {
        $this->contents = is_file($path) ? (string) file_get_contents($path) : '';
    }

    public function has(string $key): bool
    {
        return preg_match($this->pattern($key), $this->contents) === 1;
    }

    public function get(string $key): ?string
    {
        if (! preg_match($this->pattern($key), $this->contents, $match)) {
            return null;
        }

        $value = trim($match[1]);

        if (strlen($value) >= 2 && $value[0] === '"' && str_ends_with($value, '"')) {
            return stripcslashes(substr($value, 1, -1));
        }

        return $value;
    }

    /**
     * Cambia la clave si existe, o la añade al final.
     */
    public function set(string $key, string $value): self
    {
        $line = $key.'='.$this->format($value);

        if ($this->has($key)) {
            $this->contents = (string) preg_replace_callback($this->pattern($key), fn (): string => $line, $this->contents, 1);

            return $this;
        }

        $this->contents = rtrim($this->contents, "\r\n").($this->contents === '' ? '' : "\n").$line."\n";

        return $this;
    }

    /**
     * Sólo si la clave no está: para no pisar lo que ya decidió la aplicación.
     */
    public function setIfMissing(string $key, string $value): self
    {
        return $this->has($key) ? $this : $this->set($key, $value);
    }

    /**
     * @param  array<string, string>  $values
     */
    public function setMany(array $values, bool $onlyMissing = false): self
    {
        foreach ($values as $key => $value) {
            $onlyMissing ? $this->setIfMissing($key, $value) : $this->set($key, $value);
        }

        return $this;
    }

    public function save(): void
    {
        file_put_contents($this->path, $this->contents);
    }

    public function contents(): string
    {
        return $this->contents;
    }

    private function pattern(string $key): string
    {
        return '/^'.preg_quote($key, '/').'=(.*)$/m';
    }

    /**
     * Un valor con espacios, `#` o comillas va entre comillas dobles. Las
     * referencias como `${APP_NAME}` se dejan tal cual.
     */
    private function format(string $value): string
    {
        if ($value === '' || preg_match('/^[A-Za-z0-9_\-.:\/@,${}]+$/', $value)) {
            return $value;
        }

        if (strlen($value) >= 2 && $value[0] === '"' && str_ends_with($value, '"')) {
            return $value;
        }

        return '"'.addcslashes($value, '"\\').'"';
    }
}
