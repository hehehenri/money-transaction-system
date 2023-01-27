<?php

namespace Src\Infrastructure\Auth;

use Illuminate\Support\Facades\Hash;
use Src\Auth\Domain\DTOs\CreateTokenDTO;
use Src\Auth\Domain\Exceptions\InvalidTokenException;
use Src\Auth\Domain\Repositories\TokenRepository;
use Src\Auth\Domain\ValueObjects\Token;
use Src\Shopkeeper\Domain\Entities\Shopkeeper;
use Src\Shopkeeper\Domain\ValueObjects\PlainTextPassword;
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
    public function login(Shopkeeper $Shopkeeper, PlainTextPassword $password): Token
    {
        $this->checkPassword($Shopkeeper, $password);

        /** @var int $ttl */
        $ttl = config('auth.jwt.ttl', TTL::fromDays(30));

        $token = JWTToken::encode(['email' => (string) $Shopkeeper->email]);

        $dto = new CreateTokenDTO(
            $token,
            $Shopkeeper->email,
            now()->addSeconds($ttl)->toDateTime()
        );

        return $this->persistToken($dto);
    }

    /** @throws AuthenticationException */
    private function checkPassword(Shopkeeper $Shopkeeper, PlainTextPassword $password): void
    {
        if (! Hash::check($password, $Shopkeeper->password)) {
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
            $token->Shopkeeper,
            $token->expiresAt
        );
    }
}
