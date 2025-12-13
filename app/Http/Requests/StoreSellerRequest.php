<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSellerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'        => 'required|exists:users,id',
            'business_type'  => 'required|string',
            'company_name'   => 'required|string|max:255',
            'tin'            => 'required|string|unique:sellers,tin',
            'license_number' => 'nullable|string|max:255',
            'store_name'     => 'required|string|max:255',
            'phone'          => 'required|string|max:50',
            'address'        => 'required|string',
        ];
    }
}
