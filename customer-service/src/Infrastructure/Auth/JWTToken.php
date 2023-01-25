<?php

namespace Src\Infrastructure\Auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Src\Auth\Domain\ValueObjects\Token;

class JWTToken
{
    /** @param  array<string, string>  $payload */
    public static function encode(array $payload): string
    {
        /** @var string $key */
        $key = config('auth.jwt.key');
        /** @var string $algorithm */
        $algorithm = config('auth.jwt.algorithm', Algorithm::HS256->value);

        return JWT::encode($payload, $key, $algorithm);
    }

    /** @return array<string, string> */
    public static function decode(Token $token): array
    {
        /** @var string $key */
        $key = config('auth.jwt.key');
        /** @var string $algorithm */
        $algorithm = config('auth.jwt.algorithm', Algorithm::HS256->value);

        return (array) JWT::decode($token->token, new Key($key, $algorithm));
    }
}
