<?php

namespace App\Http\Requests\Languagetranslet;

use Illuminate\Foundation\Http\FormRequest;
use App\General\HandlePermission;

class UpdateLanguagetransletRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {        
        return HandlePermission::authorize('update_languagetranslet');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
       
            ];
    }
}
