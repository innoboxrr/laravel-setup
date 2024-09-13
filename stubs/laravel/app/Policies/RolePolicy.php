<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {

        $exceptAbilities = ['delete', 'forceDelete'];

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

    public function view(User $user, Role $role)
    {
        return false;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Role $role)
    {
        return false;
    }

    public function delete(User $user, Role $role)
    {
        return false;
    }

    public function restore(User $user, Role $role)
    {
        return false;
    }

    public function forceDelete(User $user, Role $role)
    {
        return false;
    }

    public function export(User $user)
    {
        return false;
    }
}
