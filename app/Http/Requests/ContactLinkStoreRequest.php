<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactLinkStoreRequest extends FormRequest
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
            'name_en' => ['nullable', 'string'],
            'name_fr' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'description_fr' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string'],
            'address_en' => ['nullable', 'string'],
            'address_fr' => ['nullable', 'string'],
            'box' => ['nullable', 'string'],
        ];

    }
}
