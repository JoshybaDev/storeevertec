<?php

namespace App\Http\Requests;

use App\Services\UserServices;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutCreateOrdenRequest extends FormRequest
{
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
            'user_name' => 'required|string|max:80',
            'user_surname' => 'required|string|max:80',
            'user_mobile' => 'required|string|max:40',
            'user_email' => 'required|string|max:120',
        ];
    }
}
