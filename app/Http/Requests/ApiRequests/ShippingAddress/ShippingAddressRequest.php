<?php

namespace App\Http\Requests\ApiRequests\ShippingAddress;

use Illuminate\Foundation\Http\FormRequest;

class ShippingAddressRequest extends FormRequest
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
            'name' => ['required','max:255','string'],
            'address' => ['required','max:255','string'],
            'postal_code' => ['required','max:5'],
            'phone' => ['required','min:11']
        ];
    }

    public function messages()
    {
        return [
            'address' => 'Invalid Address',
            'phone' => 'Invalid Phone Number.'

        ];
    }
    public function attributes()
    {
        return [
            'address' => __('address'),
            'phone' => __('phone')
        ];
    }
}
