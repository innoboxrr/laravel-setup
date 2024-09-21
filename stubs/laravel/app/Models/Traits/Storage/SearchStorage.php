<?php

namespace App\Models\Traits\Storage;

// use App\Models\SearchMeta;

trait SearchStorage
{

    public function createModel($request)
    {

        $search = $this->create($request->only($this->creatable));

        return $search;

    }

    public function updateModel($request)
    {
     
        $this->update($request->only($this->updatable));

        return $this;

    }

    /*
    public function updateModelMetas($request)
    {

        $this->update_metas($request, SearchMeta::class, 'search_id')->updatePayload();

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