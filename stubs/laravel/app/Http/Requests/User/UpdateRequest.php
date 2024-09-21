<?php

namespace App\Http\Requests\User;

use App\Http\Events\User\Events\UpdateEvent;
use App\Http\Resources\Models\UserResource;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $user = User::findOrFail($this->user_id);

        return $this->user()->can('update', $user);

    }

    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'name' => 'nullable|string|max:255',
            'surname' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,'.$this->user_id,
            'password' => 'nullable|string',
            'dob' => 'nullable|date',
            'country_id' => 'nullable|integer|exists:countries,id',
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }

    public function attributes()
    {
        return [
            //
        ];
    }

    protected function passedValidation()
    {
        //
    }

    public function handle()
    {

        $user = User::findOrFail($this->user_id);

        $user = $user->updateModel($this);

        $response = new UserResource($user);

        event(new UpdateEvent($user, $this->all(), $response));

        return $response;

    }
}
