<?php

namespace autoengine\crudpack\Http\Requests\Apimodule;

use Illuminate\Foundation\Http\FormRequest;
use App\General\HandlePermission;

class UpdateApimoduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {        
        return HandlePermission::authorize('update_apimodule');
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
