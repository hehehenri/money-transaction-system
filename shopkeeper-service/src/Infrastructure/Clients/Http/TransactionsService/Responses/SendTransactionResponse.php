<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService\Responses;

use Psr\Http\Message\ResponseInterface;

class SendTransactionResponse implements Response
{
    public function __construct(public readonly string $message)
    {
    }

    public static function deserialize(ResponseInterface $jsonResponse): Response
    {
        /** @var array{message: string} $response */
        $response = json_decode($jsonResponse->getBody(), true);

        return new self($response['message']);
    }
}
