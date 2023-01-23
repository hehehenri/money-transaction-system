<?php

namespace Src\Infrastructure\Clients\ValueObjects;

use Psr\Http\Message\ResponseInterface;

class JsonResponse
{
    public function __construct(
        public readonly int $status,
        public readonly array $body,
    ) {
    }

    public static function fromResponse(ResponseInterface $response): self
    {
        $body = json_decode($response->getBody(), true);

        return new self(
            $body['status'],
            $body
        );
    }
}
