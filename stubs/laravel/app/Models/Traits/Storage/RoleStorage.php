<?php

namespace App\Models\Traits\Storage;

// use App\Models\RoleMeta;

trait RoleStorage
{
    public function createModel($request)
    {

        $role = $this->create($request->only($this->creatable));

        return $role;

    }

    public function updateModel($request)
    {
        if ($request->has('lang') && $this->isValidLang($request->lang)) {
            return $this->updateTranslation($request->only($this->translationable));
        }

        $this->update($request->only($this->updatable));

        return $this;

    }

    /*
    public function updateModelMetas($request)
    {

        $this->update_metas($request, RoleMeta::class, 'role_id')->updatePayload();

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