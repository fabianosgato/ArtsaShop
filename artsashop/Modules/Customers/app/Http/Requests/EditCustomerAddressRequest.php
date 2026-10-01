<?php

namespace Modules\Customers\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCustomerAddressRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'cellphone' => 'required|string',
            'postcode' => 'required|string',
            'region' => 'required|string',
            'number' => 'required|string',
            'city' => 'required|string',
            'neighborhood' => 'required|string',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
