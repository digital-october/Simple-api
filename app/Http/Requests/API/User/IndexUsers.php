<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\User;

class IndexUsers extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('index', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'per_page' => 'int|between:1,30|nullable',
            'query' => 'string|nullable',
            'roles' => 'array|nullable',
            'roles.*' => 'int|exists:roles,id',
            'group' => 'int|exists:groups,id|nullable',
            'state' => 'boolean|nullable'
        ];
    }
}
