<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService\Payloads;

use Src\Shopkeeper\Domain\Entities\Shopkeeper;
use Src\Shared\ValueObjects\Money;
use Src\Transaction\Domain\ValueObjects\Transactionable;

class SendTransactionPayload implements TransactionServicePayload
{
    public function __construct(
        public readonly Shopkeeper $from,
        public readonly Transactionable $to,
        public readonly Money $amount
    ) {
    }

    /** @return array<string, string|int> */
    public function jsonSerialize(): array
    {
        /** @var string $provider */
        $provider = config('services.current_service_name');

        return [
            'sender_provider_id' => (string) $this->from->id,
            'sender_provider' => $provider,
            'receiver_provider_id' => (string) $this->to->id,
            'receiver_provider' => $this->to->type->provider(),
            'amount' => $this->amount->value(),
        ];
    }
}
