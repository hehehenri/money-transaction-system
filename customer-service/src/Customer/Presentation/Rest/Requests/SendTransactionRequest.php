<?php

namespace Src\Customer\Presentation\Rest\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Src\Transaction\Domain\ValueObjects\TransactionableType;

class SendTransactionRequest extends FormRequest
{
    /** @return array<string, array<string|Rule>> */
    public function rules(): array
    {
        return [
            'receiver_type' => ['required', new Enum(TransactionableType::class)],
            'receiver_id' => ['required', 'uuid'],
            'amount' => ['required', 'integer'],
        ];
    }
}
