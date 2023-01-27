<?php

namespace Src\Infrastructure\Repositories;

use Src\Auth\Domain\DTOs\CreateTokenDTO;
use Src\Auth\Domain\Exceptions\InvalidTokenException;
use Src\Auth\Domain\Repositories\TokenRepository;
use Src\Auth\Domain\ValueObjects\Token;
use Src\Shopkeeper\Domain\Repositories\ShopkeeperRepository;
use Src\Infrastructure\Exceptions\InvalidShopkeeperException;
use Src\Infrastructure\Models\TokenModel;

class TokenEloquentRepository implements TokenRepository
{
    public function __construct(
        private readonly TokenModel $model,
        private readonly ShopkeeperRepository $repository
    ) {
    }

    /**
     * @throws InvalidTokenException
     * @throws InvalidShopkeeperException
     */
    public function storeToken(CreateTokenDTO $payload): Token
    {
        $Shopkeeper = $this->repository->findByEmail($payload->email);

        if (! $Shopkeeper) {
            throw InvalidTokenException::ShopkeeperNotFound($payload->email);
        }

        /** @var TokenModel $token */
        $token = $this->model
            ->query()
            ->create($payload->jsonSerialize());

        return new Token(
            $token->token,
            $Shopkeeper,
            $token->expires_at->toDateTime()
        );
    }
}
