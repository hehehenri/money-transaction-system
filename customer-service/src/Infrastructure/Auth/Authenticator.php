<?php

namespace Src\Infrastructure\Auth;

use Illuminate\Support\Facades\Hash;
use Src\Auth\Domain\DTOs\CreateTokenDTO;
use Src\Auth\Domain\Exceptions\InvalidTokenException;
use Src\Auth\Domain\Repositories\TokenRepository;
use Src\Auth\Domain\ValueObjects\Token;
use Src\Customer\Domain\Entities\Customer;
use Src\Customer\Domain\ValueObjects\PlainTextPassword;
use Src\Infrastructure\Exceptions\AuthenticationException;
use Src\Infrastructure\TTL;

class Authenticator
{
    public function __construct(private readonly TokenRepository $tokenRepository)
    {
    }

    /**
     * @throws AuthenticationException
     * @throws InvalidTokenException
     */
    public function login(Customer $customer, PlainTextPassword $password): Token
    {
        $this->checkPassword($customer, $password);

        /** @var int $ttl */
        $ttl = config('auth.jwt.ttl', TTL::fromDays(30));

        $token = JWTToken::encode(['email' => (string) $customer->email]);

        $dto = new CreateTokenDTO(
            $token,
            $customer->email,
            now()->addSeconds($ttl)->toDateTime()
        );

        return $this->persistToken($dto);
    }

    /** @throws AuthenticationException */
    private function checkPassword(Customer $customer, PlainTextPassword $password): void
    {
        if (! Hash::check($password, $customer->password)) {
            throw AuthenticationException::invalidEmailOrPassword();
        }
    }

    /**
     * @throws InvalidTokenException
     */
    private function persistToken(CreateTokenDTO $dto): Token
    {
        $token = $this->tokenRepository->storeToken($dto);

        return new Token(
            $token->token,
            $token->customer,
            $token->expiresAt
        );
    }
}
