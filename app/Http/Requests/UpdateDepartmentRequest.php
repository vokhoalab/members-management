<?php

namespace App\Http\Requests;

use App\Http\Requests\APIRequest;
use App\Models\Department;

/**
 * Class UpdateDepartmentRequest
 */
class UpdateDepartmentRequest extends APIRequest
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
        return Department::$rules;
    }
}
