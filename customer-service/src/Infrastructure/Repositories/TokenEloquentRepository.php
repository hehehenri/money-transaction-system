<?php

namespace Src\Infrastructure\Repositories;

use Src\Auth\Domain\DTOs\CreateTokenDTO;
use Src\Auth\Domain\Exceptions\InvalidTokenException;
use Src\Auth\Domain\Repositories\TokenRepository;
use Src\Auth\Domain\ValueObjects\Token;
use Src\Customer\Domain\Repositories\CustomerRepository;
use Src\Infrastructure\Exceptions\InvalidCustomerException;
use Src\Infrastructure\Models\TokenModel;

class TokenEloquentRepository implements TokenRepository
{
    public function __construct(
        private readonly TokenModel $model,
        private readonly CustomerRepository $repository
    ) {
    }

    /**
     * @throws InvalidTokenException
     * @throws InvalidCustomerException
     */
    public function storeToken(CreateTokenDTO $payload): Token
    {
        $customer = $this->repository->findById($payload->customerId);

        if (! $customer) {
            throw InvalidTokenException::customerNotFound($payload->customerId);
        }

        /** @var TokenModel $token */
        $token = $this->model
            ->query()
            ->create($payload->jsonSerialize());

        return new Token(
            $token->token,
            $customer,
            $token->expires_at->toDateTime()
        );
    }
}
