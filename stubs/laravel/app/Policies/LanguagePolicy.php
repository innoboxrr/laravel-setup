<?php

namespace App\Policies;

use App\Models\Language;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LanguagePolicy
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

    public function view(User $user, Language $language)
    {
        return true;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Language $language)
    {
        return false;
    }

    public function delete(User $user, Language $language)
    {
        return false;
    }

    public function restore(User $user, Language $language)
    {
        return false;
    }

    public function forceDelete(User $user, Language $language)
    {
        return false;
    }

    public function export(User $user)
    {
        return false;
    }
}
