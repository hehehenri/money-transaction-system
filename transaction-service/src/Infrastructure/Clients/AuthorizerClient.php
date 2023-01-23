<?php

namespace Src\Infrastructure\Clients;

use GuzzleHttp\Client;
use Src\Infrastructure\Clients\Enums\Method;
use Src\Infrastructure\Clients\Exceptions\InvalidURIException;
use Src\Infrastructure\Clients\Exceptions\RequestException;
use Src\Infrastructure\Clients\ValueObjects\URI;

class AuthorizerClient extends BaseClient
{
    /**
     * @throws RequestException
     * @throws InvalidURIException
     */
    public function authorize()
    {
        $uri = new URI(config('transactions.authorizer.uri'));

        $this->send(Method::GET, new URI($uri));
    }
}
