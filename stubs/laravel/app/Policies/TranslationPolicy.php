<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Translation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TranslationPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        $exceptAbilities = [];
        if ($user->isAdmin() && ! in_array($ability, $exceptAbilities)) {
            return true;
        }
    }

    public function index(User $user)
    {
        return true;
    }

    public function viewAny(User $user)
    {
        return false;
    }

    public function view(User $user, Translation $translation)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->hasRole(Role::TRANSLATOR);
    }

    public function update(User $user, Translation $translation)
    {
        return $user->hasRole(Role::TRANSLATOR);
    }

    public function delete(User $user, Translation $translation)
    {
        return $user->hasRole(Role::TRANSLATOR);
    }

    public function restore(User $user, Translation $translation)
    {
        return false;
    }

    public function forceDelete(User $user, Translation $translation)
    {
        return false;
    }

    public function export(User $user)
    {
        return false;
    }
}
