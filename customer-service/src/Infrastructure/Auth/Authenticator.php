<?php

namespace Src\Infrastructure\Auth;

use Illuminate\Support\Facades\Hash;
use Src\Infrastructure\Exceptions\AuthenticationException;
use Src\Infrastructure\TTL;
use Src\User\Domain\DTOs\CreateTokenDTO;
use Src\User\Domain\Entities\AuthenticatableUser;
use Src\User\Domain\Enums\UserType;
use Src\User\Domain\Exceptions\AuthenticatableRepositoryException;
use Src\User\Domain\Exceptions\InvalidTokenException;
use Src\User\Domain\Exceptions\InvalidUserType;
use Src\User\Domain\Repositories\TokenRepository;
use Src\User\Domain\ValueObjects\PlainTextPassword;
use Src\User\Domain\ValueObjects\Token;

class Authenticator
{
    public function __construct(private readonly TokenRepository $tokenRepository)
    {
    }

    /**
     * @throws AuthenticationException
     * @throws InvalidUserType
     * @throws InvalidTokenException
     * @throws AuthenticatableRepositoryException
     * @throws InvalidUserType
     */
    public function login(AuthenticatableUser $user, PlainTextPassword $password): Token
    {
        $this->checkPassword($user, $password);

        /** @var int $ttl */
        $ttl = config('auth.jwt.ttl', TTL::fromDays(30));

        $token = JWTToken::encode(['email' => (string) $user->email]);

        $dto = new CreateTokenDTO(
            $token,
            UserType::fromUser($user),
            $user->id,
            now()->addSeconds($ttl)->toDateTime()
        );

        return $this->persistToken($dto);
    }

    /** @throws AuthenticationException */
    private function checkPassword(AuthenticatableUser $user, PlainTextPassword $password): void
    {
        if (! Hash::check($password, $user->password)) {
            throw AuthenticationException::invalidEmailOrPassword();
        }
    }

    /**
     * @throws InvalidTokenException
     * @throws AuthenticatableRepositoryException
     * @throws InvalidUserType
     */
    private function persistToken(CreateTokenDTO $dto): Token
    {
        $token = $this->tokenRepository->storeToken($dto);

        return new Token(
            $token->token,
            $token->user,
            $token->expiresAt
        );
    }
}
