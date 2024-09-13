<?php

namespace App\Support\Traits;

use App\Models\Contact;

trait ContactOthers
{
    protected $exceptFields = [
        '_token',
        'token',
        'recaptcha',
    ];

    public function getOtherData($request)
    {
        $fillableFields = (new Contact)->getFillable();
        $otherData = $request->except(array_merge($fillableFields, $this->exceptFields));
        return json_encode($otherData);
    }
}