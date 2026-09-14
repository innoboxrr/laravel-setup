<?php

namespace Innoboxrr\LaravelSetup\Tests\Unit;

use Innoboxrr\LaravelSetup\Support\EnvFile;
use PHPUnit\Framework\TestCase;

final class EnvFileTest extends TestCase
{
    private string $path;

    protected function setUp(): void
    {
        $this->path = tempnam(sys_get_temp_dir(), 'env');

        file_put_contents($this->path, "APP_NAME=Laravel\nAPP_KEY=base64:abc\n# comentario\nDB_DATABASE=laravel\n");
    }

    protected function tearDown(): void
    {
        @unlink($this->path);
    }

    public function test_cambia_una_clave_sin_tocar_las_demas(): void
    {
        (new EnvFile($this->path))->set('APP_NAME', 'Mi App')->save();

        $this->assertSame("APP_NAME=\"Mi App\"\nAPP_KEY=base64:abc\n# comentario\nDB_DATABASE=laravel\n", file_get_contents($this->path));
    }

    public function test_anade_una_clave_que_no_existe(): void
    {
        (new EnvFile($this->path))->set('ADMIN_EMAILS', 'ana@example.com,luis@example.com')->save();

        $this->assertSame('ana@example.com,luis@example.com', (new EnvFile($this->path))->get('ADMIN_EMAILS'));
    }

    public function test_no_pisa_lo_que_la_aplicacion_ya_decidio(): void
    {
        (new EnvFile($this->path))->setIfMissing('DB_DATABASE', 'otra')->setIfMissing('MAIL_MAILER', 'log')->save();

        $env = new EnvFile($this->path);

        $this->assertSame('laravel', $env->get('DB_DATABASE'));
        $this->assertSame('log', $env->get('MAIL_MAILER'));
    }

    /**
     * La expresión anterior no escapaba la clave: `APP.KEY` casaba con `APPXKEY`.
     */
    public function test_busca_la_clave_literalmente(): void
    {
        file_put_contents($this->path, "APPXKEY=uno\n");

        $env = new EnvFile($this->path);

        $this->assertFalse($env->has('APP.KEY'));
        $this->assertSame('uno', $env->get('APPXKEY'));
    }

    public function test_deja_las_referencias_a_otras_claves_sin_comillas(): void
    {
        (new EnvFile($this->path))->set('VITE_APP_NAME', '${APP_NAME}')->save();

        $this->assertStringContainsString("VITE_APP_NAME=\${APP_NAME}\n", (string) file_get_contents($this->path));
    }

    public function test_entrecomilla_y_lee_valores_con_espacios_o_almohadilla(): void
    {
        (new EnvFile($this->path))->set('MAIL_FROM_NAME', 'Soporte #1')->save();

        $this->assertStringContainsString('MAIL_FROM_NAME="Soporte #1"', (string) file_get_contents($this->path));
        $this->assertSame('Soporte #1', (new EnvFile($this->path))->get('MAIL_FROM_NAME'));
    }
}
