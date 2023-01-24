<?php

namespace Src\Infrastructure\Events\ValueObjects\Payloads;

use Src\Transactions\Domain\ValueObjects\TransactionId;

final class TransactionStoredPayload implements Payload
{
    public function __construct(private readonly TransactionId $id)
    {
    }

    public function serialize(): string
    {
        return (string) $this->id;
    }

    public static function deserialize(string $rawPayload): Payload
    {
        return new self(new TransactionId($rawPayload));
    }
}
