<?php

namespace Src\Customer\Presentation\Rest\ViewModels\Transactions;

use Src\Customer\Presentation\Rest\Requests\SendTransactionRequest;
use Src\Shared\ValueObjects\Money;
use Src\Transaction\Domain\ValueObjects\Transactionable;
use Src\Transaction\Domain\ValueObjects\TransactionableId;
use Src\Transaction\Domain\ValueObjects\TransactionableType;

class SendTransactionViewModel
{
    public function __construct(
        public readonly Transactionable $receiver,
        public readonly Money $amount
    ) {
    }

    public static function fromRequest(SendTransactionRequest $request): self
    {
        /** @var array{receiver_id: string, receiver_type: string, amount: int} $payload */
        $payload = $request->validated();

        $id = new TransactionableId($payload['receiver_id']);
        $type = TransactionableType::from($payload['receiver_type']);

        return new self(
            new Transactionable($id, $type),
            new Money($payload['amount'])
        );
    }
}
