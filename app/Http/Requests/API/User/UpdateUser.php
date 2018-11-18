<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->route('user'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => [
                'string',
                'email',
                'max:255',
                'unique:users,email,'.$this->user->id,
            ],
            'password' => 'string|min:4',
            'role' => 'nullable|int|exists:roles,id',
            'state' => 'boolean',
        ];
    }
}
