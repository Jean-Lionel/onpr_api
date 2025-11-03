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
            'name_en' => ['string'],
            'name_fr' => ['string'],
            'description_en' => ['string'],
            'description_fr' => ['string'],
            'email' => ['email'],
            'phone' => ['string'],
            'address_en' => ['string'],
            'address_fr' => ['string'],
            'box' => ['string'],
        ];
    }
}
