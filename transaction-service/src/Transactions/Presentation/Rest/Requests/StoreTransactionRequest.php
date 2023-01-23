<?php

namespace Src\Transactions\Presentation\Rest\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    /** @return array<string, array<string>> */
    public function rules(): array
    {
        return [
            'sender_provider_id' => ['required', 'uuid'],
            'sender_provider_name' => ['required', 'string'],
            'receiver_provider_id' => ['required', 'uuid'],
            'receiver_provider_name' => ['required', 'string'],
            'amount' => ['int'],
        ];
    }
}
