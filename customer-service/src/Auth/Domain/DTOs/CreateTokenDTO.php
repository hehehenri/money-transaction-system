<?php

namespace Src\Auth\Domain\DTOs;

use DateTime;
use DateTimeInterface;
use Src\Customer\Domain\ValueObjects\Email;

class CreateTokenDTO
{
    public function __construct(
        public readonly string $token,
        public readonly Email $email,
        public readonly DateTime $expiresAt,
    ) {
    }

    /** @return array<string, string> */
    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token,
            'customer_id' => (string) $this->email,
            'expires_at' => $this->expiresAt->format(DateTimeInterface::RFC3339),
        ];
    }
}
