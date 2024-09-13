<?php

namespace App\Models\Traits\Storage;

// use App\Models\PermissionMeta;

trait PermissionStorage
{

    public function createModel($request)
    {

        $permission = $this->create($request->only($this->creatable));

        return $permission;

    }

    public function updateModel($request)
    {
     
        $this->update($request->only($this->updatable));

        return $this;

    }

    /*
    public function updateModelMetas($request)
    {

        $this->update_metas($request, PermissionMeta::class, 'permission_id')->updatePayload();

        return $this;

    }
    */

    public function deleteModel()
    {

        $this->delete();

    }

    public function restoreModel()
    {

        $this->restore();

    }

    public function forceDeleteModel()
    {

        abort(403);

        $this->forceDelete();
        
    }

}