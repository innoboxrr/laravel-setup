<?php

namespace Innoboxrr\LaravelSetup\Tests\Feature;

use Database\Seeders\SiteOptionsSeeder;
use Innoboxrr\LaravelSetup\Tests\TestCase;
use ReflectionMethod;

/**
 * Los tests de Vue y de React pintan el sitio con tests/Frontend/fixtures/options.json.
 * Si el seeder cambia y el fixture no, las interfaces se prueban contra un sitio
 * que ninguna aplicación va a tener.
 */
final class SiteOptionsFixtureTest extends TestCase
{
    /**
     * Las secciones que registran las dos interfaces (docs/shell-contract.md).
     */
    private const SECTIONS = [
        'legacy/header/HeaderOne',
        'legacy/hero/HeroOne',
        'legacy/hero/HeroTwo',
        'legacy/hero/HeroThree',
        'legacy/section/MissionSection',
        'legacy/section/JoinSection',
        'legacy/section/FaqSection',
        'legacy/section/PartnersSection',
        'legacy/section/TestimonialsSection',
        'legacy/section/PlansSection',
        'legacy/section/HtmlContent',
        'legacy/footer/FooterOne',
        'legacy/cookie-consent/CookieConsentOne',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        require_once dirname(__DIR__, 2).'/stubs/app/common/database/seeders/SiteOptionsSeeder.php';

        config(['app.name' => 'Mi aplicación']);
    }

    public function test_el_fixture_de_las_interfaces_es_lo_que_siembra_el_seeder(): void
    {
        $fixture = json_decode((string) file_get_contents(dirname(__DIR__).'/Frontend/fixtures/options.json'), true);

        $seeded = [];

        foreach ($this->defaults() as $key => [$name, $value]) {
            $seeded[] = ['key' => $key, 'name' => $name, 'value' => is_string($value) ? $value : json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)];
        }

        $this->assertSame($seeded, $fixture, 'Regenera tests/Frontend/fixtures/options.json desde SiteOptionsSeeder.');
    }

    public function test_el_sitio_sembrado_sólo_usa_secciones_del_contrato(): void
    {
        $theme = $this->defaults()['theme'][1];

        $this->assertSame(['home', 'privacy', 'terms', 'contact', 'join'], array_keys($theme));

        foreach ($theme as $page => $definition) {
            $this->assertNotEmpty($definition['title'], "La página {$page} no tiene título.");

            foreach ($definition['sections'] as $section) {
                $this->assertContains("{$section['theme']}/{$section['group']}/{$section['name']}", self::SECTIONS, "La página {$page} usa una sección que no existe.");
                $this->assertArrayHasKey('display', $section['props']);
            }
        }
    }

    /**
     * @return array<string, array{0: string, 1: mixed}>
     */
    private function defaults(): array
    {
        return (new ReflectionMethod(SiteOptionsSeeder::class, 'defaults'))->invoke(new SiteOptionsSeeder);
    }
}
