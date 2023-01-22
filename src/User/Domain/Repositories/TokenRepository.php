<?php

namespace Src\User\Domain\Repositories;

use Src\User\Domain\Entities\AuthenticatableUser;
use Src\User\Domain\ValueObjects\Token;

interface TokenRepository
{
    public function getToken(AuthenticatableUser $user): ?Token;
}
