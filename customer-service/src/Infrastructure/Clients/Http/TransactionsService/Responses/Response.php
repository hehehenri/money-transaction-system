<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService\Responses;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

interface Response
{
    public static function deserialize(GuzzleResponse $response): self;
}
