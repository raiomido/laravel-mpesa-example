<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class STKPushSimulateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sender_phone' => ['required', 'max:191'],
            'payer_phone' => ['required', 'max:191'],
            'amount' => ['required', 'numeric'],
        ];
    }
}
