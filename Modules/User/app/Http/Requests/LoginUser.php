<?php

namespace Modules\User\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Modules\User\Exceptions\InvalidLoginCredentials;
use Modules\User\Models\User;

class LoginUser extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255',
            'password' => [
                'required',
                Password::default(),
            ],
        ];
    }

    /**
     * @throws InvalidLoginCredentials
     */
    protected function failedValidation(Validator $validator)
    {
        throw new InvalidLoginCredentials;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
