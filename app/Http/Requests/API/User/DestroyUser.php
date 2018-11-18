<?php

namespace App\Http\Requests\API\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

use App\Models\User;

class DestroyUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('delete', User::class);
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = $this->route('user');
            $role = $user->role()->first();

            if (!empty($role) && $role->is_root) {
                $validator->errors()->add('user', "Root user can not be deleted!");
            }

            if (Auth::user()->is($user)) {
                $validator->errors()->add('user', "Can not delete yourself!");
            }
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
