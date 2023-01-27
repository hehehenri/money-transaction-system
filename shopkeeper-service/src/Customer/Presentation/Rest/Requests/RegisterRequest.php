<?php

namespace Src\Shopkeeper\Presentation\Rest\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Src\Shopkeeper\Presentation\Rest\Rules\CPFValidation;
use Src\Shopkeeper\Presentation\Rest\Rules\FullNameValidation;

final class RegisterRequest extends FormRequest
{
    /** @return array<string, array<string|Rule>> */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:150', FullNameValidation::validate()],
            'cpf' => ['required', 'string', CPFValidation::validate()],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ];
    }
}
