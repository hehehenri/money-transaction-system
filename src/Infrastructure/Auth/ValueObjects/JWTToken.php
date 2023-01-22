<?php

namespace Src\Infrastructure\Auth\ValueObjects;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Src\User\Domain\ValueObjects\Token;

class JWTToken extends Token
{
    /** @param  array<string, string>  $payload */
    public static function encode(array $payload): self
    {
        /** @var string $key */
        $key = config('auth.jwt.key');
        /** @var string $algorithm */
        $algorithm = config('auth.jwt.algorithm', Algorithm::ES256->value);

        $token = JWT::encode($payload, $key, $algorithm);

        return new self($token);
    }

    /** @return array<string, string> */
    public function decode(): array
    {
        /** @var string $key */
        $key = config('auth.jwt.key');
        /** @var string $algorithm */
        $algorithm = config('auth.jwt.algorithm', Algorithm::ES256->value);

        return (array) JWT::decode($this->value, new Key($key, $algorithm));
    }
}
