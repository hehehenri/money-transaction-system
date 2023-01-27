<?php

namespace Src\Auth\Domain\Repositories;

use Src\Auth\Domain\DTOs\CreateTokenDTO;
use Src\Auth\Domain\Exceptions\InvalidTokenException;
use Src\Auth\Domain\ValueObjects\Token;

interface TokenRepository
{
    /**
     * @throws InvalidTokenException
     */
    public function storeToken(CreateTokenDTO $payload): Token;
}
