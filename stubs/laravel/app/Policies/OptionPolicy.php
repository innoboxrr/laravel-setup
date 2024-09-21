<?php

namespace App\Policies;

use App\Models\Option;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OptionPolicy
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

    public function view(User $user, Option $option)
    {
        return false;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Option $option)
    {
        return false;
    }

    public function delete(User $user, Option $option)
    {
        return false;
    }

    public function restore(User $user, Option $option)
    {
        return false;
    }

    public function forceDelete(User $user, Option $option)
    {
        return false;
    }

    public function export(User $user)
    {
        return false;
    }
}
