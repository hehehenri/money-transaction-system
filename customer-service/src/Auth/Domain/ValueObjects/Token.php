<?php

namespace Src\Auth\Domain\ValueObjects;

use DateTime;
use DateTimeInterface;
use Src\Customer\Domain\Entities\Customer;

class Token
{
    public function __construct(
        public readonly string $token,
        public readonly Customer $customer,
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
