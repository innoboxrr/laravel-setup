<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Innoboxrr\LaravelOptions\Models\Option;

/**
 * El sitio de ejemplo de la aplicación base: nombre, descripción y las páginas
 * que pinta el theme-manager (opción `theme`).
 *
 * Crea lo que falte y no toca lo que existe: corre en cada instalación y lo que
 * el administrador cambió desde el editor del sitio no se pisa.
 */
class SiteOptionsSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->defaults() as $key => [$name, $value]) {
            Option::withTrashed()->firstOrCreate(['key' => $key], [
                'name' => $name,
                'value' => is_string($value) ? $value : json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ]);
        }
    }

    /**
     * @return array<string, array{0: string, 1: mixed}>
     */
    protected function defaults(): array
    {
        return [
            'site_name' => ['Nombre del sitio', config('app.name')],
            'site_description' => ['Descripción del sitio', 'Una aplicación lista para crecer.'],
            'theme' => ['Páginas del sitio', [
                'home' => ['title' => 'Inicio', 'sections' => [
                    $this->header(),
                    $this->section('hero', 'HeroOne', [
                        'badge' => 'Nuevo',
                        'badge_value' => 'Ya puedes crear tu cuenta',
                        'badge_link' => '/auth/register',
                        'title' => 'Tu aplicación, lista para crecer',
                        'message' => 'Acceso, administración y un sitio que editas sin tocar código. Empieza hoy y añade lo que tu negocio necesite.',
                        'primary_button_text' => 'Crear cuenta',
                        'primary_button_link' => '/auth/register',
                        'secondary_button_text' => 'Iniciar sesión',
                        'secondary_button_link' => '/auth/login',
                        'videos' => [],
                    ]),
                    $this->section('section', 'MissionSection', [
                        'title' => 'Nuestra misión',
                        'subtitle' => 'Lo que nos mueve',
                        'message' => 'Queremos que cada equipo tenga una herramienta hecha a su medida, sin empezar de cero cada vez.',
                        'button_text' => 'Únete',
                        'button_link' => '/join',
                        'images' => [],
                    ]),
                    $this->section('section', 'TestimonialsSection', [
                        'title' => 'Lo que dicen quienes ya la usan',
                        'subtitle' => 'Testimonios',
                        'feature' => $this->testimonial('Pasamos de hojas de cálculo a una aplicación propia en una semana. El equipo la adoptó desde el primer día.', 'Laura Méndez', 'directora de operaciones'),
                        'items' => [
                            $this->testimonial('Todo lo administramos desde el mismo panel.', 'Carlos Ruiz', 'coordinador'),
                            $this->testimonial('Cambiar el sitio ya no depende de un desarrollador.', 'Ana Torres', 'marketing'),
                            $this->testimonial('Las notificaciones nos avisan de lo importante.', 'Jorge Salas', 'soporte'),
                        ],
                    ]),
                    $this->faq(),
                    $this->section('section', 'PartnersSection', ['display' => false, 'title' => 'Confían en nosotros', 'items' => []]),
                    $this->join(),
                    $this->footer(),
                    $this->section('cookie-consent', 'CookieConsentOne', [
                        'message' => 'Usamos cookies para que el sitio funcione y para recordar tus preferencias.',
                        'accept_text' => 'Aceptar',
                        'reject_text' => 'Rechazar',
                        'policy_link' => '/privacy',
                    ]),
                ]],
                'privacy' => ['title' => 'Aviso de privacidad', 'sections' => [
                    $this->header(),
                    $this->html('<h1>Aviso de privacidad</h1><p>Explica aquí qué datos recoges, para qué los usas, con quién los compartes y cómo pueden ejercer sus derechos las personas usuarias.</p>'),
                    $this->footer(),
                ]],
                'terms' => ['title' => 'Términos y condiciones', 'sections' => [
                    $this->header(),
                    $this->html('<h1>Términos y condiciones</h1><p>Describe aquí las condiciones de uso del servicio, las responsabilidades de cada parte y cómo se resuelven los desacuerdos.</p>'),
                    $this->footer(),
                ]],
                'contact' => ['title' => 'Contacto', 'sections' => [
                    $this->header(),
                    $this->html('<h1>Contacto</h1><p>Escríbenos a <a href="mailto:hola@example.com">hola@example.com</a> y te respondemos en un día hábil.</p>'),
                    $this->footer(),
                ]],
                'join' => ['title' => 'Únete', 'sections' => [
                    $this->header(),
                    $this->join(),
                    $this->section('section', 'PlansSection', [
                        'title' => 'Planes',
                        'subtitle' => 'Elige el que se ajusta a tu equipo',
                        'frequencies' => [
                            ['value' => 'monthly', 'label' => 'Mensual', 'price_suffix' => '/mes'],
                            ['value' => 'annually', 'label' => 'Anual', 'price_suffix' => '/año'],
                        ],
                        'tiers' => [
                            $this->tier('basic', 'Básico', '$0', '$0', 'Para empezar a probar.', ['Hasta 3 usuarios', 'Sitio editable', 'Soporte por correo'], false),
                            $this->tier('team', 'Equipo', '$29', '$290', 'Para equipos que ya trabajan con ella.', ['Usuarios ilimitados', 'Notificaciones', 'Exportaciones', 'Soporte prioritario'], true),
                            $this->tier('business', 'Empresa', '$99', '$990', 'Para organizaciones con varias áreas.', ['Todo lo de Equipo', 'Módulos a medida', 'Acompañamiento'], false),
                        ],
                    ]),
                    $this->faq(),
                    $this->footer(),
                ]],
            ]],
        ];
    }

    /**
     * @param  array<string, mixed>  $props
     * @return array{theme: string, group: string, name: string, props: array<string, mixed>}
     */
    private function section(string $group, string $name, array $props): array
    {
        return ['theme' => 'legacy', 'group' => $group, 'name' => $name, 'props' => ['display' => true, ...$props]];
    }

    private function header(): array
    {
        return $this->section('header', 'HeaderOne', [
            'logo' => '',
            'nav' => [
                ['label' => 'Inicio', 'link' => '/'],
                ['label' => 'Únete', 'link' => '/join'],
                ['label' => 'Contacto', 'link' => '/contact'],
            ],
            'facebook' => '',
            'twitter' => '',
            'instagram' => '',
            'youtube' => '',
            'whatsapp' => '',
            'linkedin' => '',
            'tiktok' => '',
        ]);
    }

    private function footer(): array
    {
        return $this->section('footer', 'FooterOne', [
            'logo' => '',
            'description' => 'Una aplicación lista para crecer.',
            'cols' => [
                ['title' => 'Sitio', 'items' => [
                    ['name' => 'Inicio', 'link' => '/'],
                    ['name' => 'Únete', 'link' => '/join'],
                    ['name' => 'Contacto', 'link' => '/contact'],
                ]],
                ['title' => 'Cuenta', 'items' => [
                    ['name' => 'Iniciar sesión', 'link' => '/auth/login'],
                    ['name' => 'Crear cuenta', 'link' => '/auth/register'],
                ]],
                ['title' => 'Legal', 'items' => [
                    ['name' => 'Aviso de privacidad', 'link' => '/privacy'],
                    ['name' => 'Términos y condiciones', 'link' => '/terms'],
                ]],
            ],
            'newsletter' => [
                'title' => '¿Hablamos?',
                'subtitle' => 'Cuéntanos qué necesitas y te respondemos.',
                'button_text' => 'Escríbenos',
                'button_link' => '/contact',
            ],
            'social_links' => [
                'facebook' => '', 'instagram' => '', 'twitter' => '', 'github' => '',
                'youtube' => '', 'linkedin' => '', 'tiktok' => '', 'whatsapp' => '',
            ],
        ]);
    }

    private function faq(): array
    {
        return $this->section('section', 'FaqSection', [
            'title' => 'Preguntas frecuentes',
            'subtitle' => 'Lo que más nos preguntan',
            'items' => [
                ['question' => '¿Necesito instalar algo?', 'answer' => 'No. Entras desde el navegador con tu correo y tu contraseña.'],
                ['question' => '¿Puedo cambiar el contenido del sitio?', 'answer' => 'Sí. Quien administra lo edita desde el panel, sin tocar código.'],
                ['question' => '¿Mis datos están seguros?', 'answer' => 'Las contraseñas se guardan cifradas y cada acción pasa por los permisos de tu cuenta.'],
            ],
        ]);
    }

    private function join(): array
    {
        return $this->section('section', 'JoinSection', [
            'title' => 'Únete',
            'subtitle' => 'Crea tu cuenta y empieza hoy',
            'image' => '',
            'features' => ['Acceso desde cualquier dispositivo', 'Administración en un solo panel', 'Avisos de lo que importa'],
            'button_text' => 'Crear cuenta',
            'button_link' => '/auth/register',
        ]);
    }

    private function html(string $content): array
    {
        return $this->section('section', 'HtmlContent', ['content' => $content]);
    }

    private function testimonial(string $body, string $name, string $handle): array
    {
        return ['body' => $body, 'author' => ['name' => $name, 'handle' => $handle, 'image' => '']];
    }

    /**
     * @param  array<int, string>  $features
     */
    private function tier(string $id, string $name, string $monthly, string $annually, string $description, array $features, bool $mostPopular): array
    {
        return [
            'id' => $id,
            'name' => $name,
            'href' => '/auth/register',
            'description' => $description,
            'price' => ['monthly' => $monthly, 'annually' => $annually],
            'features' => $features,
            'most_popular' => $mostPopular,
        ];
    }
}
