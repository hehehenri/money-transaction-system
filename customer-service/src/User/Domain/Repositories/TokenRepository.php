<?php

namespace Src\User\Domain\Repositories;

use Src\User\Domain\DTOs\CreateTokenDTO;
use Src\User\Domain\Exceptions\AuthenticatableRepositoryException;
use Src\User\Domain\Exceptions\InvalidTokenException;
use Src\User\Domain\Exceptions\InvalidUserType;
use Src\User\Domain\ValueObjects\Token;

interface TokenRepository
{
    /**
     * @throws InvalidUserType
     * @throws AuthenticatableRepositoryException
     * @throws InvalidTokenException
     */
    public function storeToken(CreateTokenDTO $payload): Token;
}
