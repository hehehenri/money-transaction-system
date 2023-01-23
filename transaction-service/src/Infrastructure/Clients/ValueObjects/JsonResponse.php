<?php

namespace Src\Infrastructure\Clients\ValueObjects;

use Psr\Http\Message\ResponseInterface;
use Src\Infrastructure\Clients\Exceptions\RequestException;

class JsonResponse
{
    /**
     * @param  int  $status
     * @param  array<int|string>  $body
     */
    public function __construct(
        public readonly int $status,
        public readonly array $body,
    ) {
    }

    /** @throws RequestException */
    public static function fromResponse(ResponseInterface $response): self
    {
        /** @var array<string, int|string> $body */
        $body = json_decode($response->getBody(), true);

        $status = $body['status'];

        if (! is_int($status)) {
            throw RequestException::invalidStatusCode();
        }

        return new self(
            $status,
            $body
        );
    }
}
