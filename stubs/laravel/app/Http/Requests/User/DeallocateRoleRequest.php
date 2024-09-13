<?php

namespace App\Http\Requests\User;

use App\Http\Events\User\Events\DeallocateRoleEvent;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class DeallocateRoleRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $user = User::findOrFail($this->user_id);

        return $this->user()->can('deallocateRole', $user);

    }

    public function rules()
    {

        return [
            'user_id' => 'required|numeric|exists:users,id',
            'role_id' => 'required|numeric|exists:roles,id',
        ];

    }

    public function messages()
    {
        return [];
    }

    public function attributes()
    {
        return [];
    }

    protected function passedValidation()
    {
        //
    }

    public function handle()
    {

        $user = User::findOrFail($this->user_id);

        $response = $user->deallocateRole($this);

        event(new DeallocateRoleEvent($user, $this->all(), $response));

        return $response;

    }
}
