<?php

namespace App\Http\Requests\Languagetranslet;

use Illuminate\Foundation\Http\FormRequest;
use App\General\HandlePermission;

class StoreLanguagetransletRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {        
        return HandlePermission::authorize('store_languagetranslet');
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
