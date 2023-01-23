<?php

namespace Src\Transaction\Presentation\Rest\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    /** @return array<string, array<string>> */
    public function rules(): array
    {
        return [
            'from_id' => ['required', 'uuid'],
            'from_type' => ['required', 'string'],
            'to_id' => ['required', 'uuid'],
            'to_type' => ['required', 'string'],
            'amount' => ['int'],
            'type' => ['string']
        ];
    }
}
