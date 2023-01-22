<?php

namespace Src\Infrastructure\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Src\Infrastructure\Auth\ValueObjects\JWTToken;
use Src\Infrastructure\Exceptions\AuthenticationException;
use Src\User\Domain\Entities\AuthenticatableUser;
use Src\User\Domain\Entities\User;
use Src\User\Domain\Enums\UserType;
use Src\User\Domain\Exceptions\InvalidUserType;
use Src\User\Domain\Repositories\TokenRepository;
use Src\User\Domain\ValueObjects\PlainTextPassword;

class Authenticator
{
    public function __construct(private readonly TokenRepository $tokenRepository)
    {
    }

    /** @throws AuthenticationException */
    public function login(AuthenticatableUser $user, PlainTextPassword $password): JWTToken
    {
        $this->checkPassword($user, $password);

        $token = JWTToken::encode(['email' => (string) $user->email]);

        $this->persistToken($token, $user);

        return $token;
    }

    /** @throws AuthenticationException */
    private function checkPassword(AuthenticatableUser $user, PlainTextPassword $password): void
    {
        if (! Hash::check($password, $user->password)) {
            throw AuthenticationException::invalidEmailOrPassword();
        }
    }

    /** @throws AuthenticationException */
    private function persistToken(JWTToken $token, User $user): void
    {
        try {
            $this->tokenRepository->storeToken($token, UserType::fromUser($user));
        } catch (InvalidUserType $e) {
            Log::error($e->getMessage());

            throw AuthenticationException::cannotLoginUserType();
        }
    }
}
