<?php

namespace Src\Infrastructure\Repositories;

use Src\Infrastructure\Models\TokenModel;
use Src\User\Domain\DTOs\CreateTokenDTO;
use Src\User\Domain\Exceptions\AuthenticatableRepositoryException;
use Src\User\Domain\Exceptions\InvalidTokenException;
use Src\User\Domain\Exceptions\InvalidUserType;
use Src\User\Domain\Repositories\TokenRepository;
use Src\User\Domain\ValueObjects\Token;

class TokenEloquentRepository implements TokenRepository
{
    public function __construct(private readonly TokenModel $model)
    {
    }

    /**
     * @throws InvalidUserType
     * @throws AuthenticatableRepositoryException
     * @throws InvalidTokenException
     */
    public function storeToken(CreateTokenDTO $payload): Token
    {
        $tokenableRepository = $payload->tokenableType->repository();

        $tokenable = $tokenableRepository->findById($payload->tokenableId);

        if (! $tokenable) {
            throw InvalidTokenException::tokenableNotFound($payload->tokenableId, $payload->tokenableType);
        }

        /** @var TokenModel $token */
        $token = $this->model
            ->query()
            ->create($payload->jsonSerialize());

        return new Token(
            $token->token,
            $tokenable,
            $token->expires_at->toDateTime()
        );
    }
}
