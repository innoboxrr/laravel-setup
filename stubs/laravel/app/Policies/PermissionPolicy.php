<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {

        $exceptAbilities = [];

        if($user->isAdmin() && !in_array($ability, $exceptAbilities)){
        
            return true;
            
        }

    }

    public function index(User $user)
    {
        return false;
    }

    public function viewAny(User $user)
    {
        return false;
    }

    public function view(User $user, Permission $permission)
    {
        return false;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Permission $permission)
    {
        return false;
    }

    public function delete(User $user, Permission $permission)
    {
        return false;
    }

    public function restore(User $user, Permission $permission)
    {
        return false;
    }

    public function forceDelete(User $user, Permission $permission)
    {
        return false;
    }

    public function export(User $user)
    {
        return false;
    }

    public function assignRole(User $user, Permission $permission)
    {
        return false;
    }

    public function deallocateRole(User $user, Permission $permission)
    {
        return false;
    }

    public function assignUser(User $user, Permission $permission)
    {
        return false;
    }

    public function deallocateUser(User $user, Permission $permission)
    {
        return false;
    }

}
