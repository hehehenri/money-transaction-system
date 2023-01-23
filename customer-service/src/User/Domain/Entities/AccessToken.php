<?php

namespace Src\User\Domain\Entities;

use DateTime;
use Src\Shared\ValueObjects\Uuid;
use Src\User\Domain\ValueObjects\Token;

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
