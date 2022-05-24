<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeclarationRequest extends FormRequest
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
            "nom_instution" => "required|min:3",
            "adresse" => "required|min:5",
            "telephone" => "required|min:8",
            "nom_declarant" => "required|min:6",
            "motif_declaration" => "required",
            "date_declaration" => "required|date|before:today|after:2010-01-01",
            "victime_name" => "required",
            "victime_prenom" => "required",
            "file_name_1" => "required",
            'file_justification_1' => 'required|mimes:pdf|max:2048',
            'file_justification_2' => 'mimes:pdf|max:2048',
            'file_justification_3' => 'mimes:pdf|max:2048',
        ];
    }
}
