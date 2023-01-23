<?php

namespace Src\Transactionables\Domain\Entities;

use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\Exceptions\InvalidTransactionableException;
use Src\Transactionables\Domain\ValueObjects\ProviderId;
use Src\Transactionables\Domain\ValueObjects\ReceiverId;
use Src\Transactionables\Domain\ValueObjects\SenderId;
use Src\Transactionables\Domain\ValueObjects\TransactionableId;

class Transactionable
{
    public function __construct(
        public readonly TransactionableId $id,
        public readonly ProviderId $providerId,
        public readonly Provider $provider,
    ) {
    }

    public function asReceiver(): Receiver
    {
        return new Receiver(
            new ReceiverId((string) $this->id),
            $this->provider,
            $this->providerId,
        );
    }

    /** @throws InvalidTransactionableException */
    public function asSender(): Sender
    {
        return new Sender(
            new SenderId((string) $this->id),
            $this->provider,
            $this->providerId,
        );
    }
}
