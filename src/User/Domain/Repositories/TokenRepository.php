<?php

namespace Src\User\Domain\Repositories;

use Src\User\Domain\Enums\UserType;
use Src\User\Domain\ValueObjects\Token;

interface TokenRepository
{
    public function storeToken(Token $token, UserType $userType): Token;
}
