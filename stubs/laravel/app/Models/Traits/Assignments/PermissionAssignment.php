<?php

namespace App\Models\Traits\Assignments;

/* Replace the word "Model" and "model" */

trait PermissionAssignment
{

	public function assignRole($request)
	{

        $operationResult = $this->roles()->syncWithoutDetaching([
            $request->role_id => [
            	// Pivot values
            ]
        ]);

        return response()->json([
        	'role_id' => $request->role_id,
        	'permission_id' => $request->permission_id,
        	'operation' => $operationResult
        ]);

	}

	public function deallocateRole($request)
	{

		$operationResult = $this->roles()->detach($request->role_id);

		// Remove all permissions from the role to all users
		$operationResult = $this->users()
			->wherePivot('role_id', $request->role_id)
			->detach();

		return response()->json([
        	'role_id' => $request->role_id,
        	'permission_id' => $request->permission_id,
        	'operation' => $operationResult
        ]);

	}

	public function assignUser($request)
	{

        $operationResult = $this->users()->attach($request->user_id, [
			'role_id' => $request->role_id
		]);

        return response()->json([
        	'user_id' => $request->user_id,
        	'permission_id' => $request->permission_id,
			'role_id' => $request->role_id,
        	'operation' => $operationResult
        ]);

	}

	public function deallocateUser($request)
	{

		$operationResult = $this->users()
			->wherePivot('role_id', $request->role_id)
			->detach($request->user_id);

		return response()->json([
        	'user_id' => $request->user_id,
        	'permission_id' => $request->permission_id,
			'role_id' => $request->role_id,
        	'operation' => $operationResult
        ]);

	}

}