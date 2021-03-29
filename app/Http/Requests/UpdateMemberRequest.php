<?php

namespace App\Http\Requests;

use App\Http\Requests\APIRequest;
use App\Models\Member;

/**
 * Class UpdateMemberRequest
 */
class UpdateMemberRequest extends APIRequest
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
