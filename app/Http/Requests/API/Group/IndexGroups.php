<?php

namespace App\Http\Requests\API\Group;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Group;

class IndexGroups extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('index', Group::class);
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
        ];
    }
}
