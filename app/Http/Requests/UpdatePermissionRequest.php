<?php

namespace App\Http\Requests;

use App\Http\Requests\APIRequest;

/**
 * Class UpdatePermissionRequest
 */
class UpdatePermissionRequest extends APIRequest
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
        $rules['name'] = 'required|unique:permissions,name,'.$this->route('permission')->id;

        return $rules;
    }
}
