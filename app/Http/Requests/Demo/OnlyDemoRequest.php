<?php

namespace App\Http\Requests\Demo;

use Illuminate\Foundation\Http\FormRequest;
use App\General\HandlePermission;

class OnlyDemoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {        
        return HandlePermission::authorize('only_demo');
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
