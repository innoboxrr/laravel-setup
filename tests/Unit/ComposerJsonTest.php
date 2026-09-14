<?php

namespace Innoboxrr\LaravelSetup\Tests\Unit;

use Innoboxrr\LaravelSetup\Support\ComposerJson;
use PHPUnit\Framework\TestCase;

final class ComposerJsonTest extends TestCase
{
    private string $path;

    protected function setUp(): void
    {
        $this->path = tempnam(sys_get_temp_dir(), 'composer');

        file_put_contents($this->path, json_encode([
            'name' => 'laravel/laravel',
            'require' => ['php' => '^8.3', 'laravel/framework' => '^13.17'],
            'require-dev' => ['phpunit/phpunit' => '^12.5', 'innoboxrr/traits' => '^1.0'],
        ], JSON_PRETTY_PRINT));
    }

    protected function tearDown(): void
    {
        @unlink($this->path);
    }

    public function test_anade_dependencias_ordenadas_con_php_primero(): void
    {
        (new ComposerJson($this->path))->require(['innoboxrr/laravel-auth' => '^6.0', 'algolia/scout-extended' => '^5.0'])->save();

        $data = json_decode((string) file_get_contents($this->path), true);

        $this->assertSame(['php', 'algolia/scout-extended', 'innoboxrr/laravel-auth', 'laravel/framework'], array_keys($data['require']));
    }

    /**
     * Una dependencia en require-dev que ahora se pide en require se mueve.
     */
    public function test_una_dependencia_no_queda_en_las_dos_secciones(): void
    {
        (new ComposerJson($this->path))->require(['innoboxrr/traits' => '^2.1'])->save();

        $data = json_decode((string) file_get_contents($this->path), true);

        $this->assertSame('^2.1', $data['require']['innoboxrr/traits']);
        $this->assertArrayNotHasKey('innoboxrr/traits', $data['require-dev']);
    }

    public function test_quita_dependencias(): void
    {
        $composer = new ComposerJson($this->path);
        $composer->remove(['phpunit/phpunit']);

        $this->assertNull($composer->requires('phpunit/phpunit'));
        $this->assertSame('^13.17', $composer->requires('laravel/framework'));
    }

    public function test_guarda_json_legible_con_barras_sin_escapar(): void
    {
        (new ComposerJson($this->path))->require(['innoboxrr/laravel-auth' => '^6.0'])->save();

        $contents = (string) file_get_contents($this->path);

        $this->assertStringContainsString('"innoboxrr/laravel-auth": "^6.0"', $contents);
        $this->assertStringEndsWith("}\n", $contents);
    }
}
