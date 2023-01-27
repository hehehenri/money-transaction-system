<?php

namespace Src\Auth\Domain\ValueObjects;

use DateTime;
use DateTimeInterface;
use Src\Shopkeeper\Domain\Entities\Shopkeeper;

class Token
{
    public function __construct(
        public readonly string $token,
        public readonly Shopkeeper $Shopkeeper,
        public readonly DateTime $expiresAt
    ) {
    }

    /** @return array<string, string> */
    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token,
            'type' => 'Bearer',
            'expires_at' => $this->expiresAt->format(DateTimeInterface::RFC3339),
        ];
    }
}
