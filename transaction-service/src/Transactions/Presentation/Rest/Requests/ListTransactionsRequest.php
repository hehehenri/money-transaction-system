<?php

namespace Src\Transactions\Presentation\Rest\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Src\Transactionables\Domain\Enums\Provider;

class ListTransactionsRequest extends FormRequest
{
    /** @return array<string, array<string|Rule>> */
    public function rules(): array
    {
        return [
            'provider_id' => ['required', 'uuid'],
            'provider' => ['required', new Enum(Provider::class)],
            'per_page' => ['integer'],
            'page' => ['integer'],
        ];
    }
}
