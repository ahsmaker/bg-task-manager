<?php

namespace App\Http\Requests;

class LoginRequest extends BaseFormRequest
{
    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'email'    => 'required|string|email|exists:users,email',
            'password' => 'required|string',
        ];
    }
}
