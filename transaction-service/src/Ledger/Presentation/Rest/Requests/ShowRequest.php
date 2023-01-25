<?php

namespace Src\Ledger\Presentation\Rest\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Src\Transactionables\Domain\Enums\Provider;

class ShowRequest extends FormRequest
{
    /** @return array<string, array<string|Rule>> */
    public function rules(): array
    {
        return [
            'provider' => ['required', new Enum(Provider::class)],
            'provider_id' => ['required', 'uuid'],
        ];
    }
}
