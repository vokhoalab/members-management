<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Http\Requests\APIRequest;

/**
 * Class CreateRoleRequest
 */
class CreateRoleRequest extends APIRequest
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
        return Role::$rules;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return Role::$messages;
    }
}
