<?php

namespace Src\Auth\Domain\Entities;

use DateTime;
use Src\Auth\Domain\ValueObjects\Token;
use Src\Shared\ValueObjects\Uuid;

class AccessToken
{
    public function __construct(
        public readonly Uuid $id,
        public readonly Token $token,
        public readonly ?DateTime $lastUsedAt,
        public readonly ?DateTime $expiresAt,
    ) {
    }
}
