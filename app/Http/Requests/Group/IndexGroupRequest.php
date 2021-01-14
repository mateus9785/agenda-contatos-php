<?php

namespace App\Http\Requests\Group;

use Illuminate\Foundation\Http\FormRequest;

class IndexGroupRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'per_page' => ['integer', 'nullable'],
        ];
    }
}
