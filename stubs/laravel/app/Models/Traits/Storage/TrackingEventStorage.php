<?php

namespace App\Models\Traits\Storage;

// use App\Models\TrackingEventMeta;

trait TrackingEventStorage
{

    public function createModel($request)
    {

        $trackingEvent = $this->create($request->only($this->creatable));

        return $trackingEvent;

    }

    public function updateModel($request)
    {
     
        $this->update($request->only($this->updatable));

        return $this;

    }

    /*
    public function updateModelMetas($request)
    {

        $this->update_metas($request, TrackingEventMeta::class, 'tracking_event_id')->updatePayload();

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