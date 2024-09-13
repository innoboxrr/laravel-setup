<?php

namespace App\Models\Traits\Assignments;

/* Replace the word "Model" and "model" */

trait UserAssignment
{
    public function assignRole($request)
    {

        $operationResult = $this->roles()->syncWithoutDetaching([
            $request->role_id => [
                // Pivot values
            ],
        ]);

        // Add all permissions to the role to all users
        $rolePermissions = $this->roles()->find($request->role_id)->permissions;
        $rolePermissionsIds = $rolePermissions->pluck('id')->toArray();
        $this->permissions()->attach($rolePermissionsIds, [
            'role_id' => $request->role_id,
        ]);

        return response()->json([
            'role_id' => $request->role_id,
            'user_id' => $request->user_id,
            'operation' => $operationResult,
        ]);

    }

    public function deallocateRole($request)
    {

        $operationResult = $this->roles()->detach($request->role_id);

        // Remove all permissions from the role to all users
        $operationResult = $this->permissions()
            ->wherePivot('role_id', $request->role_id)
            ->detach();

        return response()->json([
            'role_id' => $request->role_id,
            'user_id' => $request->user_id,
            'operation' => $operationResult,
        ]);

    }
}
