<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOnlineDeclarationDetacheRequest extends FormRequest
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
            "titre" => "required",
            "code_instution" => "required",
            "nom_instution" => "required",
            "mois" => "required",
            "annee" => "required",
            "date_declaration" => "required",
            "description" => "required",
            "institution_id" => "required",
           
        ];
    }
}
