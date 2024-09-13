<?php

namespace App\Models\Traits\Storage;

// use App\Models\LanguageMeta;

trait LanguageStorage
{
    public function createModel($request)
    {

        $language = $this->create($request->only($this->creatable));

        return $language;

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

        $this->update_metas($request, LanguageMeta::class, 'language_id')->updatePayload();

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
