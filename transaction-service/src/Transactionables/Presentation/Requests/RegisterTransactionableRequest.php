<?php

namespace Src\Transactionables\Presentation\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Src\Transactionables\Domain\Enums\Provider;

class RegisterTransactionableRequest extends FormRequest
{
    /** @return array<string, array<string|Rule>> */
    public function rules(): array
    {
        return [
            'provider_id' => ['required', 'uuid'],
            'provider' => ['required', new Enum(Provider::class)],
        ];
    }
}
