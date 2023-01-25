<?php

namespace Src\Infrastructure\Events\ValueObjects\Payloads;

use Src\Transactions\Domain\ValueObjects\TransactionId;

class TransactionApprovedPayload implements Payload
{
    public function __construct(private readonly TransactionId $id)
    {
    }

    public function serialize(): string
    {
        return $this->id;
    }

    public static function deserialize(string $rawPayload): self
    {
        return new self(new TransactionId($rawPayload));
    }
}
