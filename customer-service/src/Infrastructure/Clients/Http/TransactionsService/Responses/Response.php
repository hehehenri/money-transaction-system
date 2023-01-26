<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService\Responses;

use Psr\Http\Message\ResponseInterface;

interface Response
{
    public static function deserialize(ResponseInterface $jsonResponse): self;
}
