<?php

namespace Src\User\Domain\DTOs;

use DateTime;
use DateTimeInterface;
use Src\Shared\ValueObjects\Uuid;
use Src\User\Domain\Enums\UserType;

class CreateTokenDTO
{
    public UserType $userType;

    public function __construct(
        public readonly string $token,
        public readonly UserType $tokenableType,
        public readonly Uuid $tokenableId,
        public readonly DateTime $expiresAt,
    ) {
    }

    /** @return array<string, string> */
    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token,
            'tokenable_type' => $this->tokenableType->value,
            'tokenable_id' => $this->tokenableId->value(),
            'expires_at' => $this->expiresAt->format(DateTimeInterface::RFC3339),
        ];
    }
}
