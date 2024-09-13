<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Search;
use Illuminate\Auth\Access\HandlesAuthorization;

class SearchPolicy
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

    public function view(User $user, Search $search)
    {
        return false;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Search $search)
    {
        return false;
    }

    public function delete(User $user, Search $search)
    {
        return false;
    }

    public function restore(User $user, Search $search)
    {
        return false;
    }

    public function forceDelete(User $user, Search $search)
    {
        return false;
    }

    public function export(User $user)
    {
        return false;
    }

}
