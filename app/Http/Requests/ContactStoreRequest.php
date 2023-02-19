<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactStoreRequest extends FormRequest
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
            'title_en' => ['required', 'string', 'max:400'],
            'title_fr' => ['required', 'string', 'max:400'],
            'content_en' => ['required', 'string'],
            'content_fr' => ['required', 'string'],
            'published_at' => [''],
        ];
    }
}
