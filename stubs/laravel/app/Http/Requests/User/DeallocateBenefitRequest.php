<?php

namespace App\Http\Requests\User;

use App\Http\Events\User\Events\DeallocateBenefitEvent;
use App\Models\User;
use App\Models\Benefit;
use Illuminate\Foundation\Http\FormRequest;

class DeallocateBenefitRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        $user = User::findOrFail($this->user_id);
        return $this->user()->can('deallocateBenefit', $user);
    }

    public function rules()
    {

        return [
            'user_id' => 'required|numeric|exists:users,id',
            'benefit_id' => 'required|numeric|exists:benefits,id',
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
        $benefit = Benefit::findOrFail($this->benefit_id);
        $response = $user->deallocateBenefit($benefit);
        event(new DeallocateBenefitEvent($user, $this->all(), $response));
        return $response;
    }
}
