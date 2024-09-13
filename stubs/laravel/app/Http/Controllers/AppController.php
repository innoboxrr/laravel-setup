<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Services\App\ShareService;

class AppController extends Controller
{
    public function app()
    {
        return response()->view('app');
    }

    public function validateRecaptcha(Request $request)
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->input('recaptcha'),
        ]);
        $result = $response->json();
        return response()->json(['success' => $result['success']]);
    }

    public function mailchimpSubscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $audienceId = config('services.mailchimp.audience_id');
        $apiKey = config('services.mailchimp.api_key');
        $dc = substr($apiKey, strpos($apiKey, '-') + 1);

        $response = Http::withBasicAuth('anystring', $apiKey)
            ->post("https://{$dc}.api.mailchimp.com/3.0/lists/{$audienceId}/members", [
                'email_address' => $request->input('email'),
                'status' => 'subscribed',
                'merge_fields' => (object)[
                    'FNAME' => $request->user()?->name ?? '', // Enviar el nombre, si está disponible
                    'LNAME' => $request->user()?->surname ?? '' // Enviar el apellido, si está disponible
                ], // Enviar como un objeto vacío
                'interests' => (object)[],    // Enviar como un objeto vacío
                'language' => 'en',           // Ejemplo de uso, puede ajustarse según tus necesidades
                'vip' => false,
                'location' => [
                    'latitude' => 0,
                    'longitude' => 0,
                ],
                'marketing_permissions' => [],
                'ip_signup' => $request->ip(),
                'timestamp_signup' => now()->toIso8601String(),
                'ip_opt' => $request->ip(),
                'timestamp_opt' => now()->toIso8601String(),
                'tags' => [], // Asegúrate de que tags también sea un array
            ]);

        $result = $response->json();

        if ($response->status() == 400) {
            return response()->json(['error' => $result['detail']], 400);
        }

        return response()->json(['success' => $response->successful()]);
    }

    public function quickStats()
    {
        return cache()->remember('quick-stats', now()->addMinutes(60), function () {
            $courses = \App\Models\Course::count();
            $students = \App\Models\User::students()->count();
            $teachers = \App\Models\User::headTeachers()->count();
            $reviews = \App\Models\Review::count();
            return [
                'courses' => $courses,
                'students' => $students,
                'teachers' => $teachers,
                'reviews' => $reviews,
            ];
        });
    }

    public function exports($xlsx)
    {
        return Storage::disk('s3')->download("exports/{$xlsx}");
    }

    public function share(Request $request)
    {
        return ShareService::share($request->input('url'), $request->boolean('bot') == true);
    }

}
