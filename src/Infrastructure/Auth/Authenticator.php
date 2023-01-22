<?php

namespace Src\Infrastructure\Auth;

use Illuminate\Support\Facades\Hash;
use Src\Infrastructure\Auth\ValueObjects\JWTToken;
use Src\Infrastructure\Exceptions\AuthenticationException;
use Src\User\Domain\Entities\AuthenticatableUser;
use Src\User\Domain\ValueObjects\PlainTextPassword;

class Authenticator
{
    /** @throws AuthenticationException */
    public function login(AuthenticatableUser $user, PlainTextPassword $password): JWTToken
    {
        $this->checkPassword($user, $password);

        return JWTToken::encode(['email' => (string) $user->email]);
    }

    /** @throws AuthenticationException */
    private function checkPassword(AuthenticatableUser $user, PlainTextPassword $password): void
    {
        if (! Hash::check($password, $user->password)) {
            throw AuthenticationException::invalidEmailOrPassword();
        }
    }
}
