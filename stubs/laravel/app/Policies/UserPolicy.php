<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {   
        $exceptAbilities = ['delete'];
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

    public function view(User $user, User $model)
    {
        if ($user->id === $model->id) {
            return true;
        }
        if ($user->getPayload('visibility', 'public') === 'public') {
            return true;
        }
        return false;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    public function delete(User $user, User $model)
    {
        if ($user->isAdmin()) {
            return false;
        }
        if ($user->isAdmin() && $user->id !== $model->id) {
            return true;
        }
        return $user->id === $model->id;
    }

    public function restore(User $user, User $model)
    {
        return false;
    }

    public function forceDelete(User $user, User $model)
    {
        return false;
    }

    public function export(User $user)
    {
        return false;
    }

    public function assignRole(User $user)
    {
        return false;
    }

    public function deallocateRole(User $user)
    {
        return false;
    }

    public function logoutOtherDevices(User $user, User $model)
    {
        $password = request()->password;
        $checkPassword = Hash::check($password, $user->password);
        return $user->id === $model->id && $checkPassword;
    }

    public function deleteAccount(User $user, User $model)
    {
        $password = request()->password;
        $checkPassword = Hash::check($password, $user->password);
        return $user->id === $model->id && $checkPassword;
    }

    public function sendOTP(User $user, User $model)
    {
        return false;
    }

    public function sendDirectResetPasswordLink(User $user, User $model)
    {
        return false;
    }

    public function assignBenefit(User $user)
    {
        return false;
    }

    public function deallocateBenefit(User $user)
    {
        return false;
    }

    public function verifyEmail(User $user, User $model)
    {
        return false;
    }
}
