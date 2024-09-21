<?php

namespace App\Http\Requests\User;

use App\Http\Events\User\Events\CreateEvent;
use App\Http\Resources\Models\UserResource;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        return $this->user()->can('create', User::class);
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'dob' => 'nullable|date',
            'country_id' => 'required|integer|exists:countries,id',
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
        $user = (new User)->createModel($this);
        if($this->user()?->isAdmin()){
            $user->email_verified_at = now();
            $user->save();
        }
        $response = new UserResource($user);
        event(new CreateEvent($user, $this->all(), $response));
        return $response;
    }
}
