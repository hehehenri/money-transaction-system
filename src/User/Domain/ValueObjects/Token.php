<?php

namespace Src\User\Domain\ValueObjects;

use DateTime;
use DateTimeInterface;
use Src\User\Domain\Entities\AuthenticatableUser;

class Token
{
    public function __construct(
        public readonly string $token,
        public readonly AuthenticatableUser $user,
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
