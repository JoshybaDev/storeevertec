<?php

namespace App\Http\Requests;

use App\Services\UserServices;
use Illuminate\Foundation\Http\FormRequest;

class OrderSendedRequest extends FormRequest
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
            'order_id'=> 'required|min:1|exists:orders,id',
            'tracking_number'=> 'required|string|min:10'
        ];
    }
}
