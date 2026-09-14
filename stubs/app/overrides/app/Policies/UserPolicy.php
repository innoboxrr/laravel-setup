<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * La política que genera LaraPack nace cerrada: sólo pasa el administrador. La
 * aplicación base le abre a cada persona su propia cuenta, que es lo que usa la
 * pantalla de perfil; el resto sigue siendo del administrador.
 */
class UserPolicy
{
    public function before(Authenticatable $user, string $ability): ?bool
    {
        // El borrado permanente nace apagado, también para el administrador.
        $exceptAbilities = ['forceDelete'];

        $isAdmin = method_exists($user, 'isAdmin') && $user->isAdmin();

        if ($isAdmin && ! in_array($ability, $exceptAbilities, true)) {
            return true;
        }

        return null;
    }

    public function index(Authenticatable $user): Response|bool
    {
        return false;
    }

    public function viewAny(Authenticatable $user): Response|bool
    {
        return false;
    }

    public function view(Authenticatable $user, User $model): Response|bool
    {
        return $user->getAuthIdentifier() === $model->getKey();
    }

    public function create(Authenticatable $user): Response|bool
    {
        return false;
    }

    public function update(Authenticatable $user, User $model): Response|bool
    {
        return $user->getAuthIdentifier() === $model->getKey();
    }

    public function delete(Authenticatable $user, User $model): Response|bool
    {
        return false;
    }

    public function restore(Authenticatable $user, User $model): Response|bool
    {
        return false;
    }

    public function forceDelete(Authenticatable $user, User $model): Response|bool
    {
        return false;
    }

    public function export(Authenticatable $user): Response|bool
    {
        return false;
    }
}
