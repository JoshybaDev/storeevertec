<?php

namespace App\Http\Requests;

use App\Services\UserServices;
use Illuminate\Foundation\Http\FormRequest;

class StartProcessPayRequest extends FormRequest
{
    //protected $redirectRoute = 'checkout7';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return UserServices::currentUserIdIsValid($this->user_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer|min:0',
            'codeunique'=>'required|exists:orders,codebuy',
        ];
    }
}
