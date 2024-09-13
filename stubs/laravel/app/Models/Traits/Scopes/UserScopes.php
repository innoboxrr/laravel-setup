<?php

namespace App\Models\Traits\Scopes;

use App\Models\Role;

trait UserScopes
{
    /**
     * Scope a query to only include admin users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdmins($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('slug', Role::ADMIN);
        });
    }

    public function scopeHeadTeachers($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('slug', Role::HEAD_TEACHER);
        });
    }

    public function scopeStudents($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('slug', Role::STUDENT);
        });
    }
}
