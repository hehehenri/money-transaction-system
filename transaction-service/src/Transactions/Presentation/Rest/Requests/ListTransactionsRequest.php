<?php

namespace Src\Transactions\Presentation\Rest\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListTransactionsRequest extends FormRequest
{
    /** @return array<string, array<string>> */
    public function rules(): array
    {
        return [
            'transactionable_id' => ['required', 'uuid'],
            'per_page' => ['integer'],
            'page' => ['integer'],
        ];
    }
}
