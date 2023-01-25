<?php

namespace Src\Auth\Domain\DTOs;

use DateTime;
use DateTimeInterface;
use Src\Customer\Domain\ValueObjects\CustomerId;

class CreateTokenDTO
{
    public function __construct(
        public readonly string $token,
        public readonly CustomerId $customerId,
        public readonly DateTime $expiresAt,
    ) {
    }

    /** @return array<string, string> */
    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token,
            'customer_id' => $this->customerId->value(),
            'expires_at' => $this->expiresAt->format(DateTimeInterface::RFC3339),
        ];
    }
}
