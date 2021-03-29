<?php

namespace App\Http\Requests;

use App\Http\Requests\APIRequest;

/**
 * Class CreateMemberRequest
 */
class CreateMemberRequest extends APIRequest
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
}
