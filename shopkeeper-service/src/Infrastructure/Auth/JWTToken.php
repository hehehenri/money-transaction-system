<?php

namespace Src\Infrastructure\Auth;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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

    /**
     * @return array<string, string>
     *
     * @throws ExpiredException
     */
    public static function decode(string $token): array
    {
        /** @var string $key */
        $key = config('auth.jwt.key');
        /** @var string $algorithm */
        $algorithm = config('auth.jwt.algorithm', Algorithm::HS256->value);

        if (str_starts_with($token, 'Bearer ')) {
            $token = explode('Bearer ', $token)[1];
        }

        return (array) JWT::decode($token, new Key($key, $algorithm));
    }
}
