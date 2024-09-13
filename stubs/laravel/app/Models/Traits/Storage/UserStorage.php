<?php

namespace App\Models\Traits\Storage;

use App\Models\UserMeta;

trait UserStorage
{
    public function createModel($request)
    {
        $user = $this->create($request->only($this->creatable));
        $user->updateModelMetas($request);
        return $user;
    }

    public function updateModel($request)
    {
        $this->update($request->only($this->updatable));
        $this->updateModelMetas($request);
        if($request->has('password') && $request->user()->isAdmin()) {
            $this->password = bcrypt($request->password);
            $this->save();
        }
        return $this;

    }

    public function updateModelMetas($request)
    {

        $this->update_metas($request, UserMeta::class, 'user_id')->updatePayload();

        return $this;

    }

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
