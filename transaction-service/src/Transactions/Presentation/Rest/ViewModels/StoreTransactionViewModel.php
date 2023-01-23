<?php

namespace Src\Transactions\Presentation\Rest\ViewModels;

use Src\Shared\ValueObjects\Money;
use Src\Transactionables\Domain\Entities\Receiver;
use Src\Transactionables\Domain\Entities\Sender;
use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\Exceptions\InvalidTransactionableException;
use Src\Transactionables\Domain\ValueObjects\ProviderId;
use Src\Transactionables\Domain\ValueObjects\ReceiverId;
use Src\Transactionables\Domain\ValueObjects\SenderId;
use Src\Transactions\Presentation\Rest\Requests\StoreTransactionRequest;

class StoreTransactionViewModel
{
    public function __construct(
        public readonly ProviderId $senderProviderId,
        public readonly Provider $senderProvider,
        public readonly ProviderId $receiverProviderId,
        public readonly Provider $receiverProvider,
        public readonly Money $amount
    ) {
    }

    public static function fromRequest(StoreTransactionRequest $request): self
    {
        /** @var array<string, string> $payload */
        $payload = $request->validated();

        return new self(
            new ProviderId($payload['sender_provider_id']),
            Provider::from($payload['sender_provider_name']),
            new ProviderId($payload['receiver_provider_id']),
            Provider::from($payload['receiver_provider_name']),
            new Money($payload['amount'])
        );
    }
}
