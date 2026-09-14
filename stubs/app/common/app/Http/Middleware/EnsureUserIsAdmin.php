<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Deja pasar sólo a quien administra la aplicación: el usuario responde true a
 * isAdmin(), que por omisión mira los correos de `auth.admins` (ADMIN_EMAILS en
 * el .env).
 */
class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        abort_unless($user !== null && method_exists($user, 'isAdmin') && $user->isAdmin(), 403);

        return $next($request);
    }
}
