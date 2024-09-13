<?php

namespace App\Http\Requests\User;

// use App\Http\Events\User\Events\SendDirectResetPasswordLinkEvent;
use App\Http\Resources\Models\UserResource;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class SendDirectResetPasswordLinkRequest extends FormRequest
{

    protected $user;

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        $this->user = User::findOrFail($this->user_id);
        return $this->user()->can('sendDirectResetPasswordLink', $this->user);
    }

    public function rules()
    {
        return [
            'user_id' => 'required|integer',
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

    }

    public function handle()
    {
        $this->user->sendDirectResetPasswordLink();
        $response = new UserResource($this->user);
        // event(new SendDirectResetPasswordLinkEvent($this->user, $this->all(), $response));
        return $response;
    }
}
